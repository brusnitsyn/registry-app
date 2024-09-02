<script setup lang="ts">
import {useRouteQuery} from "@vueuse/router";

const zlListId = useRouteQuery('zlListId', null)

const {data} = await useAPI(`/api/registry/zl-list/${zlListId.value}/errors`)

const getTypeError = (value:string) => {
  switch (value) {
    case 'App\\Models\\UslRegistry':
      return 'usl'
  }
}

</script>

<template>
  <PageBody>
<!--    <pre>{{data}}</pre>-->
    <NList>
      <NListItem v-for="item in data" :key="item.id">
        <template v-if="getTypeError(item.errorable_type) === 'usl'">
          <NThing :title="item.oshib">
            <NP class="w-9/12">
              {{ item.comment }}
            </NP>
            <NButton>
              Редактировать услугу
            </NButton>
          </NThing>
        </template>
      </NListItem>
    </NList>
  </PageBody>
</template>

<style scoped>

</style>