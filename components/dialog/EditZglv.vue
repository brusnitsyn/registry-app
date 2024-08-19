<script setup lang="ts">
import {toTypedSchema} from "@vee-validate/zod"
import * as z from 'zod'
import {useForm} from "vee-validate"

const formSchema = toTypedSchema(z.object({
  version: z.string(),
  data: z.string(),
  filename: z.string(),
  sd_z: z.string(),
}))

const form = useForm({
  validationSchema: formSchema,
})

const onSubmit = form.handleSubmit((values) => {
  console.log('Form submitted!', values)
})

const emits = defineEmits([
  'update:open'
])
const props = defineProps<{ hasOpen: boolean }>()
</script>

<template>
  <Dialog :open="hasOpen" @update:open="value => emits('update:open', value)">
    <DialogContent class="max-w-2xl w-full">
      <DialogHeader>
        <DialogTitle>Редактирование заголовка файла</DialogTitle>
        <DialogDescription>
        </DialogDescription>
      </DialogHeader>

      <form>
        <div class="grid grid-cols-2 gap-2 gap-x-4">
          <FormField v-slot="{ componentField }" name="version">
            <FormItem>
              <FormLabel>Версия взаимодействия</FormLabel>
              <FormControl>
                <Input type="text" placeholder="" v-bind="componentField" />
              </FormControl>
              <FormDescription>
                Текущей редакции соответствует значение «3.2»
              </FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField }" name="data">
            <FormItem>
              <FormLabel>Дата</FormLabel>
              <FormControl>
                <Input type="text" placeholder="" v-bind="componentField" />
              </FormControl>
              <FormDescription>
                Дата выгрузки счета
              </FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField }" name="filename">
            <FormItem>
              <FormLabel>Имя файла</FormLabel>
              <FormControl>
                <Input type="text" placeholder="" v-bind="componentField" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
          <FormField v-slot="{ componentField }" name="sd_z">
            <FormItem>
              <FormLabel>Количество записей в файле</FormLabel>
              <FormControl>
                <Input type="text" placeholder="" v-bind="componentField" />
              </FormControl>
              <FormDescription>
                Количество записей о случаях оказания медицинской помощи
              </FormDescription>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
      </form>

      <DialogFooter>
        <Button @click="onSubmit" type="submit">
          Сохранить
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>