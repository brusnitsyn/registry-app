<script setup lang="ts">
import {definePageMeta} from "#imports";
import {IconLink, IconPencil} from "@tabler/icons-vue";

const registryStore = useRegistryStore()
const route = useRoute()

const id = computed(() => route.query.header_id)

if (id.value) await registryStore.fetchZlList(id.value)

const hasShowZglvEditDialog = ref(false)
const hasShowSchetEditDialog = ref(false)

definePageMeta({
  layout: "editor"
})
</script>

<template>
  <div v-if="registryStore.currentZlList" class="container max-w-5xl mx-auto">
    <div class="grid grid-cols-3 gap-x-4">
      <div class="border shadow-sm rounded-md px-4 py-2">
        <div class="flex flex-row justify-between items-center">
          <span class="text-lg font-semibold">Заголовок файла</span>
          <Button variant="ghost" size="icon" @click="hasShowZglvEditDialog = true">
            <IconPencil :size="18" />
          </Button>
        </div>
        <p>
          {{ registryStore.currentZlList?.zglv.filename }}
        </p>
      </div>

      <DialogEditZglv :has-open="hasShowZglvEditDialog" @update:open="value => hasShowZglvEditDialog = value" />

      <div class="border shadow-sm rounded-md px-4 py-2">
        <div class="flex flex-row justify-between items-center">
          <span class="text-lg font-semibold">Счёт</span>
          <Button variant="ghost" size="icon" @click="hasShowSchetEditDialog = true">
            <IconPencil :size="18" />
          </Button>
        </div>
        <p>
          {{ registryStore.currentZlList?.schet.coments }}
        </p>
        <span>{{ registryStore.currentZlList?.schet.summav }}</span>
      </div>

      <DialogEditSchet :has-open="hasShowSchetEditDialog" @update:open="value => hasShowSchetEditDialog = value" />

      <div class="border shadow-sm rounded-md px-4 py-2">
        <div class="flex flex-row justify-between items-center">
          <span class="text-lg font-semibold">Записи случаев</span>
          <Button variant="ghost" size="icon">
            <IconLink :size="18" />
          </Button>
        </div>
        <div class="inline">
          Записей: {{ registryStore.currentZlList?.zglv.sd_z }}
        </div>
      </div>
    </div>
  </div>
  <NuxtPage />
</template>

<style scoped>

</style>
