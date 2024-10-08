<script setup lang="ts">
import type {FormInst, UploadFileInfo} from "naive-ui"
import {
  IconFileZip
} from "@tabler/icons-vue";

const open = defineModel()
const pending = ref(false)
const formRef = ref<FormInst|null>(null)
const formModel = ref({
  label: '',
  file: []
})

function attachFile(options: { file: UploadFileInfo, fileList: Array<UploadFileInfo> }) {
  if (options.fileList.length)
    formModel.value.file = options.file.file
  else
    formModel.value.file = null
}

async function uploadRegistry() {
  pending.value = true
  const formData = new FormData()
  formData.append('label', formModel.value.label)
  formData.append('file', formModel.value.file)

  const { data, status } = await useAPI('/api/registry/upload', {
    method: 'post',
    body: formData
  })

  if (status.value === 'success') {
    pending.value = false
    open.value = false
  }
}
</script>

<template>
  <NModal :mask-closable="false" v-model:show="open" preset="card" class="w-2/5" title="Загрузка реестра">
    <NForm :model="formModel">
      <NGrid cols="2">
        <NFormItemGi label="Наименование реестра">
          <NInput v-model:value="formModel.label" />
        </NFormItemGi>

        <NFormItemGi span="2" :show-label="false">
          <NUpload directory-dnd custom-request="" :default-upload="false" :max="1" @change="attachFile">
            <NUploadDragger>
              <div style="margin-bottom: 12px">
                <NIcon size="48" :depth="3" :component="IconFileZip" />
              </div>
              <NText style="font-size: 16px">
                Нажмите или перетащите архив в эту область, чтобы загрузить
              </NText>
            </NUploadDragger>
          </NUpload>
        </NFormItemGi>
      </NGrid>
      <NFlex justify="end">
        <NButton type="primary" @click="uploadRegistry">
          Загрузить
        </NButton>
      </NFlex>
    </NForm>
  </NModal>
</template>

<style scoped>

</style>