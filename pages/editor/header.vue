<script setup lang="ts">
import {useRegistryStore} from "#imports"
import {IconPencil} from '@tabler/icons-vue'


const registryStore = useRegistryStore()
const route = useRoute()

const id = computed(() => route.query.id)

await registryStore.fetchZlList(id.value)

const fetchZlList = async () => {

}
</script>

<template>
  <div class="container max-w-5xl mx-auto">
    {{ registryStore.currentZlList }}
    <div class="grid grid-cols-4">
      <div class="border shadow-sm rounded-md px-4 py-2">
        <div class="flex flex-row justify-between">
          <span class="text-lg font-semibold">Счёт</span>
          <button class="pl-1">
            <IconPencil :size="18" />
          </button>
        </div>
        <p>
          {{ registryStore.currentZlList.schet.coments }}
        </p>
        <pre>{{ registryStore.currentZlList.schet.summav }}</pre>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
