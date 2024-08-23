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

const props = defineProps<{ hasOpen: boolean, pacient_id?:number|null, zap_id?:number|null }>()

await useAsyncData(() => registryStore.fetchPacient(props.zap_id), {server: false})

const formModel = computed({
  get() {
    return currentPacient
  },
  set(value) {
    registryStore.$patch(value)
  }
})

// const backupFormModel = ref(null)

// watchEffect(() => {
//   if(props.schet !== null) {
//     formModel.value = props.schet
//     backupFormModel.value = props.schet
//   }
// })


const onSubmit = () => {
  console.log('Form submitted!')
}

const onClose = (value?:boolean) => {
  emits('update:open', value)
}

const emits = defineEmits([
  'update:open'
])

const getFormTitle = computed(() => `${currentPacient.pers.fam} ${currentPacient.pers.im} ${currentPacient.pers.ot}`)

// const formatDate = computed({
//   get() {
//     return new Date(formModel.value.dschet)
//   },
//   set(value:number) {
//     formModel.value.dschet = format(new Date(value), 'yyyy-MM-dd')
//   }
// })
</script>

<template>
  <ClientOnly>
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
                <NInput v-model:value="spolis" placeholder="" />
              </NFormItem>
            </NGi>
            <NGi>
              <NFormItem label="Номер документа ОМС" path="npolis">
                <NInput v-model:value="npolis" placeholder="" />
              </NFormItem>
            </NGi>
          </NGrid>
          <NGrid x-gap="16" :cols="2">
            <NGi>
              <NFormItem label="Единый номер ОМС" path="enp">
                <NInput v-model:value="enp" placeholder="" />
              </NFormItem>
            </NGi>
            <NGi>
              <NFormItem label="Регион страхования" path="st_okato">
                <NInput v-model:value="st_okato" placeholder="" />
              </NFormItem>
            </NGi>
          </NGrid>
          <NGrid x-gap="16" :cols="2">
            <NGi>
              <NFormItem label="Реестровый номер СМО" path="smo">
                <NInput v-model:value="smo" placeholder="" />
              </NFormItem>
            </NGi>
            <NGi>
              <NFormItem label="Наименование СМО" path="smo_nam">
                <NInput v-model:value="smo_nam" placeholder="" />
              </NFormItem>
            </NGi>
          </NGrid>
          <NGrid x-gap="16" :cols="2">
            <NGi>
              <NFormItem label="Группа инвалидности" path="inv">
                <NInput v-model:value="inv" placeholder="" />
              </NFormItem>
            </NGi>
            <NGi>
              <NFormItem label="Направление на МСЭ" path="mse">
                <NInput v-model:value="mse" placeholder="" />
              </NFormItem>
            </NGi>
          </NGrid>
          <NGrid x-gap="16" :cols="2">
            <NGi>
              <NFormItem label="Признак новорождённого" path="novor">
                <NInput v-model:value="novor" placeholder="" />
              </NFormItem>
            </NGi>
            <NGi>
              <NFormItem label="Вес при рождении" path="vnov_d">
                <NInput v-model:value="vnov_d" placeholder="" />
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
  </ClientOnly>
</template>