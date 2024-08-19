<script setup lang="ts">
import {toTypedSchema} from "@vee-validate/zod"
import * as z from 'zod'
import {useForm} from "vee-validate"

const formSchema = toTypedSchema(z.object({
  code: z.string(),
  code_mo: z.string(),
  year: z.string(),
  month: z.string(),
  nschet: z.string(),
  dschet: z.string(),
  plat: z.string(),
  summav: z.string(),
  coments: z.string(),
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
        <DialogTitle>Редактирование счёта</DialogTitle>
        <DialogDescription>
        </DialogDescription>
      </DialogHeader>

      <form class="grid grid-cols-2 gap-2 gap-x-4">
        <FormField v-slot="{ componentField }" name="code">
          <FormItem>
            <FormLabel>Код записи счета</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormDescription>
              Уникальный код (например, порядковый номер)
            </FormDescription>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="code_mo">
          <FormItem>
            <FormLabel>Номер медицинской организации</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormDescription>
              Заполняется в соответствии со справочником F003
            </FormDescription>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="year">
          <FormItem>
            <FormLabel>Отчетный год</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="month">
          <FormItem>
            <FormLabel>Отчетный месяц</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="nschet">
          <FormItem>
            <FormLabel>Номер счёта</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="dschet">
          <FormItem>
            <FormLabel>Дата выставления счёта</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="plat">
          <FormItem>
            <FormLabel>Плательщик</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="summav">
          <FormItem>
            <FormLabel>Сумма счёта</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
      </form>

      <DialogFooter>
        <Button @click="onSubmit" type="submit">
          Сохранить
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>