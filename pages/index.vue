<script setup lang="ts">
import {useHeaderRegistryStore} from "~/stores/headerRegistry"
import {
    IconFileUpload,
    IconTrash,
    IconFileDownload,
    IconLink,
    IconDots,
    IconSearch,
    IconArrowRight,
    IconListDetails
} from '@tabler/icons-vue'
import type { Component } from 'vue'
import { NIcon } from 'naive-ui'
const headerRegistryStore = useHeaderRegistryStore()

const { registryHeaders } = storeToRefs(headerRegistryStore)
const { getAllRegistryHeader, deleteRegistryHeader } = headerRegistryStore
const message = useMessage()
const dialog = useDialog()

await getAllRegistryHeader()

function renderIcon(icon: Component) {
  return () => {
    return h(NIcon, null, {
      default: () => h(icon)
    })
  }
}

async function goToRegistry(registryId: number) {
  await useRouter().push({
    name: 'ws',
    query: {
      registryId
    }
  })
}

async function deleteRegistry(headerRegistryId: number) {
  dialog.warning({
    title: 'Удаление реестра',
    content: 'Вы действительно хотите удалить реестр?',
    positiveText: 'Да',
    negativeText: 'Отмена',
    onPositiveClick: async () => {
      const hasDeleted = await deleteRegistryHeader(headerRegistryId)
      if (hasDeleted) {
        message.success('Реестр был удален')
      }
    },
  })

}

const registryOptions = [
  {
    key: 'upload-paid',
    label: 'Загрузить файл оплаты',
    icon: renderIcon(IconFileUpload),
  },
  {
    key: 'download',
    label: 'Выгрузить',
    icon: renderIcon(IconFileDownload),
  },
  {
    key: 'd1',
    type: 'divider'
  },
  {
    key: 'remove',
    label: 'Удалить',
    icon: renderIcon(IconTrash),
  },
]

function optionSelect(key: string|number, headerRegistryId:number) {
  switch (key) {
    case 'remove':
      deleteRegistry(headerRegistryId)
      break
  }
}

const openCreateModal = ref(false)

function searchRegistry() {

}
</script>

<template>
  <div class="container max-w-4xl py-4 pt-32">

    <NSpace vertical>
      <NSpace vertical>
        <NButton type="primary" @click="openCreateModal = true">
          Загрузить реестр
        </NButton>
        <NFlex>
          <n-input-group>
            <n-input v-model:value="searchRegistryValue" :disabled="status === 'pending'" size="large" placeholder="Поиск реестра по наименованию" @keydown.enter.prevent="searchRegistry" />
            <n-button :disabled="status === 'pending'" size="large" @click="searchRegistry">
              <template #icon>
                <NIcon :depth="3" :component="IconSearch" />
              </template>
            </n-button>
          </n-input-group>
        </NFlex>
      </NSpace>

      <NList bordered>
        <NListItem v-for="registryHeader in registryHeaders">
          <NThing :title="registryHeader.label">
            <template #header-extra>
              <NSpace horizontal>
<!--                <NButton circle size="small" @click="goToRegistry(registryHeader.id)">-->
<!--                  <template #icon>-->
<!--                    <NIcon :component="IconLink" />-->
<!--                  </template>-->
<!--                </NButton>-->
                <NDropdown trigger="click" :options="registryOptions" placement="bottom-end" @select="key => optionSelect(key, registryHeader.id)">
                  <NButton circle size="small">
                    <template #icon>
                      <NIcon :component="IconDots" />
                    </template>
                  </NButton>
                </NDropdown>
              </NSpace>
            </template>
            <template #description>
              <NSpace size="small" class="mt-2">
                <NTag :bordered="true" type="info" size="small">
                  ТМ:МИС
                </NTag>
              </NSpace>
            </template>
            <template #action>
              <NButton secondary @click="goToRegistry(registryHeader.id)">
                <template #default>
                  Перейти в реестр
                </template>
                <template #icon>
                  <NIcon :component="IconListDetails" />
                </template>
              </NButton>
            </template>
          </NThing>
        </NListItem>
      </NList>
    </NSpace>

    <DialogCreateRegistry v-model="openCreateModal" />
  </div>
</template>

<style scoped>

</style>