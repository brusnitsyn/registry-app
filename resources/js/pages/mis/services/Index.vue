<script setup>
import MisLayout from "../../../layouts/MisLayout.vue";
import Card from "../../../components/app/card/Card.vue";
// import { VisSingleContainer, VisDonut, VisBulletLegend, VisTooltip } from '@unovis/vue'
import {Donut} from "@unovis/ts";
import Table from "../../../components/app/table/Table.vue";
import {Link, Head} from "@inertiajs/vue3";
// import {Link, usePage} from "@inertiajs/vue3";

const props = defineProps({
    stationarServices: Array
})
// const legendItems = computed({
//     get() {
//         return Object.entries(props.servicesWithDepartment).map(([_, data]) => ({
//             name: data.department
//         }))
//     }
// })
// const triggers = { [Donut.selectors.segment]: (d) => `<div style="display: flex; flex-direction: column;">${d.data.department}<br>${d.data.count}</div>` }
const columns = [
    {
        title: 'Отделение',
        key: 'department_name',
        render: (row) => {
            return h(
                Link,
                {
                    href: route('mis.services.details', { department: row.department_id })
                },
                {
                    default: () => row.department_name
                }
            )
        }
    },
    {
        title: 'Пациенты',
        key: 'patients_by_types',
        fixed: 'left',
        children: [
            {
                title: 'Взр.',
                key: 'adult_patient_count',
                width: '6%',
            },
            {
                title: 'Дет.',
                key: 'child_patient_count',
                width: '6%',
            },
        ]
    },
    {
        title: 'Услуги',
        key: 'usls_by_types',
        fixed: 'left',
        children: [
            {
                title: 'Взр.',
                key: 'adult_service_count',
                width: '6%',
            },
            {
                title: 'Дет.',
                key: 'child_service_count',
                width: '6%',
            },
        ]
    },
    {
        title: 'Койко-дни',
        key: 'bed_days_by_types',
        fixed: 'left',
        children: [
            {
                title: 'Взр.',
                key: 'adult_bed_days',
                width: '6%',
            },
            {
                title: 'Дет.',
                key: 'child_bed_days',
                width: '6%',
            },
        ]
    },
    // {
    //     title: 'Сумма',
    //     key: 'sum_by_types',
    //     children: [
    //         {
    //             title: 'Взр.',
    //             key: 'sum_by_types.old',
    //             width: '12%',
    //         },
    //         {
    //             title: 'Дет.',
    //             key: 'sum_by_types.det',
    //             width: '12%',
    //         },
    //     ]
    // },
]
//
// const summary = (pageData) => {
//     return {
//         fixed: 'bottom',
//         department: {
//             value: 'Всего'
//         },
//         'patients_by_types.old': {
//             value: props.statistic['patients_by_types.old']
//         },
//         'patients_by_types.det': {
//             value: props.statistic['patients_by_types.det']
//         },
//         'usls_by_types.old': {
//             value: props.statistic['usls_by_types.old']
//         },
//         'usls_by_types.det': {
//             value: props.statistic['usls_by_types.det']
//         },
//         'bed_days_by_types.old': {
//             value: props.statistic['bed_days_by_types.old']
//         },
//         'bed_days_by_types.det': {
//             value: props.statistic['bed_days_by_types.det']
//         },
//         'sum_by_types.old': {
//             value: props.statistic['sum_by_types.old']
//         },
//         'sum_by_types.det': {
//             value: props.statistic['sum_by_types.det']
//         },
//     }
// }
//
// const sliceType = ref('podr')
// const viewType = ref('trim')
</script>

<template>
    <Head title="Медицинские услуги" />
    <MisLayout title="Медицинские услуги">
        <NFlex>
            <Table :columns="columns" :data="stationarServices" max-height="calc(100vh - 245px)" />
        </NFlex>
    </MisLayout>
</template>

<style scoped>

</style>
