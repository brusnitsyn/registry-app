<script setup>
import {X} from "@vicons/tabler";

const show = defineModel('show')
const attrs = useAttrs()
const styleSidebar = computed(() => sidebar.value)
const currentWidth = computed(() => attrs.sidebar ? 'max-width: 800px;' : 'max-width: 640px;')
const styleModal = ref([
    'display: flex;',
    '--sidebar-width: 256px;',
    'background-color: var(--body-color);',
    currentWidth.value,
    'width: 100%;',
    'border-radius: 8px;',
    'height: 100svh;',
    'max-height: 500px;',
    'border-width: 1px;',
    'border-color: var(--border-color);'
])
const sidebar = ref([
    'width: var(--sidebar-width);',
    'background-color: var(--tab-color);',
    'border-radius: 8px 0 0 8px;',
    'padding: 8px 12px;',
])
const emits = defineEmits(['submit', 'afterHide'])

const submit = async () => {
    emits('submit')
}
const afterHide = async () => {
    emits('afterHide')
}
</script>

<template>
    <NModal v-model:show="show" :on-after-hide="afterHide">
        <NEl :style="`${currentWidth.value} width: 100%; max-height: 500px; position: relative;`">
            <div :style="styleModal">
                <div v-if="$attrs.sidebar" :style="styleSidebar">
                    sidebar
                </div>
                <slot />
            </div>
            <NButton text style="position: absolute; right: 16px; top: 16px;" @click="show = false">
                <NIcon :component="X" size="16" />
            </NButton>
        </NEl>
    </NModal>
</template>

<style scoped>
:deep(.n-upload-trigger) {
    height: 100%;
}
</style>
