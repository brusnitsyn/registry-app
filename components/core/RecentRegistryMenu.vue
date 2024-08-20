<script setup lang="ts">
type RegistryHeader = {
  id: number
  label: string
}

const props = defineProps<{ items: RegistryHeader[] }>()
</script>

<template>
  <div class="flex flex-col border-r p-2">
    <ul class="flex flex-col gap-y-2">
      <li v-for="item in items">
        <NuxtLink class="block px-2 py-1.5 border rounded-md shadow-sm select-none" :to="{name: 'editor', query: { header_id: item.id }}">
          {{ item.label }}
        </NuxtLink>
      </li>
    </ul>
  </div>
</template>

<style scoped>

</style>
