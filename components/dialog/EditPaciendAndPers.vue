<script setup lang="ts">
import {format} from "date-fns";

type PacientRegistry = {
  id:number,
  id_pac:string,
  vpolis:number,
  spolis?:string,
  npolis?:string,
  enp?:string,
  st_okato?:string,
  smo?:string,
  smo_nam?:string,
  inv?:number,
  mse?:string,
  novor?:string,
  vnov_d?:string,
}

type Pers = {
  fam?:string,
  im:string,
  ot?:string,
  w:number,
  dr:string,
  snils?:string,
  okatog?:string,
  okatop?:string,
}

const registryStore = useRegistryStore()

const { currentPacient } = storeToRefs(registryStore)

const props = defineProps<{ hasOpen: boolean }>()

const fetching = ref(false)

const formModel = computed({
  get() {
    return currentPacient
  },
  set(value) {
    registryStore.$patch(value)
  }
})

const onSubmit = () => {
  console.log('Form submitted!')
}

const onClose = (value?:boolean) => {
  emits('update:open', value)
}

const emits = defineEmits([
  'update:open'
])

const getFormTitle = computed(() => `${currentPacient.value.pers?.fam} ${currentPacient.value.pers?.im} ${currentPacient.value.pers?.ot}`)

</script>

<template>
  <NModal :mask-closable="false" :show="hasOpen" @update:show="value => onClose(value)" @after-enter="">
    <NCard v-if="currentPacient" class="max-w-2xl" :title="getFormTitle">
      <template #header-extra>
        <NButton quaternary circle @click="onClose(false)">
          <template #icon>
            <NaiveIcon name="ri:close-fill" />
          </template>
        </NButton>
      </template>

      <NForm ref="formRef" :model="currentPacient">
        <NGrid x-gap="16" :cols="2">
          <NGi :span="2">
            <NFormItem label="Код записи о пациенте" path="id_pac">
              <NInput v-model:value="currentPacient.id_pac" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Тип документа ОМС" path="vpolis">
              <NInput v-model:value="currentPacient.vpolis" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Серия документа ОМС" path="spolis">
              <NInput v-model:value="currentPacient.spolis" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Номер документа ОМС" path="npolis">
              <NInput v-model:value="currentPacient.npolis" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Единый номер ОМС" path="enp">
              <NInput v-model:value="currentPacient.enp" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Регион страхования" path="st_okato">
              <NInput v-model:value="currentPacient.st_okato" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Реестровый номер СМО" path="smo">
              <NInput v-model:value="currentPacient.smo" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Наименование СМО" path="smo_nam">
              <NInput v-model:value="currentPacient.smo_nam" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Группа инвалидности" path="inv">
              <NInput v-model:value="currentPacient.inv" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Направление на МСЭ" path="mse">
              <NInput v-model:value="currentPacient.mse" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Признак новорождённого" path="novor">
              <NInput v-model:value="currentPacient.novor" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Вес при рождении" path="vnov_d">
              <NInput v-model:value="currentPacient.vnov_d" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
      </NForm>

      <template #action>
        <NFlex justify="space-between">
          <NButton strong secondary @click="onClose(false)">
            Отмена
          </NButton>
          <NButton type="primary" @click="onSubmit">
            Сохранить
          </NButton>
        </NFlex>
      </template>
    </NCard>
  </NModal>
</template>