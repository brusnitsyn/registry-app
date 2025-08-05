<script setup>
import AppLayout from "../../layouts/AppLayout.vue"
import Table from "../../components/app/table/Table.vue"
import {Head, router, usePage} from "@inertiajs/vue3";
import {useRouterQuery} from "../../../composables/useRouterQuery.js";
import Card from "../../components/app/card/Card.vue";
import SearchInput from "../../components/app/input/SearchInput.vue";
import FilterDrawer from "../mis/services/details/Partials/FilterDrawer.vue";

const props = defineProps({
    department_name: String,
    usls: Array,
    pagination: Object,
    widgets: Array
})

const columns = [
    {
        title: 'Код услуги',
        key: 'usl',
        width: '10%',
    },
    {
        title: 'Наименование услуги',
        key: 'usl_name'
    },
    {
        title: 'Количество',
        fixed: 'left',
        key: 'usls',
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
        title: 'Сумма',
        key: 'costs',
        fixed: 'left',
        children: [
            {
                title: 'Взр.',
                key: 'adult_usl_costs',
                width: '12%',
            },
            {
                title: 'Дет.',
                key: 'child_usl_costs',
                width: '12%',
            },
        ]
    },
]

const {query} = useRouterQuery()
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
                only: ['usls', 'pagination']
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
                only: ['usls', 'pagination']
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
const typeService = ref('all')
const tableLoading = ref(false)
const blockRef = ref(null)
const blockHeight = computed(() => {
    return blockRef.value === null ? 100 : blockRef?.value.$el.clientHeight + 248
})

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
    tableLoading.value = true
    router.reload({
        data: {
            search
        },
        replace: true
    })
    tableLoading.value = false
}
const showDrawer = ref(false)
const filters = ref({
    options: {
        views: [
            { label: 'Все услуги', value: 'all' },
            { label: 'Только разовые услуги', value: 'single' },
            { label: 'Только операции', value: 'surgical' },
        ]
    },
    select_view: null
})
</script>

<template>
    <Head :title="department_name" />
    <AppLayout :title="department_name">
        <NFlex vertical>
            <NSpace ref="blockRef" vertical>
                <NGrid cols="5" x-gap="8">
                    <NGi v-for="widget in widgets">
                        <Card>
                            <NFlex :size="0" justify="space-between">
                                <NSpace :size="0" vertical>
                                    <NText>
                                        {{ widget.title }}
                                    </NText>
                                    <NH2 style="margin-top: 0; margin-bottom: 0;">
                                        {{ widget.count }}
                                    </NH2>
                                </NSpace>
                            </NFlex>
                        </Card>
                    </NGi>
                </NGrid>
                <NGrid cols="2">
                    <NGi>
                        <SearchInput v-model:search="searchComputed" :loading="tableLoading" @searched="onHandleSearch" placeholder="Поиск услуги по коду в отделении" />
                    </NGi>
                    <NGi>
                        <NFlex justify="end">
                            <NButton size="large" secondary @click="showDrawer = true" style="--n-border-radius: 8px;">
                                Фильтры
                            </NButton>
                        </NFlex>
                    </NGi>
                </NGrid>
            </NSpace>
            <Table :loading="tableLoading" :columns="columns" :data="usls" :pagination="paginator" remote :max-height="`calc(100vh - ${blockHeight}px)`" />
        </NFlex>
        <FilterDrawer v-model:show="showDrawer" v-model:filters="filters" />
    </AppLayout>
</template>

<style scoped>

</style>
