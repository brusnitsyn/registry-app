<script setup lang="ts">
import { IconChevronLeft } from '@tabler/icons-vue'
const route = useRoute()
const zlListId = route.query.zlListId ?? 1
const zapId = route.query.zapId ?? 1
const zapRegistryStore = useZapRegistryStore()

const { getZap } = zapRegistryStore
const { zap } = storeToRefs(zapRegistryStore)

await getZap(zapId)

const editorValue = computed(() => zap.value)

const editorOptions = {
  autoIndent: 'full',
  contextmenu: false,
  hideCursorInOverviewRuler: true,
  matchBrackets: 'always',
  minimap: {
    enabled: true,
  },
  selectOnLineNumbers: true,
  roundedSelection: false,
  readOnly: false,
  cursorStyle: 'line',
  automaticLayout: true,
}
</script>

<template>
  <div class="grid grid-cols-[320px_1fr] overflow-hidden h-screen">
    <div class="p-4 border-r">
      <NButton text size="large" class="justify-start" block>
        <template #icon>
          <IconChevronLeft />
        </template>
        <template #default>
          Назад
        </template>
      </NButton>
      <NHr />
      <NH6 class="mb-3 mt-0">Запись №{{ zap.n_zap }}</NH6>
      <NH6 class="mb-3 mt-0">Пациент</NH6>
      <NSpace vertical class="!gap-y-1">
        <NText>{{ zap.pacient.pers.fam }} {{ zap.pacient.pers.im }} {{ zap.pacient.pers.ot }}</NText>
        <NText>Дата рождения: {{ zap.pacient.pers.dr }}</NText>
        <NText>Полис: {{ zap.pacient.enp ?? zap.pacient.n_polis }}</NText>
      </NSpace>
    </div>
    <div>
      <MonacoEditor :options="editorOptions" v-model="editorValue" lang="xml" class="h-full" />
    </div>
  </div>
</template>

<style scoped>

</style>