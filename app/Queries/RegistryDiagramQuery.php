<?php

namespace App\Queries;

class RegistryDiagramQuery
{
    public static function getQuery(): string
    {
        return <<<SQL
            WITH
            -- Основные данные с парсингом podr
            base_data AS (
                SELECT
                    sl.id,
                    CASE
                        WHEN sl.fake_podr IS NULL THEN 0
                        WHEN sl.fake_podr ~ '280003(\d)' THEN
                            CAST(SUBSTRING(sl.fake_podr FROM '280003(\d)') as integer)
                        ELSE 0
                        END AS department_type_code,
                    (SELECT COUNT(*) FROM registry_usls WHERE sl_id = sl.id) AS usl_count
                FROM
                    registry_sls sl
                        JOIN
                    registry_zsls zsl ON zsl.id = sl.z_sl_id
                        JOIN
                    registry_zaps zap ON zap.id = zsl.zap_id
                WHERE
                    zap.zglv_id IN (?)
            ),

            -- Общее количество услуг для расчета процентов
            total_usl AS (
                SELECT SUM(usl_count) AS total FROM base_data
            )

            -- Финальный результат с присоединением данных из lib_department_type
            SELECT
                dt.name as department,
                SUM(bd.usl_count) AS count,
                CASE
                    WHEN (SUM(bd.usl_count) * 100.0 / (SELECT total FROM total_usl)) < 0.10
                        THEN ROUND((SUM(bd.usl_count) * 100.0 / (SELECT total FROM total_usl)) * 40, 2)
                    WHEN (SUM(bd.usl_count) * 100.0 / (SELECT total FROM total_usl)) < 1.0
                        THEN ROUND((SUM(bd.usl_count) * 100.0 / (SELECT total FROM total_usl)) * 20, 2)
                    ELSE ROUND((SUM(bd.usl_count) * 100.0 / (SELECT total FROM total_usl)), 2)
                    END AS percentage
            FROM
                base_data bd
                    LEFT JOIN
                lib_department_types dt ON dt.code = cast(bd.department_type_code as integer)
            GROUP BY
                dt.name
            ORDER BY
                count DESC;
        SQL;

    }
}
