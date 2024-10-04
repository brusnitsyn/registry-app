<script setup lang="ts">
const zapId = useRoute().params.id
const tab = computed({
  get() {
    return useRoute().query.tab ?? 'main'
  },
  set(tab: string) {
    const query = {
      ...useRoute().query,
      tab
    }
    useRouter().push({ name: useRoute().name, query })
  }
})

const zapStore = useZapRegistryStore()
const pacientStore = usePacientRegistryStore()
const { getZap, updateZap, updatePacient, updateZSl } = zapStore
const { zap } = storeToRefs(zapStore)
const { vpolisOptions, invOptions } = storeToRefs(pacientStore)
await getZap(zapId)

const elementRef = ref({ zap: zap.value })

const getElement = computed({
  get() {
    return elementRef.value ?? { zap: zap.value }
  },
  set(value) {
    elementRef.value = value
  }
})

const naprRef = ref([])
const onkSlRef = ref({})
const lekPrRef = ref({})

function changeTabToMain() {
  getElement.value = { zap: zap.value }
  tab.value = 'main'
}

function changeTabToNapr(napr:[]) {
  naprRef.value = napr
  getElement.value = { sl: { napr } }
  tab.value = 'napr'
}

function changeTabToCons(cons:[]) {
  naprRef.value = napr
  tab.value = 'napr'
}

function changeTabToOnkSl(onk_sl:object) {
  onkSlRef.value = onk_sl
  getElement.value = { onk_sl }
  tab.value = 'onksl'
}

function changeTabToLekPr(lek_pr:[]) {
  lekPrRef.value = lek_pr
  getElement.value = { onk_usl: { lek_pr } }
  tab.value = 'lekpr'
}

function onlyAllowNumber(value: string) {
  return !value || /^\d+$/.test(value)
}



</script>

<template>
  <NGrid cols="5" item-responsive responsive="screen" class="py-8 px-10 max-h-screen overflow-hidden">
    <NGridItem span="m:2">
      <ClientOnly>
        <CoreEditorCode v-model:code="getElement" />
        <template #fallback>
          <NSkeleton :width="648" height="100%" />
        </template>
      </ClientOnly>
    </NGridItem>
    <NGridItem span="m:3" class="h-[94vh] overflow-hidden max-w-2xl">
      <NScrollbar class="pr-4">
        <NSpace vertical>
          <NFlex justify="end" class="px-5">
            <NButton secondary>
              Сохранить запись полностью
            </NButton>
          </NFlex>
          <NTabs :value="tab" tab-class="!hidden">
            <NTabPane display-directive="show" name="main">
              <NCollapse>

                <NCollapseItem title="Запись">
                  <NForm ref="zapFormRef" :model="zap">
                    <NGrid cols="1" x-gap="12" class="px-5">
                      <NGi>
                        <NFormItem label="Номер позиции записи" path="n_zap" :show-feedback="false">
                          <NInput v-model:value="zap.n_zap" :allow-input="onlyAllowNumber" />
                        </NFormItem>
                      </NGi>
                      <NGi>
                        <NFormItem path="pr_nov" :show-label="false" :show-feedback="false">
                          <NCheckbox v-model:checked="zap.pr_nov" label="Признак исправленной записи" checked-value="1" unchecked-value="0" />
                        </NFormItem>
                      </NGi>
                      <NGi span="2">
                        <NFlex justify="end">
                          <NButton secondary @click="updateZap(zap)">
                            Сохранить только этот блок
                          </NButton>
                        </NFlex>
                      </NGi>
                    </NGrid>
                  </NForm>
                </NCollapseItem>

                <NCollapseItem title="Сведения о пациенте">
                  <NGrid cols="2" x-gap="12" class="px-5">
                    <NGi>
                      <NFormItem label="Тип документа ОМС" path="pacient.vpolis" >
                        <NSelect v-model:value="zap.pacient.vpolis" :options="vpolisOptions" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Серия документа ОМС" path="pacient.spolis" >
                        <NInput v-model:value="zap.pacient.spolis" :allow-input="onlyAllowNumber" :disabled="zap.pacient.vpolis != 1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Номер документа, подтверждающего факт страхования по ОМС" path="pacient.npolis">
                        <NInput v-model:value="zap.pacient.npolis" :allow-input="onlyAllowNumber" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Единый номер полиса обязательного медицинского страхования" path="pacient.enp">
                        <NInput v-model:value="zap.pacient.enp" :allow-input="onlyAllowNumber" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Регион страхования" path="pacient.st_okato">
                        <NInput v-model:value="zap.pacient.st_okato" :allow-input="onlyAllowNumber" :disabled="zap.pacient.vpolis != 1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Реестровый номер СМО" path="pacient.smo">
                        <NInput v-model:value="zap.pacient.smo" :allow-input="onlyAllowNumber" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Группа инвалидности" path="pacient.inv">
                        <NSelect v-model:value="zap.pacient.inv" :options="invOptions" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Признак новорожденного" path="pacient.novor">
                        <NInput v-model:value="zap.pacient.novor" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem path="pacient.mse" :show-label="false" :show-feedback="false">
                        <NCheckbox v-model:checked="zap.pacient.mse" label="Направление на МСЭ" />
                      </NFormItem>
                    </NGi>
                    <NGi span="2">
                      <NFlex justify="end">
                        <NButton secondary @click="updatePacient(zap.pacient)">
                          Сохранить только этот блок
                        </NButton>
                      </NFlex>
                    </NGi>
                  </NGrid>
                </NCollapseItem>

                <NCollapseItem title="Сведения о законченном случае">
                  <NGrid cols="2" x-gap="12" class="px-5">
                    <NGi>
                      <NFormItem label="Номер записи в реестре случаев" path="z_sl.idcase" >
                        <NInput v-model:value="zap.z_sl.idcase" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Условия оказания медицинской помощи" path="z_sl.usl_ok" >
                        <NInput v-model:value="zap.z_sl.usl_ok" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Вид медицинской помощи" path="z_sl.vidpom">
                        <NInput v-model:value="zap.z_sl.vidpom" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Форма оказания медицинской помощи" path="z_sl.for_pom">
                        <NInput v-model:value="zap.z_sl.for_pom" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Код МО, направившей на лечение" path="z_sl.npr_mo">
                        <NInput v-model:value="zap.z_sl.npr_mo" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Дата направления на лечение" path="z_sl.npr_date">
                        <NDatePicker v-model:formatted-value="zap.z_sl.npr_date" value-format="yyyy-MM-dd" class="w-full" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Код МО" path="z_sl.lpu">
                        <NInput v-model:value="zap.z_sl.lpu" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Дата начала лечения" path="z_sl.date_z_1">
                        <NDatePicker v-model:formatted-value="zap.z_sl.date_z_1" value-format="yyyy-MM-dd" class="w-full" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Дата окончания лечения" path="z_sl.date_z_2">
                        <NDatePicker v-model:formatted-value="zap.z_sl.date_z_2" value-format="yyyy-MM-dd" class="w-full" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Результат диспансеризации" path="z_sl.rslt_d">
                        <NInput v-model:value="zap.z_sl.rslt_d" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Продолжительность госпитализации" path="z_sl.kd_z">
                        <NInput v-model:value="zap.z_sl.kd_z" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Вес при рождении" path="z_sl.vnov_m">
                        <NInput v-model:value="zap.z_sl.vnov_m" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Результат обращения" path="z_sl.rslt">
                        <NInput v-model:value="zap.z_sl.rslt" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Исход заболевания" path="z_sl.ishod">
                        <NInput v-model:value="zap.z_sl.ishod" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Особый случай" path="z_sl.os_sluch">
                        <NInput v-model:value="zap.z_sl.os_sluch" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Код способа оплаты медицинской помощи" path="z_sl.idsp">
                        <NInput v-model:value="zap.z_sl.idsp" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi>
                      <NFormItem label="Сумма, выставленная к оплате" path="z_sl.sumv">
                        <NInput v-model:value="zap.z_sl.sumv" placeholder="1" />
                      </NFormItem>
                    </NGi>
                    <NGi span="2">
                      <NFormItem path="z_sl.vbr" :show-label="false" :show-feedback="false">
                        <NCheckbox v-model:checked="zap.z_sl.vbr" checked-value="1" unchecked-value="0" label="Признак мобильной медицинской бригады" />
                      </NFormItem>
                    </NGi>
                    <NGi span="2">
                      <NFormItem path="z_sl.p_otk" :show-label="false" :show-feedback="false">
                        <NCheckbox v-model:checked="zap.z_sl.p_otk" checked-value="1" unchecked-value="0" label="Признак отказа" />
                      </NFormItem>
                    </NGi>
                    <NGi span="2">
                      <NFormItem path="z_sl.vb_p" :show-label="false" :show-feedback="false">
                        <NCheckbox v-model:checked="zap.z_sl.vb_p" checked-value="1" unchecked-value="0" label="Признак внутрибольничного перевода" />
                      </NFormItem>
                    </NGi>

                    <NGi span="2">
                      <NFlex justify="end">
                        <NButton secondary @click="updateZSl(zap.z_sl)">
                          Сохранить только этот блок
                        </NButton>
                      </NFlex>
                    </NGi>
                  </NGrid>
                </NCollapseItem>
                <template v-for="(sl, index) in zap.z_sl.sl">
                  <NCollapseItem :title="`Сведения о случае ${sl.sl_id}`">
                    <NSpace vertical class="px-5">
                      <NFlex>
                        <NButton secondary @click="changeTabToNapr(sl.napr)">Сведения об оформлении направления</NButton>
                        <NButton secondary>Сведения о проведении консилиума</NButton>
                        <NButton secondary>Сведения о КСГ/КПГ</NButton>
                        <NButton secondary @click="changeTabToOnkSl(sl.onk_sl)">Сведения о случае лечения онкологического заболевания</NButton>
                      </NFlex>
                      <NGrid cols="2" x-gap="12">
                        <NGi>
                          <NFormItem label="Подразделение МО" :path="`z_sl.sl[${index}].lpu_1`" >
                            <NInput v-model:value="sl.lpu_1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Код отделения" :path="`z_sl.sl[${index}].podr`" >
                            <NInput v-model:value="sl.podr" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Профиль медицинской помощи" :path="`z_sl.sl[${index}].profil`" >
                            <NInput v-model:value="sl.profil" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Профиль койки" :path="`z_sl.sl[${index}].profil_k`" >
                            <NInput v-model:value="sl.profil_k" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Цель посещения" :path="`z_sl.sl[${index}].p_cel`" >
                            <NInput v-model:value="sl.p_cel" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Номер истории болезни" :path="`z_sl.sl[${index}].nhistory`" >
                            <NInput v-model:value="sl.nhistory" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Признак поступления/перевода" :path="`z_sl.sl[${index}].p_per`" >
                            <NInput v-model:value="sl.p_per" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Дата начала лечения" :path="`z_sl.sl[${index}].date_1`" >
                            <NDatePicker v-model:formatted-value="sl.date_1" value-format="yyyy-MM-dd" class="w-full" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Дата окончания лечения" :path="`z_sl.sl[${index}].date_2`" >
                            <NDatePicker v-model:formatted-value="sl.date_2" value-format="yyyy-MM-dd" class="w-full" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Продолжительность госпитализации" :path="`z_sl.sl[${index}].kd`" >
                            <NInput v-model:value="sl.kd" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Масса тела (кг)" :path="`z_sl.sl[${index}].wei`" >
                            <NInput v-model:value="sl.wei" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Диагноз первичный" :path="`z_sl.sl[${index}].ds0`" >
                            <NInput v-model:value="sl.ds0" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Диагноз основной" :path="`z_sl.sl[${index}].ds1`" >
                            <NInput v-model:value="sl.ds1" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Диагноз сопутствующего заболевания" :path="`z_sl.sl[${index}].ds2`" >
                            <NInput v-model:value="sl.ds2" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Диагноз осложнения заболевания" :path="`z_sl.sl[${index}].ds3`" >
                            <NInput v-model:value="sl.ds3" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Характер основного заболевания" :path="`z_sl.sl[${index}].c_zab`" >
                            <NInput v-model:value="sl.c_zab" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Диспансерное наблюдение" :path="`z_sl.sl[${index}].dn`" >
                            <NInput v-model:value="sl.dn" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Код стандарта медицинской помощи" :path="`z_sl.sl[${index}].code_mes1`" >
                            <NInput v-model:value="sl.code_mes1" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Код стандарта медицинской помощи сопутствующего заболевания" :path="`z_sl.sl[${index}].code_mes2`" >
                            <NInput v-model:value="sl.code_mes2" placeholder="1" />
                          </NFormItem>
                        </NGi>

                        <NGi span="2">
                          <NFormItem path="sl.det" :show-label="false" :show-feedback="false">
                            <NCheckbox v-model:checked="sl.det" checked-value="1" unchecked-value="0" label="Признак детского профиля" />
                          </NFormItem>
                        </NGi>
                        <NGi span="2">
                          <NFormItem path="sl.ds_onk" :show-label="false" :show-feedback="false">
                            <NCheckbox v-model:checked="sl.ds_onk" checked-value="1" unchecked-value="0" label="Признак подозрения на ЗНО" />
                          </NFormItem>
                        </NGi>
                        <NGi span="2">
                          <NFormItem path="sl.reab" :show-label="false" :show-feedback="false">
                            <NCheckbox v-model:checked="sl.reab" checked-value="1" unchecked-value="0" label="Признак реабилитации" />
                          </NFormItem>
                        </NGi>
                      </NGrid>
                    </NSpace>
                  </NCollapseItem>
                </template>
              </NCollapse>
            </NTabPane>

            <NTabPane display-directive="if" name="napr">
              <NSpace :size="24" vertical>
                <NFlex>
                  <NButton secondary @click="changeTabToMain">
                    Вернуться к записи
                  </NButton>
                </NFlex>
                <NCollapse>
                  <NCollapseItem v-for="(napr, index) in naprRef" :title="`${napr.napr_date}: Сведения об оформлении направления (${napr.napr_usl})`">
                    <NForm ref="zapFormRef" :model="napr">
                      <NGrid cols="2" x-gap="12">
                        <NGi>
                          <NFormItem label="Дата направления" :path="`${index}`">
                            <NDatePicker v-model:formatted-value="napr.napr_date" value-format="yyyy-MM-dd" class="w-full" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Код МО, куда оформлено направление" path="napr_mo">
                            <NInput v-model:value="napr.napr_mo" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Вид направления" path="napr_v">
                            <NInput v-model:value="napr.napr_v" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Метод диагностического исследования" path="met_issl">
                            <NInput v-model:value="napr.met_issl" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Медицинская услуга (код)" path="napr_usl">
                            <NInput v-model:value="napr.napr_usl" placeholder="1" />
                          </NFormItem>
                        </NGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                </NCollapse>
              </NSpace>
            </NTabPane>

            <NTabPane display-directive="if" name="cons">
              <NSpace :size="24" vertical>
                <NFlex>
                  <NButton secondary @click="changeTabToMain">
                    Вернуться к записи
                  </NButton>
                </NFlex>
                <NCollapse>
                  <NCollapseItem v-for="(napr, index) in naprRef" :title="`Сведения об оформлении направления ${index + 1}`">
                    <NForm ref="zapFormRef" :model="napr">
                      <NGrid cols="2" x-gap="12">
                        <NGi>
                          <NFormItem label="Дата направления" :path="`${index}`">
                            <NInput v-model:value="napr.napr_date" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Код МО, куда оформлено направление" path="napr_mo">
                            <NInput v-model:value="napr.napr_mo" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Вид направления" path="napr_v">
                            <NInput v-model:value="napr.napr_v" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Метод диагностического исследования" path="met_issl">
                            <NInput v-model:value="napr.met_issl" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Медицинская услуга (код)" path="napr_usl">
                            <NInput v-model:value="napr.napr_usl" placeholder="1" />
                          </NFormItem>
                        </NGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                </NCollapse>
              </NSpace>
            </NTabPane>

            <NTabPane display-directive="if" name="onksl">
              <NSpace :size="24" vertical>
                <NFlex>
                  <NButton secondary @click="changeTabToMain">
                    Вернуться к записи
                  </NButton>
                </NFlex>
                <NCollapse>
                  <NCollapseItem title="Сведения о случае лечения онкологического заболевания">
                    <NForm ref="onkSlFormRef" :model="onkSlRef">
                      <NGrid cols="2" x-gap="12">
                        <NGi>
                          <NFormItem label="Повод обращения" path="ds1_t">
                            <NInput v-model:value="onkSlRef.ds1_t" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Стадия заболевания" path="stad">
                            <NInput v-model:value="onkSlRef.stad" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Значение Tumor" path="onk_t">
                            <NInput v-model:value="onkSlRef.onk_t" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Значение Nodus" path="onk_n">
                            <NInput v-model:value="onkSlRef.onk_n" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Значение Metastasis" path="onk_m">
                            <NInput v-model:value="onkSlRef.onk_m" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Признак выявления отдаленных метастазов" path="mtstz">
                            <NInput v-model:value="onkSlRef.mtstz" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Суммарная очаговая доза" path="sod">
                            <NInput v-model:value="onkSlRef.sod" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Кол-во фракций проведения лучевой терапии" path="k_fr">
                            <NInput v-model:value="onkSlRef.k_fr" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Масса тела (кг)" path="wei">
                            <NInput v-model:value="onkSlRef.wei" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Рост (см)" path="hei">
                            <NInput v-model:value="onkSlRef.hei" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Площадь поверхности тела (м2)" path="bsa">
                            <NInput v-model:value="onkSlRef.bsa" placeholder="1" />
                          </NFormItem>
                        </NGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                  <NCollapseItem v-if="onkSlRef.b_diag?.length" title="Диагностический блок">
                    <NForm ref="onkSlFormRef" :model="onkSlRef.b_diag">
                      <NGrid cols="2" x-gap="12">
                        <NGi>
                          <NFormItem label="Дата взятия материала" path="diag_date">
                            <NInput v-model:value="onkSlRef.b_diag.diag_date" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Тип диагностического показателя" path="diag_tip">
                            <NInput v-model:value="onkSlRef.b_diag.diag_tip" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Код диагностического показателя" path="diag_code">
                            <NInput v-model:value="onkSlRef.b_diag.diag_code" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Код результата диагностики" path="diag_rslt">
                            <NInput v-model:value="onkSlRef.b_diag.diag_rslt" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Признак получения результата диагностики" path="rec_rslt">
                            <NInput v-model:value="onkSlRef.b_diag.rec_rslt" placeholder="1" />
                          </NFormItem>
                        </NGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                  <NCollapseItem title="Сведения об услуге при лечении онкологического заболевания">
                    <NSpace vertical>
                      <NFlex>
                        <NButton secondary @click="changeTabToLekPr(onkSlRef.onk_usl.lek_pr)">Сведения о введенном лекарственном препарате</NButton>
                      </NFlex>
                      <NForm ref="onkSlFormRef" :model="onkSlRef.onk_usl">
                        <NGrid cols="2" x-gap="12">
                          <NGi>
                            <NFormItem label="Тип услуги" path="usl_tip">
                              <NInput v-model:value="onkSlRef.onk_usl.usl_tip" placeholder="1" />
                            </NFormItem>
                          </NGi>
                          <NGi>
                            <NFormItem label="Тип хирургического лечения" path="hir_tip">
                              <NInput v-model:value="onkSlRef.onk_usl.hir_tip" placeholder="1" />
                            </NFormItem>
                          </NGi>
                          <NGi>
                            <NFormItem label="Линия лекарственной терапии" path="lek_tip_l">
                              <NInput v-model:value="onkSlRef.onk_usl.lek_tip_l" placeholder="1" />
                            </NFormItem>
                          </NGi>
                          <NGi>
                            <NFormItem label="Цикл лекарственной терапии" path="lek_tip_v">
                              <NInput v-model:value="onkSlRef.onk_usl.lek_tip_v" placeholder="1" />
                            </NFormItem>
                          </NGi>
                          <NGi>
                            <NFormItem label="Признак проведения профилактики тошноты" path="pptr">
                              <NInput v-model:value="onkSlRef.onk_usl.pptr" placeholder="1" />
                            </NFormItem>
                          </NGi>
                          <NGi>
                            <NFormItem label="Тип лучевой терапии" path="luch_tip">
                              <NInput v-model:value="onkSlRef.onk_usl.luch_tip" placeholder="1" />
                            </NFormItem>
                          </NGi>
                        </NGrid>
                      </NForm>
                    </NSpace>
                  </NCollapseItem>
                </NCollapse>
              </NSpace>
            </NTabPane>

            <NTabPane display-directive="if" name="lekpr">
              <NSpace :size="24" vertical>
                <NFlex>
                  <NButton secondary @click="changeTabToMain">
                    Вернуться к записи
                  </NButton>
                </NFlex>
                <NCollapse>
                  <NCollapseItem v-for="(lekPr, index) in lekPrRef" :title="`${lekPr.date_inj}: Сведения о введенном лекарственном препарате (${lekPr.regnum})`">
                    <NForm ref="zapFormRef" :model="lekPr">
                      <NGrid cols="2" x-gap="12">
                        <NGi>
                          <NFormItem label="Дата введения" path="date_inj">
                            <NInput v-model:value="lekPr.date_inj" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Код схемы лекарственной терапии" path="code_sh">
                            <NInput v-model:value="lekPr.code_sh" placeholder="1" />
                          </NFormItem>
                        </NGi>
                        <NGi>
                          <NFormItem label="Идентификатор лекарственного препарата" path="regnum">
                            <NInput v-model:value="lekPr.regnum" placeholder="1" />
                          </NFormItem>
                        </NGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                </NCollapse>
              </NSpace>
            </NTabPane>
          </NTabs>
        </NSpace>
      </NScrollbar>
    </NGridItem>
  </NGrid>
</template>

<style scoped>
:deep(.cdx-block .ce-code__textarea) {
  @apply !h-[92vh];
}

:deep(.n-collapse-item__header-main) {
  @apply !font-semibold;
}
</style>