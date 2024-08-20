<script setup lang="ts">
const route = useRoute()
const registryStore = useRegistryStore()
const id = computed(() => route.query.zl_list_id)

if (id.value) await registryStore.fetchZaps(id.value)
</script>

<template>
  <div class="container max-w-5xl mx-auto">
    <NH3>
      {{ registryStore.currentZaps.filename }}
    </NH3>

    <NFlex vertical>
      <NCard :title="zap.n_zap" v-for="zap in registryStore.currentZaps.zaps">

      </NCard>
    </NFlex>
  </div>
</template>

<style scoped>

</style>