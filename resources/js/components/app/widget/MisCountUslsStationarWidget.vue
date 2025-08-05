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
    const {data} = await useAuthFetch(route('api.mis.diagram.stationar.usl.count')).get().json()
    countUsls.value = data.value.count

    isLoading.value = false
})
</script>

<template>
    <Card style="height: auto;">
        <NFlex size="small" vertical>
            <NSkeleton v-if="isLoading" width="168px" height="22px" style="border-radius: 8px"  />
            <NText v-else>
                <b>Стационар</b><br>
                Общее количество услуг
            </NText>
            <NSkeleton v-if="isLoading" width="68px" height="35px" style="border-radius: 8px"  />
            <NH2 v-else style="margin-top: 0; margin-bottom: 0;">
                {{ countUsls }}
            </NH2>
<!--            <NSkeleton v-if="isLoading" width="100%" height="100px" style="border-radius: 8px" />-->
<!--            <LineDiagram v-else :data="dataUsls" x-key="count" y-key="month" />-->
        </NFlex>
    </Card>
</template>

<style scoped>

</style>
