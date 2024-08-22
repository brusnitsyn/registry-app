<script setup lang="ts">
const route = useRoute()
const registryStore = useRegistryStore()
const id = computed(() => route.query.zl_list_id)
const loadingFetch = ref(false)

if (id.value) await registryStore.fetchZaps(id.value)

const getTitleCard = (zap) => {
  return `${zap.n_zap} — ${zap.pers.fam} ${zap.pers.im} ${zap.pers.ot}`
}

const currentPage = computed({
  get() {
    registryStore.currentZaps.meta.current_page
  },
  async set(value) {
    await registryStore.fetchZaps(id.value, value)
  }
})
</script>

<template>
  <div class="grid grid-rows-[auto_1fr_auto] h-full">

    <div class="container max-w-5xl mx-auto py-4">
      <NInputGroup>
        <NInput v-model:value="search" placeholder="Поиск записи" />
        <NButton>
          Найти
        </NButton>
      </NInputGroup>
    </div>

    <div class="overflow-hidden">
      <NScrollbar>
        <NSpace class="container max-w-5xl mx-auto" vertical>
          <NCard :title="getTitleCard(zap)" v-for="zap in registryStore.currentZaps.data" :key="zap.id">

          </NCard>
        </NSpace>
      </NScrollbar>
    </div>

    <div class="container max-w-5xl mx-auto py-4">
      <NPagination v-model:page="currentPage" :page-count="registryStore.currentZaps.meta.last_page" />
    </div>
  </div>
</template>

<style scoped>

</style>