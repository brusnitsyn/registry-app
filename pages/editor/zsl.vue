<script setup lang="ts">
import { useRouteQuery } from '@vueuse/router'
import {format} from "date-fns";
const registryStore = useRegistryStore()
const zapId = useRouteQuery('zap_id')

const { currentZsl } = storeToRefs(registryStore)

await useAsyncData(`zsl-${zapId.value}`, () => registryStore.getZsl({ zap_id: zapId.value }), {
  watch: [zapId]
})

const columns = [
  {
    key: 'sl_id',
    title: 'Идентификатор случая',
    width: 280
  },
  {
    key: 'lpu_1',
    title: 'Подразделение',
    width: 200
  },
  {
    key: 'podr',
    title: 'Отделение',
    width: 180
  },
  {
    key: 'profil',
    title: 'Профиль мед. помощи',
    width: 180
  },
  {
    key: 'profil_k',
    title: 'Профиль койки',
    width: 180
  },
  {
    key: 'det',
    title: 'det',
    width: 50
  },
  {
    key: 'p_cel',
    title: 'Цель посещения',
    width: 100
  },
  {
    key: 'nhistory',
    title: 'Номер истории болезни',
    width: 200
  },
  {
    key: 'p_per',
    title: 'Признак поступления',
    width: 200
  },
  {
    key: 'date_1',
    title: 'Дата начала лечения',
    width: 200
  },
  {
    key: 'date_2',
    title: 'Дата окончания лечения',
    width: 200
  },
  {
    key: 'kd',
    title: 'Кол-во посещений',
    width: 200
  },
  {
    key: 'wei',
    title: 'Масса тела (кг)',
    width: 200
  },
  {
    key: 'ds0',
    title: 'Диагноз первичный',
    width: 200
  },
  {
    key: 'ds1',
    title: 'Диагноз основной',
    width: 200
  },
  {
    key: 'ds2',
    title: 'Диагноз сопутствующего заболевания',
    width: 200
  },
]

const nprDate = computed({
  get() {
    return new Date(currentZsl.value.npr_date)
  },
  set(value:number) {
    currentZsl.value.npr_date = format(new Date(value), 'yyyy-MM-dd')
  }
})

const dateZ1 = computed({
  get() {
    return new Date(currentZsl.value.date_z_1)
  },
  set(value:number) {
    currentZsl.value.date_z_1 = format(new Date(value), 'yyyy-MM-dd')
  }
})

const dateZ2 = computed({
  get() {
    return new Date(currentZsl.value.date_z_2)
  },
  set(value:number) {
    currentZsl.value.date_z_2 = format(new Date(value), 'yyyy-MM-dd')
  }
})
</script>

<template>
  <PageBody>
    <NSpace vertical>
      <h1 class="font-semibold text-xl">
        {{ currentZsl.n_zap }} — {{ currentZsl.pacient_fio }}
      </h1>
      <NCollapse>
        <NCollapseItem title="Сведения о законченном случае" class="py-4">
          <NForm class="grid grid-cols-3 gap-x-4">
            <NFormItem path="idcase" label="Номер записи в реестре случаев">
              <NInput v-model:value="currentZsl.idcase">
                <template #prefix>
                  IDCASE:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="usl_ok" label="Условия оказания медицинской помощи">
              <NInput v-model:value="currentZsl.usl_ok">
                <template #prefix>
                  USL_OK:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="vidpom" label="Вид медицинской помощи">
              <NInput v-model:value="currentZsl.vidpom">
                <template #prefix>
                  VIDPOM:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="for_pom" label="Форма оказания медицинской помощи">
              <NInput v-model:value="currentZsl.for_pom">
                <template #prefix>
                  FOR_POM:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="npr_mo" label="Код МО (направившего на лечение)">
              <NInput v-model:value="currentZsl.npr_mo">
                <template #prefix>
                  NPR_MO:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="npr_date" label="Дата направления на лечение">
              <NDatePicker v-model:value="nprDate" format="dd.MM.yyyy" type="date" class="w-full">
                <template #prefix>
                  NPR_DATE:
                </template>
              </NDatePicker>
            </NFormItem>
            <NFormItem path="lpu" label="Код МО">
              <NInput v-model:value="currentZsl.lpu">
                <template #prefix>
                  LPU:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="vbr" label="Случай обслужен мобильной бригадой">
              <NInput v-model:value="currentZsl.vbr">
                <template #prefix>
                  VBR:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="date_z_1" label="Дата начала лечения">
              <NDatePicker v-model:value="dateZ1" format="dd.MM.yyyy" type="date" class="w-full">
                <template #prefix>
                  DATE_Z_1:
                </template>
              </NDatePicker>
            </NFormItem>
            <NFormItem path="date_z_2" label="Дата окончания лечения">
              <NDatePicker v-model:value="dateZ2" format="dd.MM.yyyy" type="date" class="w-full">
                <template #prefix>
                  DATE_Z_2:
                </template>
              </NDatePicker>
            </NFormItem>
            <NFormItem path="p_otk" label="Признак отказа">
              <NInput v-model:value="currentZsl.p_otk">
                <template #prefix>
                  P_OTK:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="rslt_d" label="Результат диспансеризации">
              <NInput v-model:value="currentZsl.rslt_d">
                <template #prefix>
                  RSLT_D:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="kd_z" label="Продолжительность госпитализации">
              <NInput v-model:value="currentZsl.kd_z">
                <template #prefix>
                  KD_Z:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="vnov_m" label="Вес при рождении">
              <NInput v-model:value="currentZsl.vnov_m">
                <template #prefix>
                  VNOV_M:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="rslt" label="Результат обращения">
              <NInput v-model:value="currentZsl.rslt">
                <template #prefix>
                  RSLT:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="ishod" label="Исход заболевания">
              <NInput v-model:value="currentZsl.ishod">
                <template #prefix>
                  ISHOD:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="os_sluch" label="Особый случай">
              <NInput v-model:value="currentZsl.os_sluch">
                <template #prefix>
                  OS_SLUCH:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="vb_p" label="Внутрибольничный перевод">
              <NInput v-model:value="currentZsl.vb_p">
                <template #prefix>
                  VB_P:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="idsp" label="Способ оплаты мед. помощи">
              <NInput v-model:value="currentZsl.idsp">
                <template #prefix>
                  IDSP:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="sumv" label="Сумма к оплате">
              <NInput v-model:value="currentZsl.sumv">
                <template #prefix>
                  SUMV:
                </template>
              </NInput>
            </NFormItem>
          </NForm>
          <NFlex justify="end">
            <NButton type="primary">
              Сохранить
            </NButton>
          </NFlex>
        </NCollapseItem>
      </NCollapse>
      <pre>{{ currentZsl }}</pre>
    </NSpace>
  </PageBody>
</template>

<style scoped>

</style>