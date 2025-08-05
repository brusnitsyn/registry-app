<script setup>
import AppLayout from "../../layouts/AppLayout.vue";
import Card from "../../components/app/card/Card.vue";
import { VisSingleContainer, VisDonut, VisBulletLegend, VisTooltip } from '@unovis/vue'
import {Donut} from "@unovis/ts";
import Table from "../../components/app/table/Table.vue";
import {Link, router, usePage} from "@inertiajs/vue3";
import SearchInput from "../../components/app/input/SearchInput.vue";
import {useRouterQuery} from "../../../composables/useRouterQuery.js";

const props = defineProps({
    chartData: Array,
    servicesWithDepartment: Array,
    servicesInPodr: Array,
    serviceCount: Number,
    statistic: Array
})
const legendItems = computed({
    get() {
        return Object.entries(props.servicesWithDepartment).map(([_, data]) => ({
            name: data.department
        }))
    }
})
const triggers = { [Donut.selectors.segment]: (d) => `<div style="display: flex; flex-direction: column;">${d.data.department}<br>${d.data.count}</div>` }
const columns = [
    {
        title: 'Отделение',
        key: 'department',
        width: '50%',
        render: (row) => {
            return h(
                Link,
                {
                    href: route('registry.services.details', {...usePage().props.router.query, 'podr': row.department_code})
                },
                {
                    default: () => row.department
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
                key: 'patients_by_types.old',
                width: '7%',
            },
            {
                title: 'Дет.',
                key: 'patients_by_types.det',
                width: '7%',
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
                key: 'usls_by_types.old',
                width: '7%',
            },
            {
                title: 'Дет.',
                key: 'usls_by_types.det',
                width: '7%',
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
                key: 'bed_days_by_types.old',
                width: '7%',
            },
            {
                title: 'Дет.',
                key: 'bed_days_by_types.det',
                width: '7%',
            },
        ]
    },
    {
        title: 'Сумма',
        key: 'sum_by_types',
        children: [
            {
                title: 'Взр.',
                key: 'sum_by_types.old',
                width: '14%',
            },
            {
                title: 'Дет.',
                key: 'sum_by_types.det',
                width: '14%',
            },
        ]
    },
]

const summary = (pageData) => {
    return {
        fixed: 'bottom',
        department: {
            value: 'Всего'
        },
        'patients_by_types.old': {
            value: props.statistic['patients_by_types.old']
        },
        'patients_by_types.det': {
            value: props.statistic['patients_by_types.det']
        },
        'usls_by_types.old': {
            value: props.statistic['usls_by_types.old']
        },
        'usls_by_types.det': {
            value: props.statistic['usls_by_types.det']
        },
        'bed_days_by_types.old': {
            value: props.statistic['bed_days_by_types.old']
        },
        'bed_days_by_types.det': {
            value: props.statistic['bed_days_by_types.det']
        },
        'sum_by_types.old': {
            value: props.statistic['sum_by_types.old']
        },
        'sum_by_types.det': {
            value: props.statistic['sum_by_types.det']
        },
    }
}

const searchValue = ref('')
const { value: search } = useRouterQuery('search')
const searchComputed = computed({
    get: () => {
        return search.value
    },
    set: (value) => {
        searchValue.value
    }
})

const onHandleSearch = (search) => {
    router.reload({
        data: {
            search
        },
        replace: true
    })
}
</script>

<template>
    <AppLayout title="Медицинские услуги">
        <NGrid :cols="4" y-gap="16" x-gap="16" style="height: auto;">
            <NGi>
                <div>
                    <Card :title="`Общее количество услуг: ${serviceCount}`">
                        <VisBulletLegend :items="legendItems" />
                        <VisSingleContainer :data="servicesWithDepartment" :height="400">
                            <VisTooltip :triggers="triggers" />
                            <VisDonut :value="(d) => d.percentage"
                                      :showEmptySegments="false"
                                      :arcWidth="0"/>
                        </VisSingleContainer>
                    </Card>
                </div>
            </NGi>
            <NGi span="3">
                <NSpace vertical>
<!--                    <NForm :show-feedback="false" label-placement="left">-->
<!--                        <NFlex justify="space-between">-->
<!--                            <NFormItem label="Разрез по:">-->
<!--                                <NRadioGroup v-model:value="sliceType" size="small">-->
<!--                                    <NRadioButton value="podr">-->
<!--                                        Коду отделения-->
<!--                                    </NRadioButton>-->
<!--                                    <NRadioButton value="department">-->
<!--                                        Типу услуг-->
<!--                                    </NRadioButton>-->
<!--                                </NRadioGroup>-->
<!--                            </NFormItem>-->
<!--                            <NFormItem label="Вид:">-->
<!--                                <NRadioGroup v-model:value="viewType" size="small">-->
<!--                                    <NRadioButton value="full">-->
<!--                                        Развернутый-->
<!--                                    </NRadioButton>-->
<!--                                    <NRadioButton value="trim">-->
<!--                                        Сжатый-->
<!--                                    </NRadioButton>-->
<!--                                </NRadioGroup>-->
<!--                            </NFormItem>-->
<!--                        </NFlex>-->
<!--                    </NForm>-->
                    <SearchInput v-model:search="searchComputed" @searched="onHandleSearch" placeholder="Поиск услуги по коду в отделении" />
                    <Table :columns="columns" :data="servicesInPodr" :summary="summary" max-height="calc(100vh - 245px)" />
                </NSpace>
            </NGi>
        </NGrid>
    </AppLayout>
</template>

<style scoped>

</style>
