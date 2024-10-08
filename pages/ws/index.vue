<script setup lang="ts">
import {useZlListRegistryStore} from "~/stores/zlListRegistry"
import {
    IconPencil,
    IconExternalLink
} from '@tabler/icons-vue'
import {NButton} from "naive-ui"

const route = useRoute()
const registryId = route.query.registryId
const zlListStore = useZlListRegistryStore()
const { getAllZlListForHeaderId } = zlListStore
const { zlLists } = storeToRefs(zlListStore)
const hasShowSchetEditDialog = ref(false)
const hasShowZglvEditDialog = ref(false)
const currentSchet = ref(null)
const currentZglv = ref(null)

await getAllZlListForHeaderId(route.query.registryId)

const openZglvEditor = (zglv:ZglvRegistry) => {
  currentZglv.value = zglv
  hasShowZglvEditDialog.value = true
}

const openSchetEditor = (schet:SchetRegistry) => {
  currentSchet.value = schet
  hasShowSchetEditDialog.value = true
}

const openZaps = async (zlListId:number) => {
  await navigateTo({ name: 'ws-zaps', query: { zlListId, registryId } })
}

const openErrors = async (zlListId:number) => {
  await navigateTo({ name: 'editor-errors', query: { zlListId, registryId } })
}

definePageMeta({
  layout: 'workspace'
})
</script>

<template>
  <div class="container max-w-6xl py-8">
    <NCollapse>
      <NCollapseItem :name="index" :title="`${zlList.zglv.filename} [${zlList.schet.coments}]`" v-for="(zlList, index) in zlLists.zl_lists">
        <div class="grid grid-cols-3 gap-4">
          <NCard v-if="zlList.zglv" size="medium" title="Заголовок файла">
            <template #header-extra>
              <NButton quaternary circle @click="openZglvEditor(zlList.zglv)">
                <template #icon>
                  <NIcon :component="IconPencil" />
                </template>
              </NButton>
            </template>
            {{ zlList.zglv.filename }}
          </NCard>

          <NCard v-if="zlList.schet" size="medium" title="Счёт">
            <template #header-extra>
              <NButton quaternary circle @click="openSchetEditor(zlList.schet)">
                <template #icon>
                  <NIcon :component="IconPencil" />
                </template>
              </NButton>
            </template>
            <p>
              {{ zlList.schet.summav }}
            </p>
            <p>
              {{ zlList.schet.coments }}
            </p>
          </NCard>

          <NCard v-if="zlList.schet" size="medium" title="Записи случаев">
            <template #header-extra>
              <NButton quaternary circle @click="openZaps(zlList.id)">
                <template #icon>
                  <NIcon :component="IconExternalLink" />
                </template>
              </NButton>
            </template>
            Записей: {{ zlList.zglv.sd_z }}
          </NCard>

<!--          <NCard size="medium" title="Ошибки">-->
<!--            <template #header-extra>-->
<!--              <NButton quaternary circle @click="openErrors(zlList.id)">-->
<!--                <template #icon>-->
<!--                  <NIcon :component="IconExternalLink" />-->
<!--                </template>-->
<!--              </NButton>-->
<!--            </template>-->
<!--            <template v-if="zlList.flk_p">-->
<!--              {{ zlList.flk_p.fname }}-->
<!--            </template>-->
<!--            <NButton v-else text>-->
<!--              Загрузить файл-->
<!--            </NButton>-->
<!--          </NCard>-->
        </div>
      </NCollapseItem>
    </NCollapse>
  </div>

  <DialogEditZglv :has-open="hasShowZglvEditDialog" @update:open="value => hasShowZglvEditDialog = value" :zglv="currentZglv" />

  <DialogEditSchet :has-open="hasShowSchetEditDialog" @update:open="value => hasShowSchetEditDialog = value" :schet="currentSchet" />
</template>

<style scoped>

</style>