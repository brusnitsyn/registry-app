<script setup>
import AppLayout from "../../layouts/AppLayout.vue";
import Card from "../../components/app/card/Card.vue";
import { VisSingleContainer, VisDonut, VisBulletLegend, VisTooltip } from '@unovis/vue'
import {Donut} from "@unovis/ts";

defineOptions({ layout: AppLayout })
const props = defineProps({
    chartData: Array,
    servicesWithDepartment: Array,
    serviceCount: Number
})
const legendItems = Object.entries(props.servicesWithDepartment).map(([_, data]) => ({
    name: data.department
}))
const triggers = { [Donut.selectors.segment]: (d) => `<div style="display: flex; flex-direction: column;">${d.data.department}<br>${d.data.count}</div>` }
</script>

<template>
    <NFlex style="flex: 1 1 0;">
        <NGrid :cols="4" y-gap="16" x-gap="16">
            <NGi>
                <Card :title="`Общее количество услуг: ${serviceCount}`">
                    <VisBulletLegend :items="legendItems" />
                    <VisSingleContainer :data="servicesWithDepartment" :height="400">
                        <VisTooltip :triggers="triggers" />
                        <VisDonut :value="(d) => d.percentage"
                                  :showEmptySegments="false"
                                  :arcWidth="0"/>
                    </VisSingleContainer>
                </Card>
            </NGi>
            <NGi span="3">

            </NGi>
            <NGi span="2">
                span 2/4
            </NGi>
            <NGi span="4">
                span 4/4
            </NGi>
        </NGrid>
    </NFlex>
</template>

<style scoped>

</style>
