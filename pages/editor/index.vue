<script setup lang="ts">
type ZglvRegistry = {
  id:number,
  version:string,
  data:string,
  filename:string,
  filename1:string,
  sd_z:number,
}

type SchetRegistry = {
  id:number,
  code:string,
  code_mo:string,
  year:number,
  month:number,
  nschet:string,
  dschet:string,
  plat:string,
  summav:string,
  coments:string,
}

const registryStore = useRegistryStore()
const route = useRoute()

const id = computed(() => route.query.header_id)

if (id.value) await registryStore.fetchHeader(id.value)

const hasShowZglvEditDialog = ref(false)
const hasShowSchetEditDialog = ref(false)

const currentZglv = ref<ZglvRegistry|null>(null)

const openZglvEditor = (zglv:ZglvRegistry) => {
  currentZglv.value = zglv
  hasShowZglvEditDialog.value = true
}

const currentSchet = ref<SchetRegistry|null>(null)

const openSchetEditor = (schet:SchetRegistry) => {
  currentSchet.value = schet
  console.log(currentSchet.value)
  hasShowSchetEditDialog.value = true
}

const openZaps = async (zl_list_id:number) => {
  await navigateTo({ name: 'editor-zaps', query: { zl_list_id } })
}
</script>

<template>
  <div v-if="registryStore.currentHeader" class="container max-w-5xl mx-auto">
    <NCollapse :default-expanded-names="[0, 1, 2, 3, 4, 5, 6]">
      <NCollapseItem :name="index" :title="`${zlList.zglv.filename} [${zlList.schet.coments}]`" v-for="(zlList, index) in registryStore.currentHeader.zl_lists">
        <div class="grid grid-cols-3 gap-x-4">
          <NCard v-if="zlList.zglv" title="Заголовок файла">
            <template #header-extra>
              <NButton quaternary circle @click="openZglvEditor(zlList.zglv)">
                <template #icon>
                  <NaiveIcon name="tabler:pencil" />
                </template>
              </NButton>
            </template>
            {{ zlList.zglv.filename }}
          </NCard>

          <NCard v-if="zlList.schet" title="Счёт">
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

          <NCard v-if="zlList.schet" title="Записи случаев">
            <template #header-extra>
              <NButton quaternary circle @click="openZaps(zlList.id)">
                <template #icon>
                  <NaiveIcon name="tabler:external-link" />
                </template>
              </NButton>
            </template>
            Записей: {{ zlList.zglv.sd_z }}
          </NCard>
        </div>
      </NCollapseItem>
    </NCollapse>

    <DialogEditZglv :has-open="hasShowZglvEditDialog" @update:open="value => hasShowZglvEditDialog = value" :zglv="currentZglv" />

    <DialogEditSchet :has-open="hasShowSchetEditDialog" @update:open="value => hasShowSchetEditDialog = value" :schet="currentSchet" />
  </div>
</template>

<style scoped>

</style>