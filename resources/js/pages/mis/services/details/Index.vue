<script setup>
import Table from "../../../../components/app/table/Table.vue"
import {router, Head} from "@inertiajs/vue3";
import {useRouterQuery} from "../../../../../composables/useRouterQuery.js";
import {NTag} from 'naive-ui'
import MisLayout from "../../../../layouts/MisLayout.vue";
import FilterDrawer from "./Partials/FilterDrawer.vue";

const props = defineProps({
    department_name: String,
    data: Array,
    pagination: Object
})

const columns = [
    {
        width: 200,
        minWidth: 100,
        maxWidth: 200,
        resizable: true,
        ellipsis: {
            tooltip: true
        },
        title: 'Код услуги',
        key: 'service_medical.FCode_Usl'
    },
    {
        width: 824,
        minWidth: 200,
        maxWidth: 824,
        resizable: true,
        ellipsis: {
            tooltip: true
        },
        title: 'Наименование услуги',
        key: 'service_medical.ServiceMedicalName'
    },
    // {
    //     width: 400,
    //     minWidth: 200,
    //     maxWidth: 400,
    //     resizable: true,
    //     ellipsis: {
    //         tooltip: true
    //     },
    //     title: 'Отделение',
    //     key: 'stationar_branch.department.DepartmentNAME',
    //     hidden: true
    // },
    {
        title: 'Реестр',
        key: 'registry_name',
        render: (row) => {
            return h(
                NTag,
                {
                    round: true,
                    bordered: false,
                    type: row.in_registry ? 'success' : 'warning'
                },
                {
                    default: () => row.registry_name
                }
            )
        }
    }
]

const {query} = useRouterQuery()
const filters = ref({
    has_registry: true
})
const paginator = computed(() => ({
    ...props.pagination,
    onChange: (page) => {
        paginator.value.page = page

        router.get(
            route(route().current()),
            {
                ...query.value,
                page,
            },
            {
                preserveState: true,
                only: ['data', 'pagination']
            }
        )
    },
    onUpdatePageSize: (pageSize) => {
        paginator.value.pageSize = pageSize
        paginator.value.page = 1

        router.get(
            route(route().current()),
            {
                ...query.value,
                per_page: pageSize,
                page: 1,
            },
            {
                preserveState: true,
                only: ['data', 'pagination']
            }
        )
    },
    prefix: () => {
        return h(
            'span',
            {},
            {
                default: () => `Всего услуг: ${props.pagination.total}`
            }
        )
    }
}))
const showDrawer = ref(false)
</script>

<template>
    <Head :title="department_name" />
    <MisLayout :title="department_name">
        <template #header-extension>
            <NButton secondary @click="showDrawer = true" style="--n-border-radius: 8px;">
                Фильтры
            </NButton>
        </template>
        <Table :columns="columns" :data="data" :pagination="paginator" remote max-height="calc(100vh - 190px)" min-height="calc(100vh - 190px)" />
        <FilterDrawer v-model:show="showDrawer" v-model:filters="filters" />
    </MisLayout>
</template>

<style scoped>

</style>
