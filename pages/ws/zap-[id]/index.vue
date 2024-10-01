<script setup lang="ts">
const zapId = useRoute().params.id
const zapStore = useZapRegistryStore()
const {getZap} = zapStore
const {zap} = storeToRefs(zapStore)
await getZap(zapId)

const getZapElement = computed(() => {
  const zapComma = { zap: zap.value }
  return zapComma
})

// JSON.stringify(zap, null, 2)

</script>

<template>
  <NGrid cols="5" item-responsive responsive="screen" class="py-8 px-10 max-h-screen overflow-hidden">
    <NGridItem span="m:2">
      <ClientOnly>
        <CoreEditorCode :code="getZapElement" />
        <template #fallback>
          <NSkeleton :width="648" height="100%" />
        </template>
      </ClientOnly>
    </NGridItem>
    <NGridItem span="m:3" class="max-w-2xl">
      <NCollapse>
        <NScrollbar>
          <NCollapseItem title="Запись">
            <NForm ref="zapFormRef" :model="zap">
              <NGrid cols="1" x-gap="12">
                <NGi>
                  <NFormItem label="Номер позации записи" path="n_zap" :show-feedback="false">
                    <NInput v-model:value="zap.n_zap" placeholder="1" />
                  </NFormItem>
                </NGi>
                <NGi>
                  <NFormItem path="pr_nov" :show-label="false" :show-feedback="false">
                    <NCheckbox v-model:checked="zap.pr_nov" label="Признак исправленной записи" />
                  </NFormItem>
                </NGi>
              </NGrid>
            </NForm>
          </NCollapseItem>
          <NCollapseItem title="Сведения о пациенте">
            <NGrid cols="2" x-gap="12">
              <NGi>
                <NFormItem label="Тип документа ОМС" path="pacient.vpolis" >
                  <NInput v-model:value="zap.pacient.vpolis" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Серия документа ОМС" path="pacient.spolis" >
                  <NInput v-model:value="zap.pacient.spolis" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi span="2">
                <NFormItem label="Номер документа, подтверждающего факт страхования по ОМС" path="pacient.npolis">
                  <NInput v-model:value="zap.pacient.npolis" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi span="2">
                <NFormItem label="Единый номер полиса обязательного медицинского страхования" path="pacient.enp">
                  <NInput v-model:value="zap.pacient.enp" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Регион страхования" path="pacient.st_okato">
                  <NInput v-model:value="zap.pacient.st_okato" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Реестровый номер СМО" path="pacient.smo">
                  <NInput v-model:value="zap.pacient.smo" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Группа инвалидности" path="pacient.inv">
                  <NInput v-model:value="zap.pacient.inv" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Признак новорожденного" path="pacient.novor">
                  <NInput v-model:value="zap.pacient.novor" placeholder="1" />
                </NFormItem>
              </NGi>
            </NGrid>
          </NCollapseItem>
          <NCollapseItem title="Сведения о законченном случае">
            <NGrid cols="2" x-gap="12">
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
              <NGi span="2">
                <NFormItem label="Вид медицинской помощи" path="z_sl.vidpom">
                  <NInput v-model:value="zap.z_sl.vidpom" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi span="2">
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
                  <NInput v-model:value="zap.z_sl.npr_date" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Код МО" path="z_sl.lpu">
                  <NInput v-model:value="zap.z_sl.lpu" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Дата начала лечения" path="z_sl.date_z_1">
                  <NInput v-model:value="zap.z_sl.date_z_1" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Дата окончания лечения" path="z_sl.date_z_2">
                  <NInput v-model:value="zap.z_sl.date_z_2" placeholder="1" />
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
                  <NInput v-model:value="zap.z_sl.vnov_m" placeholder="1" />
                </NFormItem>
              </NGi>
              <NGi>
                <NFormItem label="Исход заболевания" path="z_sl.ishod">
                  <NInput v-model:value="zap.z_sl.ishod" placeholder="1" />
                </NFormItem>
              </NGi>
            </NGrid>
          </NCollapseItem>
        </NScrollbar>
      </NCollapse>
    </NGridItem>
  </NGrid>
</template>

<style scoped>
:deep(.cdx-block .ce-code__textarea) {
  @apply !h-[92vh];
}
</style>