<script setup lang="ts">
import { useRouteQuery } from '@vueuse/router'
const router = useRouter()
const registryStore = useRegistryStore()
const zlListId = useRouteQuery('zl_list_id')

await useAsyncData('zaps', () => registryStore.fetchZaps(zlListId.value))

const getTitleCard = (zap) => {
  return `${zap.n_zap} — ${zap.pacient.pers.fam} ${zap.pacient.pers.im} ${zap.pacient.pers.ot}`
}

const currentPage = computed({
  get() {
    registryStore.currentZaps.meta.current_page
  },
  async set(value) {
    await registryStore.fetchZaps(zlListId.value, value)
  }
})

const searchFields = [
  {
    type: 'group',
    label: 'Пациент',
    children: [
      { label: 'Фамилия', value: 'fam' },
      { label: 'СНИЛС', value: 'snils' },
    ]
  },
  {
    type: 'group',
    label: 'Запись',
    children: [
      { label: 'Номер', value: 'n_zap' },
    ]
  },
]

const selectedSearchField = ref('fam')
const searchValue = ref('')

const submitSearch = async (e) => {
  const searchQuery = { search_field: selectedSearchField.value, search_value: searchValue.value }
  await registryStore.fetchZaps(zlListId.value, 1, searchQuery)
}

const hasShowEditPacientAndPersDialog = ref(false)
const currentZapId = ref(null)
const fetchingPacient = ref(false)

const openPacientAndPersEditor = async (id:number) => {
  if (id === null) return

  fetchingPacient.value = true

  console.log('fetch pacient')

  await registryStore.fetchPacient(id)

  hasShowEditPacientAndPersDialog.value = true

  fetchingPacient.value = false
}

const toZSlPage = (id:number) => {
  router.push({ name: 'editor-zsl', query: { 'zap_id': id } })
}
</script>

<template>
  <div class="grid grid-rows-[auto_1fr_auto] h-full">

    <div class="container max-w-5xl mx-auto py-4 bg-white sticky top-[0px] z-50">
      <NForm @submit.prevent="submitSearch">
        <NInputGroup>
          <NSelect class="w-1/4" :options="searchFields" placeholder="Поле поиска" v-model:value="selectedSearchField" />
          <NInput v-model:value="searchValue" placeholder="Значение поиска" />
          <NButton attr-type="submit">
            Найти
          </NButton>
        </NInputGroup>
      </NForm>
    </div>

    <div class="overflow-hidden">
      <NScrollbar v-if="registryStore.currentZaps.data.length">
        <NSpace class="container max-w-5xl mx-auto" vertical>
          <NCard v-for="zap in registryStore.currentZaps.data" :key="zap.id">
            <NCollapse>
              <NCollapseItem :title="getTitleCard(zap)">
                <template #header-extra>
                  <NSpace>
                    <NTag v-if="zap.count_errors" round :bordered="false" type="error">
                      Есть ошибки
                      <template #icon>
                        <NaiveIcon name="tabler:circle-x" />
                      </template>
                    </NTag>
                    <NTag v-else round :bordered="false" type="success">
                      Ошибок нет
                      <template #icon>
                        <NaiveIcon name="tabler:circle-check" />
                      </template>
                    </NTag>
<!--                    <NTag round :bordered="false">-->
<!--                      {{ format(zap.updated_at, 'dd.MM.yyyy') }}-->
<!--                      <template #icon>-->
<!--                        <NaiveIcon name="tabler:calendar-check" />-->
<!--                      </template>-->
<!--                    </NTag>-->
                  </NSpace>
                </template>
                <NSpace>
                    <NButton :loading="fetchingPacient" tertiary @click="openPacientAndPersEditor(zap.id)">
                      <template #icon>
                        <NaiveIcon name="tabler:user-square-rounded" />
                      </template>
                      Персональные данные
                    </NButton>
                    <NButton tertiary @click="toZSlPage(zap.id)">
                      <template #icon>
                        <NaiveIcon name="tabler:user-square-rounded" />
                      </template>
                      Сведения о законченном случае
                    </NButton>
                </NSpace>
              </NCollapseItem>
            </NCollapse>
          </NCard>
        </NSpace>
      </NScrollbar>
      <div v-else class="">
        <NEmpty description="Нет данных">

        </NEmpty>
      </div>
    </div>

    <div v-if="registryStore.currentZaps.meta.last_page > 1" class="container max-w-5xl mx-auto py-4">
      <NPagination v-model:page="currentPage" :page-count="registryStore.currentZaps.meta.last_page" />
    </div>

    <DialogEditPaciendAndPers :has-open="hasShowEditPacientAndPersDialog" @update:open="value => hasShowEditPacientAndPersDialog = value" :zap_id="currentZapId" />
  </div>
</template>

<style scoped>

</style>