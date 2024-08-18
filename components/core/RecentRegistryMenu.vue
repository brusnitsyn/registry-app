<script setup lang="ts">
type RegistryHeader = {
  id: number
  version: string
  date: string
  filename: string
  filename1: string
  sd_z: bigint
}

const props = defineProps<{ items: RegistryHeader[] }>()
</script>

<template>
  <div class="flex flex-col border-r p-2">
    <ul class="flex flex-col gap-y-4">
      <li v-for="item in items">
        <NuxtLink class="block px-2 py-1.5 border rounded-md shadow-sm select-none" :to="{name: 'editor-header', query: { id: item.id }}">
          {{ item.filename }}
        </NuxtLink>
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>
