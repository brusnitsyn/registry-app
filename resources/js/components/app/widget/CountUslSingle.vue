<script setup>
import LineDiagram from "../diagram/LineDiagram.vue"
import Card from "../card/Card.vue"
import {useAuthFetch} from "../../../../composables/useAuthFetch.js";

const props = defineProps({
    title: String,
})

const countUsls = ref(0)
const dataUsls = ref([])
const isLoading = ref(true)

onMounted(async() => {
    isLoading.value = true
    const {data} = await useAuthFetch(route('api.diagram.usl.count')).get().json()
    countUsls.value = data.value?.count ?? '---'
    dataUsls.value = data.value?.diagram.map(itm => ({
        ...itm,
        month: new Date(itm.month)
    }))

    isLoading.value = false
})
</script>

<template>
    <Card style="height: auto;">
        <NFlex size="small" vertical>
            <NSkeleton v-if="isLoading" width="168px" height="22px" style="border-radius: 8px"  />
            <NText v-else>
                Общее количество разовых услуг
            </NText>
            <NSkeleton v-if="isLoading" width="68px" height="35px" style="border-radius: 8px"  />
            <NH2 v-else style="margin-top: 0; margin-bottom: 0;">
                {{ countUsls }}
            </NH2>
            <NSkeleton v-if="isLoading" width="100%" height="100px" style="border-radius: 8px" />
            <LineDiagram v-else :data="dataUsls" x-key="month" y-key="count" />
        </NFlex>
    </Card>
</template>

<style scoped>

</style>
