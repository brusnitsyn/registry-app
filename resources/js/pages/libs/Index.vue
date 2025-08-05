<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from "../../layouts/AppLayout.vue"
import Table from "../../components/app/table/Table.vue"
import UploadLibModal from "../../components/app/modal/UploadLibModal.vue";
defineProps({
    title: String,
    items: Array,
    columns: Array,
    paginate: Object
})

const isShowUploadModal = ref(false)
</script>

<template>
    <Head title="Справочники" />
    <AppLayout :title="title">
        <template #header-extension>
            <NButton type="primary" secondary @click="isShowUploadModal = true">
                Загрузить справочник
            </NButton>
        </template>
        <Table :columns="columns" :data="items" :paginate="paginate" />
        <UploadLibModal v-model:show="isShowUploadModal" />
    </AppLayout>
</template>

<style scoped>

</style>
