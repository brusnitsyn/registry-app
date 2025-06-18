<script setup>
import {useFetch, useLocalStorage} from "@vueuse/core";
import {FileZip, X} from "@vicons/tabler";

const show = defineModel('show')
const attrs = useAttrs()
const theme = useLocalStorage('theme', 'dark')
const isDark = computed(() => theme.value === 'dark')
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
const fileList = ref([])
const clearFileList = () => {
    fileList.value = []
}
const afterHide = () => {
    clearFileList()
}
const submit = () => {
    const formData = new FormData()
    formData.append('registry', fileList.value[0].file)
    const { isFetching, error, data } = useFetch('/api/registry/parse').post(formData).json()
}
</script>

<template>
    <NModal v-model:show="show" :on-after-hide="afterHide">
        <NEl :style="`${currentWidth.value} width: 100%; max-height: 500px; position: relative;`">
            <div :style="styleModal">
                <div v-if="$attrs.sidebar" :style="styleSidebar">
                    sidebar
                </div>
                <NFlex vertical align="start" :wrap="false" style="width: 100%;">
                    <NFlex justify="space-between" align="center" style="width: 100%; height: 64px; padding: 0 16px;">
                        <div>Загрузка реестра</div>
                    </NFlex>
                    <NFlex vertical style="padding: 0 16px; width: 100%" :wrap="false">
                        <NAlert type="info" :show-icon="false" style="width: 100%;">
                            Загружайте реестр без изменений, для сохранения связей с МИС
                        </NAlert>
                        <NUpload v-if="fileList.length === 0" directory-dnd :show-file-list="false" v-model:file-list="fileList">
                            <NUploadDragger>
                                <div style="margin-bottom: 12px">
                                    <NIcon :component="FileZip" size="48" :depth="3" />
                                </div>
                                <NText style="font-size: 16px">
                                    Кликните или перенесите файл в эту область
                                </NText>
                                <NP depth="3" style="margin: 8px 0 0 0">
                                    Поддерживаемые форматы файла
                                </NP>
                                <NFlex align="center" justify="center" style="margin-top: 4px;">
                                    <NTag size="small" strong round>
                                        .zip
                                    </NTag>
                                </NFlex>
                            </NUploadDragger>
                        </NUpload>
                        <div style="margin-top: 18px;" v-else>
                            <NSpace vertical align="center" :size="0">
                                <div style="margin-bottom: 12px">
                                    <NIcon :component="FileZip" size="48" :depth="3" />
                                </div>
                                <NText style="font-size: 16px">
                                    {{ fileList[0].name }}
                                </NText>
                                <NP depth="3" style="margin: 8px 0 0 0">
                                    Файл готов к загрузке
                                </NP>
                                <NButton text size="small" @click="clearFileList">
                                    Выбрать другой файл
                                </NButton>
                                <NButton secondary style="margin-top: 16px;" size="small" block @click="submit">
                                    Загрузить
                                </NButton>
                            </NSpace>
                        </div>
                    </NFlex>
                </NFlex>
            </div>
            <NButton text style="position: absolute; right: 16px; top: 16px;" @click="show = false">
                <NIcon :component="X" size="16" />
            </NButton>
        </NEl>
    </NModal>
</template>

<style scoped>

</style>
