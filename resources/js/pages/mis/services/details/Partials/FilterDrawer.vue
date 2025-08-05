<script setup>
const show = defineModel('show')
const filters = defineModel('filters')
const emits = defineEmits(['submit'])
</script>

<template>
    <NDrawer v-model:show="show" placement="right" width="20%" :mask-closable="false">
        <NDrawerContent title="Фильтры" closable>
            <NForm id="filters-form" @submit.prevent="emits('submit')">
                <NGrid cols="2">
                    <NFormItemGi span="2" label="Отображение">
                        <NSelect v-model:value="filters.select_view" :options="filters.options.views" filterable />
                    </NFormItemGi>
<!--                    <NFormItemGi span="2" label-placement="left" label="Отображать услуги попавшие в реестр">-->
<!--                        <NSwitch v-model:value="filters.has_registry" />-->
<!--                    </NFormItemGi>-->
                </NGrid>
            </NForm>
            <template #footer>
                <NButton form="filters-form" type="primary" secondary block>
                    Применить
                </NButton>
            </template>
        </NDrawerContent>
    </NDrawer>
</template>

<style scoped>

</style>
