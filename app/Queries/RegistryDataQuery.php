<?php

namespace App\Queries;

class RegistryDataQuery
{
    public static function getQuery(): string
    {
        return <<<SQL
            WITH registry_types AS (
                SELECT
                    id,
                    type,
                    CASE
                        WHEN type IN ('STAGE1_REPRODUCTIVE', 'STAGE2_REPRODUCTIVE', 'STAGE1_ADVANCED', 'STAGE2_ADVANCED', 'STAGE1_ADULT', 'STAGE2_ADULT', 'ADULT_CHECKUPS') THEN 'adult'
                        WHEN type IN ('MINORS_CHECKUPS', 'ORPHANS_SCREENING', 'WARDS_SCREENING') THEN 'child'
                        ELSE 'unknown'
                        END AS default_category
                FROM registry_zglvs
            ),
                 patient_categories AS (
                     SELECT
                         sl.id,
                         sl.podr,
                         sl.kd,
                         sl.sum_m,
                         sl.fake_podr as department_code,
                         COALESCE(
                                 CASE WHEN sl.det = '1' THEN 'child' WHEN sl.det = '0' THEN 'adult' END,
                                 rt.default_category,
                                 'unknown'
                         ) AS patient_category,
                         rt.type
                     FROM
                         registry_sls sl
                             JOIN
                         registry_zsls zsl ON zsl.id = sl.z_sl_id
                             JOIN
                         registry_zaps zap ON zap.id = zsl.zap_id
                             JOIN
                         registry_types rt ON rt.id = zap.zglv_id
                     WHERE
                         zap.zglv_id IN (?)
                     AND EXISTS (
                        SELECT 1
                        FROM registry_usls u
                        WHERE u.sl_id = sl.id
                        AND u.code_usl LIKE (?)
                    )
                 ),
                 department_mapping AS (
                     SELECT
                         d.podr,
                         d.name,
                         COALESCE(
                                 d.name,
                                 CASE
                                     WHEN d.podr IS NULL THEN 'Не указан код отделения [PODR]'
                                     ELSE d.podr
                                     END
                         ) AS display_name
                     FROM
                         lib_departments d
                 ),
                 usl_stats AS (
                     SELECT
                         pc.id AS sl_id,
                         COUNT(CASE WHEN pc.patient_category = 'child' THEN 1 END) AS child_usl_count,
                         COUNT(CASE WHEN pc.patient_category = 'adult' THEN 1 END) AS adult_usl_count
                     FROM
                         registry_usls u
                     JOIN
                         patient_categories pc ON pc.id = u.sl_id
                     where
                         u.code_usl LIKE (?)
                     GROUP BY
                         pc.id
                 )
            SELECT
                COALESCE(dm.display_name,
                         CASE
                             WHEN pc.department_code IS NULL THEN 'Не указан код отделения [PODR]'
                             ELSE pc.department_code
                             END
                ) AS department_name,
                pc.department_code as department_code,
                COUNT(DISTINCT pc.id) AS total_patients,
                COUNT(DISTINCT CASE WHEN pc.patient_category = 'child' THEN pc.id END) AS child_patients,
                COUNT(DISTINCT CASE WHEN pc.patient_category = 'adult' THEN pc.id END) AS adult_patients,
                SUM(CASE
                        WHEN pc.patient_category = 'child' THEN COALESCE(pc.kd::INTEGER, 0)
                        ELSE 0
                    END) AS child_kd,
                SUM(CASE
                        WHEN pc.patient_category = 'adult' THEN COALESCE(pc.kd::INTEGER, 0)
                        ELSE 0
                    END) AS adult_kd,
                SUM(CASE
                        WHEN pc.patient_category = 'child' THEN pc.sum_m::FLOAT
                        ELSE 0
                    END) AS child_sum,
                SUM(CASE
                        WHEN pc.patient_category = 'adult' THEN pc.sum_m::FLOAT
                        ELSE 0
                    END) AS adult_sum,
                COALESCE(SUM(us.child_usl_count), 0) AS child_usl_total,
                COALESCE(SUM(us.adult_usl_count), 0) AS adult_usl_total,
                STRING_AGG(DISTINCT pc.type, ', ') AS registry_types
            FROM
                patient_categories pc
                    LEFT JOIN
                department_mapping dm ON dm.podr = pc.department_code
                    LEFT JOIN
                usl_stats us ON us.sl_id = pc.id
            GROUP BY
                COALESCE(dm.display_name,
                         CASE
                             WHEN pc.department_code IS NULL THEN 'Не указан код отделения [PODR]'
                             ELSE pc.department_code
                         END
                ),
                pc.department_code
        SQL;
    }
}
