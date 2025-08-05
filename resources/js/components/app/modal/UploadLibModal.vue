<script setup>
import {FileZip} from "@vicons/tabler";

const show = defineModel('show')
import Modal from "./Modal.vue";
import {useAuthFetch} from "../../../../composables/useAuthFetch.js";

const fileList = ref([])
const clearFileList = () => {
    fileList.value = []
}
const afterHide = () => {
    clearFileList()
}

const errorUpload = ref(null)

const submit = async () => {
    const formData = new FormData()
    formData.append('file', fileList.value[0].file)
    const {data, statusCode, error} = await useAuthFetch(route('api.library.upload')).post(formData)

    console.log(data, statusCode, error)
}
</script>

<template>
    <Modal v-model:show="show">
        <NFlex vertical align="start" :wrap="false" style="width: 100%;">
            <NFlex justify="space-between" align="center" style="width: 100%; height: 64px; padding: 0 16px;">
                <div>Загрузка справочника</div>
            </NFlex>
            <NFlex vertical style="padding: 0 16px 16px; width: 100%; height: 100%;" :wrap="false" justify="space-between">
                <NFlex vertical style="height: 100%;">
                    <NAlert type="info" :show-icon="false" style="width: 100%;">
                        Шаблон для загрузки можно скачать здесь.<br>Столбцы должны быть индентичны свойствам модели
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
                                <NFlex align="center" justify="center" :size="4" style="margin-top: 4px;">
                                    <NTag size="small" strong round>
                                        .xlsx
                                    </NTag>
                                    <NTag size="small" strong round>
                                        .xls
                                    </NTag>
                                    <NTag size="small" strong round>
                                        .csv
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
                <NAlert v-if="errorUpload !== null" :bordered="false" type="error" closable>
                    {{ errorUpload }}
                </NAlert>
            </NFlex>
        </NFlex>
    </Modal>
</template>

<style scoped>

</style>
