<script setup lang="ts">
import {useZlListRegistryStore} from "~/stores/zlListRegistry";

const route = useRoute()
const zlListStore = useZlListRegistryStore()
const {getAllZlListForHeaderId} = zlListStore
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
  await navigateTo({ name: 'ws-zaps', query: { zlListId } })
}

const openErrors = async (zlListId:number) => {
  await navigateTo({ name: 'editor-errors', query: { zlListId } })
}
</script>

<template>
  <div class="container max-w-6xl py-8">
    <NCollapse :default-expanded-names="[0, 1, 2, 3, 4, 5, 6, 7]">
      <NCollapseItem :name="index" :title="`${zlList.zglv.filename} [${zlList.schet.coments}]`" v-for="(zlList, index) in zlLists.zl_lists">
        <div class="grid grid-cols-3 gap-4">
          <NCard v-if="zlList.zglv" size="medium" title="Заголовок файла">
            <template #header-extra>
              <NButton quaternary circle @click="openZglvEditor(zlList.zglv)">
                <template #icon>
                  <NaiveIcon name="tabler:pencil" />
                </template>
              </NButton>
            </template>
            {{ zlList.zglv.filename }}
          </NCard>

          <NCard v-if="zlList.schet" size="medium" title="Счёт">
            <template #header-extra>
              <NButton quaternary circle @click="openSchetEditor(zlList.schet)">
                <template #icon>
                  <NaiveIcon name="tabler:pencil" />
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
                  <NaiveIcon name="tabler:external-link" />
                </template>
              </NButton>
            </template>
            Записей: {{ zlList.zglv.sd_z }}
          </NCard>

          <NCard size="medium" title="Ошибки">
            <template #header-extra>
              <NButton quaternary circle @click="openErrors(zlList.id)">
                <template #icon>
                  <NaiveIcon name="tabler:external-link" />
                </template>
              </NButton>
            </template>
            <template v-if="zlList.flk_p">
              {{ zlList.flk_p.fname }}
            </template>
            <NButton v-else text>
              Загрузить файл
            </NButton>
          </NCard>
        </div>
      </NCollapseItem>
    </NCollapse>
  </div>

  <DialogEditZglv :has-open="hasShowZglvEditDialog" @update:open="value => hasShowZglvEditDialog = value" :zglv="currentZglv" />

  <DialogEditSchet :has-open="hasShowSchetEditDialog" @update:open="value => hasShowSchetEditDialog = value" :schet="currentSchet" />
</template>

<style scoped>

</style>