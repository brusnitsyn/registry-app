<script setup lang="ts">
import { useRouteQuery } from '@vueuse/router'
import {format} from "date-fns";
import {forEach} from "lodash-es";
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

const formatedArrayDate1 = computed({
  get() {
    const array = []
    for (let sl of currentZsl.value.sl) {
      array.push(new Date(sl.date_1))
    }
    return array
  }
})

const formatedArrayDate2 = computed({
  get() {
    const array = []
    for (let sl of currentZsl.value.sl) {
      array.push(new Date(sl.date_2))
    }
    return array
  }
})

const updateDate1 = (index,value) => {
  currentZsl.value.sl[index].date_1 = format(new Date(value), 'yyyy-MM-dd')
}

const updateDate2 = (index,value) => {
  currentZsl.value.sl[index].date_2 = format(new Date(value), 'yyyy-MM-dd')
}

const JsonDs2 = computed(() => {
  const array = []
  for (let sl of currentZsl.value.sl) {
    array.push(Object.values(JSON.parse(sl.ds2)))
  }
  return array
})

const createDs2 = (index, value) => {
  currentZsl.value.sl[index].ds2 = JSON.stringify(value)
}
</script>

<template>
  <PageBody>
    <NSpace vertical>
      <h1 class="font-semibold text-xl">
        {{ currentZsl.n_zap }} — {{ currentZsl.pacient_fio }}
      </h1>
      <NCollapse class="pt-4">
        <NCollapseItem title="Сведения о законченном случае">
          <NForm class="grid grid-cols-3 gap-x-4">
            <NFormItem path="idcase" label="Номер записи в реестре случаев">
              <NInput v-model:value="currentZsl.idcase" placeholder="">
                <template #prefix>
                  IDCASE:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="usl_ok" label="Условия оказания медицинской помощи">
              <NInput v-model:value="currentZsl.usl_ok" placeholder="">
                <template #prefix>
                  USL_OK:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="vidpom" label="Вид медицинской помощи">
              <NInput v-model:value="currentZsl.vidpom" placeholder="">
                <template #prefix>
                  VIDPOM:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="for_pom" label="Форма оказания медицинской помощи">
              <NInput v-model:value="currentZsl.for_pom" placeholder="">
                <template #prefix>
                  FOR_POM:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="npr_mo" label="Код МО (направившего на лечение)">
              <NInput v-model:value="currentZsl.npr_mo" placeholder="">
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
              <NInput v-model:value="currentZsl.lpu" placeholder="">
                <template #prefix>
                  LPU:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="vbr" label="Случай обслужен мобильной бригадой">
              <NInput v-model:value="currentZsl.vbr" placeholder="">
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
              <NInput v-model:value="currentZsl.p_otk" placeholder="">
                <template #prefix>
                  P_OTK:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="rslt_d" label="Результат диспансеризации">
              <NInput v-model:value="currentZsl.rslt_d" placeholder="">
                <template #prefix>
                  RSLT_D:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="kd_z" label="Продолжительность госпитализации">
              <NInput v-model:value="currentZsl.kd_z" placeholder="">
                <template #prefix>
                  KD_Z:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="vnov_m" label="Вес при рождении">
              <NInput v-model:value="currentZsl.vnov_m" placeholder="">
                <template #prefix>
                  VNOV_M:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="rslt" label="Результат обращения">
              <NInput v-model:value="currentZsl.rslt" placeholder="">
                <template #prefix>
                  RSLT:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="ishod" label="Исход заболевания">
              <NInput v-model:value="currentZsl.ishod" placeholder="">
                <template #prefix>
                  ISHOD:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="os_sluch" label="Особый случай">
              <NInput v-model:value="currentZsl.os_sluch" placeholder="">
                <template #prefix>
                  OS_SLUCH:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="vb_p" label="Внутрибольничный перевод">
              <NInput v-model:value="currentZsl.vb_p" placeholder="">
                <template #prefix>
                  VB_P:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="idsp" label="Способ оплаты мед. помощи">
              <NInput v-model:value="currentZsl.idsp" placeholder="">
                <template #prefix>
                  IDSP:
                </template>
              </NInput>
            </NFormItem>
            <NFormItem path="sumv" label="Сумма к оплате">
              <NInput v-model:value="currentZsl.sumv" placeholder="">
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
        <NCollapseItem v-for="(sl, index) in currentZsl.sl" :title="`Сведения о случае [${sl.sl_id}]`">
          <NSpace vertical>
            <NGrid :cols="6" class="pb-2">
              <NGi>
                <NButton class="w-full">
                  Услуги
                </NButton>
              </NGi>
            </NGrid>
            <NForm class="grid grid-cols-3 gap-x-4">
              <NFormItem path="lpu_1" label="Подразделение МО">
                <NInput v-model:value="sl.lpu_1" placeholder="">
                  <template #prefix>
                    LPU_1:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="podr" label="Код отделения">
                <NInput v-model:value="sl.podr" placeholder="">
                  <template #prefix>
                    PODR:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="profil" label="Профиль медицинской помощи">
                <NInput v-model:value="sl.profil" placeholder="">
                  <template #prefix>
                    PROFIL:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="profil_k" label="Профиль койки">
                <NInput v-model:value="sl.profil_k" placeholder="">
                  <template #prefix>
                    PROFIL_K:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="det" label="Признак детского профиля">
                <NInput v-model:value="sl.det" placeholder="">
                  <template #prefix>
                    DET:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="p_cel" label="Цель посещения">
                <NInput v-model:value="sl.p_cel" placeholder="">
                  <template #prefix>
                    P_CEL:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="nhistory" label="Номер карты">
                <NInput v-model:value="sl.nhistory" placeholder="">
                  <template #prefix>
                    NHISTORY:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="p_per" label="Признак поступления">
                <NInput v-model:value="sl.p_per" placeholder="">
                  <template #prefix>
                    P_PER:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="date_1" label="Дата начала лечения">
                <NDatePicker v-model:value="formatedArrayDate1[index]" @update:value="value => updateDate1(index, value)" format="dd.MM.yyyy" type="date" class="w-full">
                  <template #prefix>
                    DATE_1:
                  </template>
                </NDatePicker>
              </NFormItem>
              <NFormItem path="date_2" label="Дата окончания лечения">
                <NDatePicker v-model:value="formatedArrayDate2[index]" @update:value="value => updateDate2(index, value)" format="dd.MM.yyyy" type="date" class="w-full">
                  <template #prefix>
                    DATE_2:
                  </template>
                </NDatePicker>
              </NFormItem>
              <NFormItem path="kd" label="Кол-во посещений">
                <NInput v-model:value="sl.kd" placeholder="">
                  <template #prefix>
                    KD:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="ds1" label="Диагноз основной">
                <NInput v-model:value="sl.ds1" placeholder="">
                  <template #prefix>
                    DS1:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="ds2" label="Диагноз сопутствующего заболевания">
                <NDynamicTags v-model:value="JsonDs2[index]" @update:value="value => createDs2(index, value)" />
              </NFormItem>
              <NFormItem path="ds3" label="Диагноз осложнения заболевания">
                <NInput v-model:value="sl.ds3" placeholder="">
                  <template #prefix>
                    DS3:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="ds_onk" label="Подозрение на злокач. новообразование">
                <NInput v-model:value="sl.ds_onk" placeholder="">
                  <template #prefix>
                    DS_ONK:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="wei" label="Масса тела (кг)">
                <NInput v-model:value="sl.wei" placeholder="">
                  <template #prefix>
                    WEI:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="c_zab" label="Характер основного заболевания">
                <NInput v-model:value="sl.c_zab" placeholder="">
                  <template #prefix>
                    C_ZAB:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="dn" label="Диспансерное наблюдение">
                <NInput v-model:value="sl.dn" placeholder="">
                  <template #prefix>
                    DN:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="code_mes1" label="Код МЭС">
                <NInput v-model:value="sl.code_mes1" placeholder="">
                  <template #prefix>
                    CODE_MES1:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="code_mes2" label="Код МЭС сопутствующего заболевания">
                <NInput v-model:value="sl.code_mes2" placeholder="">
                  <template #prefix>
                    CODE_MES2:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="reab" label="Признак реабилитации">
                <NInput v-model:value="sl.reab" placeholder="">
                  <template #prefix>
                    REAB:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="prvs" label="Специальность лечащего врача">
                <NInput v-model:value="sl.prvs" placeholder="">
                  <template #prefix>
                    PRVS:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="iddokt" label="Код врача закрывшего талон">
                <NInput v-model:value="sl.iddokt" placeholder="">
                  <template #prefix>
                    IDDOKT:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="vers_spec" label="Код V021">
                <NInput v-model:value="sl.vers_spec" placeholder="" disabled>
                  <template #prefix>
                    VERS_SPEC:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="ed_col" label="Количество единиц оплаты">
                <NInput v-model:value="sl.ed_col" placeholder="">
                  <template #prefix>
                    ED_COL:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="tarif" label="Тариф">
                <NInput v-model:value="sl.tarif" placeholder="">
                  <template #prefix>
                    TARIF:
                  </template>
                </NInput>
              </NFormItem>
              <NFormItem path="sum_m" label="Стоимость случая">
                <NInput v-model:value="sl.sum_m" placeholder="">
                  <template #prefix>
                    SUM_M:
                  </template>
                </NInput>
              </NFormItem>

            </NForm>
          </NSpace>
        </NCollapseItem>
      </NCollapse>
      <pre>{{ currentZsl }}</pre>
    </NSpace>
  </PageBody>
</template>

<style scoped>

</style>