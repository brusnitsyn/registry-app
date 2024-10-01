<script setup lang="ts">
import {useHeaderRegistryStore} from "~/stores/headerRegistry";
const headerRegistryStore = useHeaderRegistryStore()

const { registryHeaders } = storeToRefs(headerRegistryStore)
const { getAllRegistryHeader } = headerRegistryStore

await getAllRegistryHeader()

async function goToRegistry(registryId: number) {
  await useRouter().push({
    name: 'ws',
    query: {
      registryId
    }
  })
}
</script>

<template>
  <div class="container max-w-4xl">

    <div class="py-12 pt-20 flex flex-row items-center justify-center leading-9 text-center">
      <NH1 class="max-w-[270px]">
        Реестры как смысл бытия нашего...
      </NH1>
    </div>

    <NList hoverable clickable>
      <NListItem v-for="registryHeader in registryHeaders" @click="goToRegistry(registryHeader.id)">
        <NThing :title="registryHeader.label">
          <template #description>
            <NSpace size="small" class="mt-2">
              <NTag :bordered="false" type="info" size="small">
                ТМ:МИС
              </NTag>
            </NSpace>
          </template>
        </NThing>
      </NListItem>
    </NList>
<!--      <pre>-->
<!--        {{ useHeaderRegistryStore().registryHeaders }}-->
<!--      </pre>-->
  </div>
</template>

<style scoped>

</style>