<script setup>
const props = defineProps({
    columns: Array,
    data: Array
})
</script>

<template>
    <NDataTable :columns="columns" :data="data" />
</template>

<style scoped>
:deep(.n-data-table-wrapper) {
    border-radius: 8px !important;
}
</style>
