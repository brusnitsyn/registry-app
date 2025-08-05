<script setup>
import {useFetch, useLocalStorage} from "@vueuse/core";
import {FileZip, X} from "@vicons/tabler";
import { useEcho } from "@laravel/echo-vue";

const socketsMessage = ref({})
useEcho(
    'progress-parsing',
    'ProgressParsing',
    (e) => {
        if (e.finally) {
            clearFileList()
        }
        socketsMessage.value = e
    },
    undefined,
    'public'
)

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
    socketsMessage.value = {}
}

const errorUpload = ref(null)

const submit = async () => {
    errorUpload.value = null
    const formData = new FormData()
    formData.append('registry', fileList.value[0].file)
    const { isFetching, error, data, statusCode } = await useFetch('/api/registry/parse').post(formData).json()

    if (statusCode.value === 500) {
        errorUpload.value = 'Ошибка при отправке файла'
    }
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
                    <NFlex vertical style="padding: 0 16px 16px; width: 100%; height: 100%;" :wrap="false" justify="space-between">
                        <NFlex vertical style="height: 100%;">
                            <NAlert type="info" :show-icon="false" style="width: 100%;">
                                Загружайте реестр без изменений, для сохранения связей с МИС
                            </NAlert>
                            <NUpload v-if="fileList.length === 0" style="height: 100%;" directory-dnd :show-file-list="false" v-model:file-list="fileList">
                                <NUploadDragger style="height: 100%;">
                                    <NFlex vertical :size="0" align="center" justify="center" style="height: 100%;">
                                        <div style="margin-bottom: 8px">
                                            <NIcon :component="FileZip" size="48" :depth="3" />
                                        </div>
                                        <NText style="font-size: 16px">
                                            Кликните или перенесите файл в эту область
                                        </NText>
                                        <NP depth="3" style="margin: 0">
                                            Поддерживаемые форматы файла
                                        </NP>
                                        <NFlex align="center" justify="center" style="margin-top: 4px;">
                                            <NTag size="small" strong round>
                                                .zip
                                            </NTag>
                                            <NTag size="small" strong round>
                                                .xml
                                            </NTag>
                                        </NFlex>
                                    </NFlex>
                                </NUploadDragger>
                            </NUpload>
                            <NFlex align="center" justify="center" style="height: 100%;" v-else>
                                <NSpace vertical justify="center" align="center" style="height: 100%;" :size="0">
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
                            </NFlex>
                        </NFlex>
                        <NAlert v-if="Object.keys(socketsMessage).length > 0" :bordered="false" :type="socketsMessage.type">
                            <template v-if="socketsMessage.loading" #icon>
                                <NIcon>
                                    <NSpin :size="16" :show="socketsMessage.loading" stroke="var(--n-icon-color)" />
                                </NIcon>
                            </template>
                            {{ socketsMessage.message }}
                        </NAlert>
                        <NAlert v-if="errorUpload" :bordered="false" type="error" closable>
                            {{ errorUpload }}
                        </NAlert>
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
:deep(.n-upload-trigger) {
    height: 100%;
}
</style>
