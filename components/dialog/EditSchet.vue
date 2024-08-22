<script setup lang="ts">
import {format} from "date-fns";

type SchetRegistry = {
  id:number,
  code:string,
  code_mo:string,
  year:number,
  month:number,
  nschet:string,
  dschet:string,
  plat:string,
  summav:string,
  coments:string,
}

const props = defineProps<{ hasOpen: boolean, schet:SchetRegistry|null }>()

const formModel = ref({
  code: '',
  code_mo: '',
  year: '',
  month: '',
  nschet: '',
  dschet: '',
  plat: '',
  summav: '',
  coments: '',
})

const backupFormModel = ref(null)

watchEffect(() => {
  if(props.schet !== null) {
    formModel.value = props.schet
    backupFormModel.value = props.schet
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

const formatDate = computed({
  get() {
    return new Date(formModel.value.dschet)
  },
  set(value:number) {
    formModel.value.dschet = format(new Date(value), 'yyyy-MM-dd')
  }
})
</script>

<template>
  <NModal :mask-closable="false" :show="hasOpen" @update:show="value => onClose(value)">
    <NCard class="max-w-2xl" title="Редактирование счёта">
      <template #header-extra>
        <NButton quaternary circle @click="onClose(false)">
          <template #icon>
            <NaiveIcon name="ri:close-fill" />
          </template>
        </NButton>
      </template>

      <NForm ref="formRef" :model="formModel">
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Код записи счета" path="code">
              <NInput v-model:value="formModel.code" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Номер медицинской организации" path="code_mo">
              <NInput v-model:value="formModel.code_mo" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Отчетный год" path="year">
              <NInput v-model:value="formModel.year" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Отчетный месяц" path="month">
              <NInput v-model:value="formModel.month" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Номер счёта" path="nschet">
              <NInput v-model:value="formModel.nschet" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Дата выставления счёта" path="dschet">
              <NDatePicker v-model:value="formatDate" format="dd.MM.yyyy" type="date" class="w-full" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Плательщик" path="plat">
              <NInput v-model:value="formModel.plat" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Сумма счёта" path="summav">
              <NInput v-model:value="formModel.summav" placeholder="" />
            </NFormItem>
          </NGi>
        </NGrid>
        <NFormItem label="Служебное поле" path="coments">
          <NInput v-model:value="formModel.coments" placeholder="" />
        </NFormItem>
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