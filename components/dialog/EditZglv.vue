<script setup lang="ts">

type ZglvRegistry = {
  id:number,
  version:string,
  data:string,
  filename:string,
  filename1:string,
  sd_z:number,
}

const props = defineProps<{ hasOpen: boolean, zglv: any }>()

const formModel = ref({
  version: '',
  data: '',
  filename: '',
  sd_z: ''
})

watchEffect(() => {
  if(props.zglv !== null) formModel.value = props.zglv
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

</script>

<template>
  <NModal :mask-closable="false" :show="hasOpen" @update:show="value => onClose(value)">
    <NCard class="max-w-2xl" title="Редактирование заголовка файла">
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
            <NFormItem label="Имя файла" path="filename">
              <NInput v-model:value="formModel.filename" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Дата" path="data">
              <NInput v-model:value="formModel.data" placeholder="" />
<!--              <NDatePicker v-model:value="formModel.data" type="date" />-->
            </NFormItem>
          </NGi>
        </NGrid>
        <NGrid x-gap="16" :cols="2">
          <NGi>
            <NFormItem label="Версия взаимодействия" path="version">
              <NInput v-model:value="formModel.version" placeholder="" />
            </NFormItem>
          </NGi>
          <NGi>
            <NFormItem label="Количество записей в файле" path="sd_z">
              <NInput v-model:value="formModel.sd_z" placeholder="" />
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