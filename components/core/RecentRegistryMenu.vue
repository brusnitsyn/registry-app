<script setup lang="ts">
type RegistryHeader = {
  id: number
  label: string
}

const router = useRouter()

const props = defineProps<{ items: RegistryHeader[] }>()

const setQuery = (item) => {
  router.push({ name: 'editor', query: { 'header_id': item.id }, replace: true })
}
</script>

<template>
  <div class="flex flex-col border-r">
    <NList hoverable clickable>
      <NListItem v-for="item in items" :key="item.id" @click="setQuery(item)">
        {{ item.label }}
      </NListItem>
    </NList>
  </div>
</template>

<style scoped>

</style>
