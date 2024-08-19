<script setup lang="ts">
const { client } = useSanctumFetch()

const { data: registryHeaders } = await useAsyncData('headers', () => client('/api/registry/headers'))
</script>

<template>
  <div class="grid grid-rows-[auto_1fr_auto] h-screen max-h-screen">
    <div class="border-b">
      поиск и пр
    </div>
    <div class="grid grid-cols-[auto_1fr]">
      <CoreRecentRegistryMenu :items="registryHeaders?.data" />

      <div class="p-4">
        <slot />
      </div>
    </div>
    <div class="border-t">
      статус
    </div>
  </div>
</template>

<style scoped>

</style>
