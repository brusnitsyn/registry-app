<script setup lang="ts">
import {useZapRegistryStore} from "~/stores/zapRegistry"
import {
    IconCircleX,
    IconCircleCheck
} from '@tabler/icons-vue'
const zlListId = useRoute().query.zlListId
const zapStore = useZapRegistryStore()

const { zaps } = storeToRefs(zapStore)
const { getZapsForQuery } = zapStore

await useAsyncData('zaps', () => getZapsForQuery({zlListId}))

const getTitleCard = (zap) => {
  if (zap.pacient.pers === null) return `${zap.n_zap} — нет персональных данных`

  return `${zap.n_zap} — ${zap.pacient.pers.fam} ${zap.pacient.pers.im} ${zap.pacient.pers.ot}`
}

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
      { label: 'Номер записи', value: 'n_zap' },
      { label: 'Номер карты', value: 'nhistory' },
    ]
  },
]

const selectedSearchField = ref('fam')
const searchValue = ref('')

const submitSearch = async (e) => {
  const searchQuery = { search_field: selectedSearchField.value, search_value: searchValue.value, page: 1, zlListId }
  await zapStore.getZapsForQuery(searchQuery)
}

definePageMeta({
  layout: 'workspace'
})
</script>

<template>
  <div class="container max-w-5xl mx-auto py-4">
<!--    <NH1>-->
<!--      Записи реестра-->
<!--    </NH1>-->

    <div class=" py-4 bg-white sticky top-0 z-50">
      <NForm @submit.prevent="submitSearch">
        <NInputGroup>
          <NSelect class="w-1/4" :options="searchFields" placeholder="Поле поиска" v-model:value="selectedSearchField" size="large" />
          <NInput v-model:value="searchValue" placeholder="Значение поиска" size="large" />
          <NButton attr-type="submit" size="large">
            Найти
          </NButton>
        </NInputGroup>
      </NForm>
    </div>

    <div class="overflow-hidden">
      <NScrollbar v-if="zaps.data.length">
        <NSpace vertical>
          <NCard v-for="zap in zaps.data" :key="zap.id">
            <NFlex justify="space-between" align="center">
              <NText>{{ getTitleCard(zap) }}</NText>
              <NButton secondary @click="navigateTo({ name: 'ws-zap-id', params: { id: zap.id } })">
                <template #default>
                  Перейти к записи
                </template>
              </NButton>
            </NFlex>
<!--            <NCollapse>-->
<!--              <NCollapseItem :title="getTitleCard(zap)">-->
<!--                <template #header-extra>-->
<!--                  <NSpace>-->
<!--                    <NButton @click="navigateTo({ name: 'ws-zap-id', params: { id: zap.id } })">-->
<!--                      <template #default>-->
<!--                        Перейти к записи-->
<!--                      </template>-->
<!--                    </NButton>-->
                    <!--                    <NTag v-if="zap.count_errors" round :bordered="false" type="error">-->
                    <!--                      Есть ошибки-->
                    <!--                      <template #icon>-->
                    <!--                        <NIcon :component="IconCircleX" />-->
                    <!--                      </template>-->
                    <!--                    </NTag>-->
                    <!--                    <NTag v-else round :bordered="false" type="success">-->
                    <!--                      Ошибок нет-->
                    <!--                      <template #icon>-->
                    <!--                        <NIcon :component="IconCircleCheck" />-->
                    <!--                      </template>-->
                    <!--                    </NTag>-->
                    <!--                    <NTag round :bordered="false">-->
                    <!--                      {{ format(zap.updated_at, 'dd.MM.yyyy') }}-->
                    <!--                      <template #icon>-->
                    <!--                        <NaiveIcon name="tabler:calendar-check" />-->
                    <!--                      </template>-->
                    <!--                    </NTag>-->
<!--                  </NSpace>-->
<!--                </template>-->
<!--                <NSpace>-->
<!--                  <NButton :loading="fetchingPacient" tertiary @click="openPacientAndPersEditor(zap.id)">-->
<!--                    <template #icon>-->
<!--                      <NaiveIcon name="tabler:user-square-rounded" />-->
<!--                    </template>-->
<!--                    Персональные данные-->
<!--                  </NButton>-->
<!--                  <NButton tertiary @click="toZSlPage(zap.id)">-->
<!--                    <template #icon>-->
<!--                      <NaiveIcon name="tabler:user-square-rounded" />-->
<!--                    </template>-->
<!--                    Сведения о законченном случае-->
<!--                  </NButton>-->
<!--                </NSpace>-->
<!--              </NCollapseItem>-->
<!--            </NCollapse>-->
          </NCard>
        </NSpace>
      </NScrollbar>
      <div v-else class="">
        <NEmpty description="Нет данных">

        </NEmpty>
      </div>
    </div>

<!--    <div v-if="zaps.meta.last_page > 1" class="container max-w-5xl mx-auto py-4">-->
<!--      <NPagination v-model:page="currentPage" :page-count="zaps.meta.last_page" />-->
<!--    </div>-->

<!--    <DialogEditPaciendAndPers :has-open="hasShowEditPacientAndPersDialog" @update:open="value => hasShowEditPacientAndPersDialog = value" :zap_id="currentZapId" />-->
  </div>
</template>

<style scoped>

</style>