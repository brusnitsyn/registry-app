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
const { getZap, updateZap, updatePacient, updateZSl, updateSl } = zapStore
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
const persRef = ref({})
const consRef = ref({})
const ksgKpgRef = ref({})
const ds2NRef = ref([])
const nazRef = ref([])

function changeTabToMain() {
  getElement.value = { zap: zap.value }
  tab.value = 'main'
}

function changeTabToPers(pers: object) {
  persRef.value = pers
  getElement.value = { pers }
  tab.value = 'pers'
}

function changeTabToNapr(napr:[]) {
  naprRef.value = napr
  getElement.value = { sl: { napr } }
  tab.value = 'napr'
}

function changeTabToCons(cons:{}) {
  consRef.value = cons
  getElement.value = { sl: { cons } }
  tab.value = 'cons'
}

function changeTabToKsgKpg(ksg_kpg:{}) {
  ksgKpgRef.value = ksg_kpg
  getElement.value = { sl: { ksg_kpg } }
  tab.value = 'ksgkpg'
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

function changeTabToDs2N(ds2_n:[]) {
  ds2NRef.value = ds2_n
  getElement.value = {sl: {ds2_n}}
  tab.value = 'ds2n'
}

function changeTabToNaz(naz:[]) {
  nazRef.value = naz
  getElement.value = { sl: { naz } }
  tab.value = 'naz'
}


function onlyAllowNumber(value: string) {
  return !value || /^\d+$/.test(value)
}


definePageMeta({
  layout: 'workspace'
})

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
                      <NFormItemGi label="Номер позиции записи" path="n_zap" :show-feedback="false">
                        <NInput v-model:value="zap.n_zap" :allow-input="onlyAllowNumber" />
                      </NFormItemGi>
                      <NFormItemGi path="pr_nov" :show-label="false" :show-feedback="false">
                        <NCheckbox v-model:checked="zap.pr_nov" label="Признак исправленной записи" checked-value="1" unchecked-value="0" />
                      </NFormItemGi>
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
                  <NSpace vertical>
                    <NFlex class="px-5">
                      <NButton secondary @click="changeTabToPers(zap.pacient.pers)">Персональные данные</NButton>
                    </NFlex>
                    <NGrid cols="2" x-gap="12" class="px-5">
                      <NFormItemGi label="Тип документа ОМС" path="pacient.vpolis" >
                        <NSelect v-model:value="zap.pacient.vpolis" :options="vpolisOptions" />
                      </NFormItemGi>
                      <NFormItemGi label="Серия документа ОМС" path="pacient.spolis" >
                        <NInput v-model:value="zap.pacient.spolis" :allow-input="onlyAllowNumber" :disabled="zap.pacient.vpolis != 1" />
                      </NFormItemGi>
                      <NFormItemGi label="Номер документа, подтверждающего факт страхования по ОМС" path="pacient.npolis">
                        <NInput v-model:value="zap.pacient.npolis" :allow-input="onlyAllowNumber" />
                      </NFormItemGi>
                      <NFormItemGi label="Единый номер полиса обязательного медицинского страхования" path="pacient.enp">
                        <NInput v-model:value="zap.pacient.enp" :allow-input="onlyAllowNumber" />
                      </NFormItemGi>
                      <NFormItemGi label="Регион страхования" path="pacient.st_okato">
                        <NInput v-model:value="zap.pacient.st_okato" :allow-input="onlyAllowNumber" :disabled="zap.pacient.vpolis != 1" />
                      </NFormItemGi>
                      <NFormItemGi label="Реестровый номер СМО" path="pacient.smo">
                        <NInput v-model:value="zap.pacient.smo" :allow-input="onlyAllowNumber" />
                      </NFormItemGi>
                      <NFormItemGi label="ОГРН СМО" path="pacient.smo_ogrn">
                        <NInput v-model:value="zap.pacient.smo_ogrn" :allow-input="onlyAllowNumber" />
                      </NFormItemGi>
                      <NFormItemGi label="ОКАТО территории страхования" path="pacient.smo_ok">
                        <NInput v-model:value="zap.pacient.smo_ok" :allow-input="onlyAllowNumber" />
                      </NFormItemGi>
                      <NFormItemGi label="Наименование СМО" path="pacient.smo_nam">
                        <NInput v-model:value="zap.pacient.smo_nam" :allow-input="onlyAllowNumber" />
                      </NFormItemGi>
                      <NFormItemGi label="Группа инвалидности" path="pacient.inv">
                        <NSelect v-model:value="zap.pacient.inv" :options="invOptions" />
                      </NFormItemGi>
                      <NFormItemGi label="Признак новорожденного" path="pacient.novor">
                        <NInput v-model:value="zap.pacient.novor" placeholder="ПДДММГГНН" />
                      </NFormItemGi>
                      <NFormItemGi label="Вес при рождении" path="pacient.vnov_d">
                        <NInput v-model:value="zap.pacient.vnov_d" placeholder="0000" />
                      </NFormItemGi>
                      <NFormItemGi path="pacient.mse" :show-label="false" :show-feedback="false">
                        <NCheckbox v-model:checked="zap.pacient.mse" label="Направление на МСЭ" />
                      </NFormItemGi>
                      <NGi span="2">
                        <NFlex justify="end">
                          <NButton secondary @click="updatePacient(zap.pacient)">
                            Сохранить только этот блок
                          </NButton>
                        </NFlex>
                      </NGi>
                    </NGrid>
                  </NSpace>
                </NCollapseItem>

                <NCollapseItem title="Сведения о законченном случае">
                  <NGrid cols="2" x-gap="12" class="px-5">
                    <NFormItemGi label="Номер записи в реестре случаев" path="z_sl.idcase" >
                      <NInput v-model:value="zap.z_sl.idcase" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Условия оказания медицинской помощи" path="z_sl.usl_ok" >
                      <NInput v-model:value="zap.z_sl.usl_ok" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Вид медицинской помощи" path="z_sl.vidpom">
                      <NInput v-model:value="zap.z_sl.vidpom" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Форма оказания медицинской помощи" path="z_sl.for_pom">
                      <NInput v-model:value="zap.z_sl.for_pom" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Код МО, направившей на лечение" path="z_sl.npr_mo">
                      <NInput v-model:value="zap.z_sl.npr_mo" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Дата направления на лечение" path="z_sl.npr_date">
                      <NDatePicker v-model:formatted-value="zap.z_sl.npr_date" value-format="yyyy-MM-dd" class="w-full" />
                    </NFormItemGi>
                    <NFormItemGi label="Код МО" path="z_sl.lpu">
                      <NInput v-model:value="zap.z_sl.lpu" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Дата начала лечения" path="z_sl.date_z_1">
                      <NDatePicker v-model:formatted-value="zap.z_sl.date_z_1" value-format="yyyy-MM-dd" class="w-full" />
                    </NFormItemGi>
                    <NFormItemGi label="Дата окончания лечения" path="z_sl.date_z_2">
                      <NDatePicker v-model:formatted-value="zap.z_sl.date_z_2" value-format="yyyy-MM-dd" class="w-full" />
                    </NFormItemGi>
                    <NFormItemGi label="Результат диспансеризации" path="z_sl.rslt_d">
                      <NInput v-model:value="zap.z_sl.rslt_d" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Продолжительность госпитализации" path="z_sl.kd_z">
                      <NInput v-model:value="zap.z_sl.kd_z" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Вес при рождении" path="z_sl.vnov_m">
                      <NInput v-model:value="zap.z_sl.vnov_m" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Результат обращения" path="z_sl.rslt">
                      <NInput v-model:value="zap.z_sl.rslt" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Исход заболевания" path="z_sl.ishod">
                      <NInput v-model:value="zap.z_sl.ishod" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Особый случай" path="z_sl.os_sluch">
                      <NInput v-model:value="zap.z_sl.os_sluch" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Код способа оплаты медицинской помощи" path="z_sl.idsp">
                      <NInput v-model:value="zap.z_sl.idsp" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi label="Сумма, выставленная к оплате" path="z_sl.sumv">
                      <NInput v-model:value="zap.z_sl.sumv" placeholder="1" />
                    </NFormItemGi>
                    <NFormItemGi span="2" path="z_sl.vbr" :show-label="false" :show-feedback="false">
                      <NCheckbox v-model:checked="zap.z_sl.vbr" checked-value="1" unchecked-value="0" label="Признак мобильной медицинской бригады" />
                    </NFormItemGi>
                    <NFormItemGi span="2" path="z_sl.p_otk" :show-label="false" :show-feedback="false">
                      <NCheckbox v-model:checked="zap.z_sl.p_otk" checked-value="1" unchecked-value="0" label="Признак отказа" />
                    </NFormItemGi>
                    <NFormItemGi span="2" path="z_sl.vb_p" :show-label="false" :show-feedback="false">
                      <NCheckbox v-model:checked="zap.z_sl.vb_p" checked-value="1" unchecked-value="0" label="Признак внутрибольничного перевода" />
                    </NFormItemGi>

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
                        <NButton secondary v-if="sl.napr" @click="changeTabToNapr(sl.napr)">Сведения об оформлении направления</NButton>
                        <NButton secondary v-if="sl.cons" @click="changeTabToCons(sl.cons)">Сведения о проведении консилиума</NButton>
                        <NButton secondary v-if="sl.ksg_kpg" @click="changeTabToKsgKpg(sl.ksg_kpg)">Сведения о КСГ/КПГ</NButton>
                        <NButton secondary v-if="sl.onk_sl" @click="changeTabToOnkSl(sl.onk_sl)">Сведения о случае лечения онкологического заболевания</NButton>
                        <NButton secondary v-if="sl.ds2_n" @click="changeTabToDs2N(sl.ds2_n)">Сопутствующие заболевания</NButton>
                        <NButton secondary v-if="sl.naz" @click="changeTabToNaz(sl.naz)">Сведения об оформлении направлений</NButton>
                      </NFlex>
                      <NGrid cols="2" x-gap="12">
                        <NFormItemGi label="Подразделение МО" :path="`z_sl.sl[${index}].lpu_1`" >
                          <NInput v-model:value="sl.lpu_1" />
                        </NFormItemGi>
                        <NFormItemGi label="Вид ВМП" :path="`z_sl.sl[${index}].vid_hmp`" >
                          <NInput v-model:value="sl.vid_hmp" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Метод ВМП" :path="`z_sl.sl[${index}].metod_hmp`" >
                          <NInput v-model:value="sl.metod_hmp" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Код отделения" :path="`z_sl.sl[${index}].podr`" >
                          <NInput v-model:value="sl.podr" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Профиль медицинской помощи" :path="`z_sl.sl[${index}].profil`" >
                          <NInput v-model:value="sl.profil" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Профиль койки" :path="`z_sl.sl[${index}].profil_k`" >
                          <NInput v-model:value="sl.profil_k" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата выдачи талона на ВМП" :path="`z_sl.sl[${index}].tal_d`" >
                          <NDatePicker v-model:formatted-value="sl.tal_d" value-format="yyyy-MM-dd" class="w-full" />
                        </NFormItemGi>
                        <NFormItemGi label="Номер талона на ВМП" :path="`z_sl.sl[${index}].tal_num`" >
                          <NInput v-model:value="sl.tal_num" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата планируемой госпитализации" :path="`z_sl.sl[${index}].tal_d`" >
                          <NDatePicker v-model:formatted-value="sl.tal_d" value-format="yyyy-MM-dd" class="w-full" />
                        </NFormItemGi>
                        <NFormItemGi label="Цель посещения" :path="`z_sl.sl[${index}].p_cel`" >
                          <NInput v-model:value="sl.p_cel" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Номер истории болезни" :path="`z_sl.sl[${index}].nhistory`" >
                          <NInput v-model:value="sl.nhistory" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Признак поступления/перевода" :path="`z_sl.sl[${index}].p_per`" >
                          <NInput v-model:value="sl.p_per" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата начала лечения" :path="`z_sl.sl[${index}].date_1`" >
                          <NDatePicker v-model:formatted-value="sl.date_1" value-format="yyyy-MM-dd" class="w-full" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата окончания лечения" :path="`z_sl.sl[${index}].date_2`" >
                          <NDatePicker v-model:formatted-value="sl.date_2" value-format="yyyy-MM-dd" class="w-full" />
                        </NFormItemGi>
                        <NFormItemGi label="Продолжительность госпитализации" :path="`z_sl.sl[${index}].kd`" >
                          <NInput v-model:value="sl.kd" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Масса тела (кг)" :path="`z_sl.sl[${index}].wei`" >
                          <NInput v-model:value="sl.wei" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Диагноз первичный" :path="`z_sl.sl[${index}].ds0`" >
                          <NInput v-model:value="sl.ds0" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Диагноз основной" :path="`z_sl.sl[${index}].ds1`" >
                          <NInput v-model:value="sl.ds1" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Диагноз сопутствующего заболевания" :path="`z_sl.sl[${index}].ds2`" >
                          <NSelect
                              v-if="Array.isArray(sl.ds2)"
                              v-model:value="sl.ds2"
                              filterable
                              multiple
                              tag
                              :show-arrow="false"
                              :show="false"
                          />
                          <NInput v-else v-model:value="sl.ds2" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Диагноз осложнения заболевания" :path="`z_sl.sl[${index}].ds3`" >
                          <NSelect
                              v-if="Array.isArray(sl.ds3)"
                              v-model:value="sl.ds3"
                              filterable
                              multiple
                              tag
                              :show-arrow="false"
                              :show="false"
                          />
                          <NInput v-else v-model:value="sl.ds3" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Характер основного заболевания" :path="`z_sl.sl[${index}].c_zab`" >
                          <NInput v-model:value="sl.c_zab" placeholder="1" />
                        </NFormItemGi>
                        <NFormItem label="Диспансерное наблюдение" :path="`z_sl.sl[${index}].dn`" >
                          <NInput v-model:value="sl.dn" placeholder="1" />
                        </NFormItem>
                        <NFormItem label="Код стандарта медицинской помощи" :path="`z_sl.sl[${index}].code_mes1`" >
                          <NInput v-model:value="sl.code_mes1" placeholder="1" />
                        </NFormItem>
                        <NFormItemGi label="Код стандарта медицинской помощи СЗ" :path="`z_sl.sl[${index}].code_mes2`" >
                          <NInput v-model:value="sl.code_mes2" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Специальность лечащего врача" :path="`z_sl.sl[${index}].prvs`" >
                          <NInput v-model:value="sl.prvs" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Код КМС" :path="`z_sl.sl[${index}].vers_spec`" >
                          <NInput v-model:value="sl.vers_spec" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Код лечащего врача" :path="`z_sl.sl[${index}].iddokt`" >
                          <NInput v-model:value="sl.iddokt" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Кол-во ед. оплаты МП" :path="`z_sl.sl[${index}].ed_col`" >
                          <NInput v-model:value="sl.ed_col" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Тариф" :path="`z_sl.sl[${index}].tarif`" >
                          <NInput v-model:value="sl.tarif" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Стоимость случая" :path="`z_sl.sl[${index}].sum_m`" >
                          <NInput v-model:value="sl.sum_m" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Служебное поле" :path="`z_sl.sl[${index}].comentsl`" >
                          <NInput v-model:value="sl.comentsl" placeholder="1" />
                        </NFormItemGi>

                        <NFormItemGi span="2" path="sl.det" :show-label="false" :show-feedback="false">
                          <NCheckbox v-model:checked="sl.det" checked-value="1" unchecked-value="0" label="Признак детского профиля" />
                        </NFormItemGi>
                        <NFormItemGi span="2" path="sl.ds_onk" :show-label="false" :show-feedback="false">
                          <NCheckbox v-model:checked="sl.ds_onk" checked-value="1" unchecked-value="0" label="Признак подозрения на ЗНО" />
                        </NFormItemGi>
                        <NFormItemGi span="2" path="sl.reab" :show-label="false" :show-feedback="false">
                          <NCheckbox v-model:checked="sl.reab" checked-value="1" unchecked-value="0" label="Признак реабилитации" />
                        </NFormItemGi>

                        <NGi span="2">
                          <NFlex justify="end">
                            <NButton secondary @click="updateSl(sl)">
                              Сохранить только этот блок
                            </NButton>
                          </NFlex>
                        </NGi>
                      </NGrid>
                    </NSpace>
                  </NCollapseItem>
                </template>
              </NCollapse>
            </NTabPane>

            <NTabPane display-directive="if" name="pers">
              <NSpace :size="24" vertical>
                <NFlex>
                  <NButton secondary @click="changeTabToMain">
                    Вернуться к записи
                  </NButton>
                </NFlex>
                <NCollapse>
                  <NCollapseItem title="Персональные данные">
                    <NForm ref="persFormRef" :model="persRef">
                      <NGrid cols="2" x-gap="12" class="px-5">
                        <NFormItemGi label="Фамилия" path="fam">
                          <NInput v-model:value="persRef.fam" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Имя" path="im">
                          <NInput v-model:value="persRef.im" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Отчество" path="ot">
                          <NInput v-model:value="persRef.ot" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Пол" path="w">
                          <NInput v-model:value="persRef.w" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата рождения" path="dr">
                          <NDatePicker v-model:formatted-value="persRef.dr" value-format="yyyy-MM-dd" class="w-full" />
                        </NFormItemGi>
                        <NFormItemGi label="Код надежности идентификации" path="dost">
                          <NInput v-model:value="persRef.dost" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Номер телефона" path="tel">
                          <NInput v-model:value="persRef.tel" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Фамилия представителя" path="fam_p">
                          <NInput v-model:value="persRef.fam_p" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Имя представителя" path="im_p">
                          <NInput v-model:value="persRef.im_p" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Отчество представителя" path="ot_p">
                          <NInput v-model:value="persRef.ot_p" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Пол представителя" path="w_p">
                          <NInput v-model:value="persRef.w_p" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата рождения представителя" path="dr_p">
                          <NInput v-model:value="persRef.dr_p" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Код надежности идентификации представителя" path="dost_p">
                          <NInput v-model:value="persRef.dost_p" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Место рождения" path="mr">
                          <NInput v-model:value="persRef.mr" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Тип документа" path="doctype">
                          <NInput v-model:value="persRef.doctype" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Серия документа" path="docser">
                          <NInput v-model:value="persRef.docser" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Номер документа" path="docnum">
                          <NInput v-model:value="persRef.docnum" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата выдачи документа" path="docdate">
                          <NDatePicker v-model:formatted-value="persRef.docdate" value-format="yyyy-MM-dd" class="w-full" />
                        </NFormItemGi>
                        <NFormItemGi label="Орган выдавший документ" path="docorg">
                          <NInput v-model:value="persRef.docorg" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="СНИЛС" path="snils">
                          <NInput v-model:value="persRef.snils" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Код места жительства" path="okatog">
                          <NInput v-model:value="persRef.okatog" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Код места пребывания" path="okatop">
                          <NInput v-model:value="persRef.okatop" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Служебное поле" path="comentp">
                          <NInput v-model:value="persRef.comentp" placeholder="1" />
                        </NFormItemGi>

                        <NFormItemGi span="2" :show-label="false">
                          <NButton>
                            Сохранить
                          </NButton>
                        </NFormItemGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                </NCollapse>
              </NSpace>
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
                      <NGrid cols="2" x-gap="12" class="px-5">
                        <NFormItemGi label="Дата направления" :path="`${index}`">
                          <NDatePicker v-model:formatted-value="napr.napr_date" value-format="yyyy-MM-dd" class="w-full" />
                        </NFormItemGi>
                        <NFormItemGi label="Код МО, куда оформлено направление" path="napr_mo">
                          <NInput v-model:value="napr.napr_mo" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Вид направления" path="napr_v">
                          <NInput v-model:value="napr.napr_v" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Метод диагностического исследования" path="met_issl">
                          <NInput v-model:value="napr.met_issl" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Медицинская услуга (код)" path="napr_usl">
                          <NInput v-model:value="napr.napr_usl" placeholder="1" />
                        </NFormItemGi>
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
                  <NCollapseItem title="Сведения о проведении консилиума">
                    <NForm ref="zapFormRef" :model="consRef">
                      <NGrid cols="2" x-gap="12" class="px-5">
                        <NFormItemGi label="Цель проведения консилиума" path="pr_cons">
                          <NInput v-model:value="consRef.napr_date" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата направления консилиума" path="dt_cons">
                          <NDatePicker v-model:formatted-value="consRef.dt_cons" value-format="yyyy-MM-dd" class="w-full" />
                        </NFormItemGi>
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
                      <NGrid cols="2" x-gap="12" class="px-5">
                        <NFormItemGi label="Повод обращения" path="ds1_t">
                          <NInput v-model:value="onkSlRef.ds1_t" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Стадия заболевания" path="stad">
                          <NInput v-model:value="onkSlRef.stad" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Значение Tumor" path="onk_t">
                          <NInput v-model:value="onkSlRef.onk_t" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Значение Nodus" path="onk_n">
                          <NInput v-model:value="onkSlRef.onk_n" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Значение Metastasis" path="onk_m">
                          <NInput v-model:value="onkSlRef.onk_m" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Признак выявления отдаленных метастазов" path="mtstz">
                          <NInput v-model:value="onkSlRef.mtstz" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Суммарная очаговая доза" path="sod">
                          <NInput v-model:value="onkSlRef.sod" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Кол-во фракций проведения лучевой терапии" path="k_fr">
                          <NInput v-model:value="onkSlRef.k_fr" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Масса тела (кг)" path="wei">
                          <NInput v-model:value="onkSlRef.wei" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Рост (см)" path="hei">
                          <NInput v-model:value="onkSlRef.hei" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Площадь поверхности тела (м2)" path="bsa">
                          <NInput v-model:value="onkSlRef.bsa" placeholder="1" />
                        </NFormItemGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                  <NCollapseItem v-if="onkSlRef.b_diag?.length" title="Диагностический блок">
                    <NForm ref="onkSlFormRef" :model="onkSlRef.b_diag">
                      <NGrid cols="2" x-gap="12">
                        <NFormItem label="Дата взятия материала" path="diag_date">
                          <NInput v-model:value="onkSlRef.b_diag.diag_date" placeholder="1" />
                        </NFormItem>
                        <NFormItem label="Тип диагностического показателя" path="diag_tip">
                          <NInput v-model:value="onkSlRef.b_diag.diag_tip" placeholder="1" />
                        </NFormItem>
                        <NFormItem label="Код диагностического показателя" path="diag_code">
                          <NInput v-model:value="onkSlRef.b_diag.diag_code" placeholder="1" />
                        </NFormItem>
                        <NFormItem label="Код результата диагностики" path="diag_rslt">
                          <NInput v-model:value="onkSlRef.b_diag.diag_rslt" placeholder="1" />
                        </NFormItem>
                        <NFormItem label="Признак получения результата диагностики" path="rec_rslt">
                          <NInput v-model:value="onkSlRef.b_diag.rec_rslt" placeholder="1" />
                        </NFormItem>
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
                          <NFormItemGi label="Тип услуги" path="usl_tip">
                            <NInput v-model:value="onkSlRef.onk_usl.usl_tip" placeholder="1" />
                          </NFormItemGi>
                          <NFormItemGi label="Тип хирургического лечения" path="hir_tip">
                            <NInput v-model:value="onkSlRef.onk_usl.hir_tip" placeholder="1" />
                          </NFormItemGi>
                          <NFormItemGi label="Линия лекарственной терапии" path="lek_tip_l">
                            <NInput v-model:value="onkSlRef.onk_usl.lek_tip_l" placeholder="1" />
                          </NFormItemGi>
                          <NFormItemGi label="Цикл лекарственной терапии" path="lek_tip_v">
                            <NInput v-model:value="onkSlRef.onk_usl.lek_tip_v" placeholder="1" />
                          </NFormItemGi>
                          <NFormItemGi label="Признак проведения профилактики тошноты" path="pptr">
                            <NInput v-model:value="onkSlRef.onk_usl.pptr" placeholder="1" />
                          </NFormItemGi>
                          <NFormItemGi label="Тип лучевой терапии" path="luch_tip">
                            <NInput v-model:value="onkSlRef.onk_usl.luch_tip" placeholder="1" />
                          </NFormItemGi>
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
                      <NGrid cols="2" x-gap="12" class="px-5">
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

            <NTabPane display-directive="if" name="ksgkpg">
              <NSpace :size="24" vertical>
                <NFlex>
                  <NButton secondary @click="changeTabToMain">
                    Вернуться к записи
                  </NButton>
                </NFlex>
                <NCollapse>
                  <NCollapseItem v-for="(lekPr, index) in lekPrRef" :title="`${lekPr.date_inj}: Сведения о введенном лекарственном препарате (${lekPr.regnum})`">
                    <NForm ref="zapFormRef" :model="lekPr">
                      <NGrid cols="2" x-gap="12" class="px-5">
                        <NFormItemGi label="Дата введения" path="date_inj">
                          <NInput v-model:value="lekPr.date_inj" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Код схемы лекарственной терапии" path="code_sh">
                          <NInput v-model:value="lekPr.code_sh" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Идентификатор лекарственного препарата" path="regnum">
                          <NInput v-model:value="lekPr.regnum" placeholder="1" />
                        </NFormItemGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                </NCollapse>
              </NSpace>
            </NTabPane>

            <NTabPane display-directive="if" name="ds2n">
              <NSpace :size="24" vertical>
                <NFlex>
                  <NButton secondary @click="changeTabToMain">
                    Вернуться к записи
                  </NButton>
                </NFlex>
                <NCollapse>
                  <NCollapseItem v-for="(ds2n, index) in ds2NRef" :title="`$Сопутствующее заболевание (${ds2n.ds2})`">
                    <NForm ref="zapFormRef" :model="ds2n">
                      <NGrid cols="2" x-gap="12" class="px-5">
                        <NFormItemGi label="Диагноз сопутствующего заболевания" path="ds2">
                          <NInput v-model:value="ds2n.ds2" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Диспансерное наблюдение" path="pr_ds2_n">
                          <NInput v-model:value="ds2n.pr_ds2_n" placeholder="1" />
                        </NFormItemGi>

                        <NFormItemGi span="2" :show-label="false" path="ds2_pr">
                          <NCheckbox v-model:value="ds2n.ds2_pr" :unchecked-value="null" :checked-value="1" placeholder="1">
                            Установлен впервые (сопутствующий)
                          </NCheckbox>
                        </NFormItemGi>
                      </NGrid>
                    </NForm>
                  </NCollapseItem>
                </NCollapse>
              </NSpace>
            </NTabPane>

            <NTabPane display-directive="if" name="naz">
              <NSpace :size="24" vertical>
                <NFlex>
                  <NButton secondary @click="changeTabToMain">
                    Вернуться к записи
                  </NButton>
                </NFlex>
                <NCollapse>
                  <NCollapseItem v-for="(naz, index) in nazRef" :title="`$Сведения об оформлении направления (${naz.naz_z})`">
                    <NForm ref="zapFormRef" :model="naz">
                      <NGrid cols="2" x-gap="12" class="px-5">
                        <NFormItemGi label="Номер по порядку" path="naz_n">
                          <NInput v-model:value="naz.naz_n" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Вид назначения" path="naz_r">
                          <NInput v-model:value="naz.naz_r" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Специальность врача" path="naz_sp">
                          <NInput v-model:value="naz.naz_sp" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Метод диагностического исследования" path="naz_v">
                          <NInput v-model:value="naz.naz_v" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Медицинская услуга (код)" path="naz_usl">
                          <NInput v-model:value="naz.naz_usl" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Дата направления" path="napr_date">
                          <NInput v-model:value="naz.napr_date" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Код МО, куда оформлено направление" path="napr_mo">
                          <NInput v-model:value="naz.napr_mo" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Профиль медицинской помощи" path="naz_pmp">
                          <NInput v-model:value="naz.naz_pmp" placeholder="1" />
                        </NFormItemGi>
                        <NFormItemGi label="Профиль койки" path="naz_pk">
                          <NInput v-model:value="naz.naz_pk" placeholder="1" />
                        </NFormItemGi>
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