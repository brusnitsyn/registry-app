<script setup>
import AppLayout from "../../layouts/AppLayout.vue";
import Card from "../../components/app/card/Card.vue";
import { VisXYContainer, VisStackedBar, VisCrosshair, VisGroupedBar, VisBrush, VisAxis } from '@unovis/vue'

defineOptions({ layout: AppLayout })
const props = defineProps({
    chartData: Array,
    serviceCount: Number
})
const areaColor = '#93c5fd' // blue-300
const duration = ref(0)
const domain = ref([0, 20])
const updateDomain = (selection, _, userDriven) => {
    if (userDriven) {
        // We set duration to 0 to update the main chart immediately (without animation) after the brush event
        duration.value = 0
        domain.value = selection
    }
}
</script>

<template>
    <NFlex style="flex: 1 1 0;">
        <NGrid :cols="4" y-gap="16" x-gap="16">
            <NGi>
                <Card :title="`Всего услуг в реестре: ${serviceCount}`">

                </Card>
            </NGi>
            <NGi span="3">
                <VisXYContainer :duration="duration" :data="chartData" :xDomain="domain" :scaleByDomain="true">
                    <VisStackedBar
                        :x="(d, i) => i"
                        :y="(d) => d.count"
                        :color="areaColor"
                        :opacity="0.4"
                        :barMinHeight="100"
                    />
                    <VisAxis
                        type="x"
                        :tickFormat="(index) => chartData[index]?.code || ''"
                    />
                    <VisAxis
                        type="y"
                        :label="'Количество'"
                    />
                </VisXYContainer>
                <VisXYContainer :data="chartData" :height="75" :margin="{ left: 60 }">
                    <VisGroupedBar :x="(d, i) => i"
                                   :y="(d) => d.count" />
                    <VisBrush :selectionMinLength="2"  :selection="domain" :onBrush="updateDomain" :draggable="true" />
                    <VisAxis type='x' :numTicks="15" :tickFormat="(index) => chartData[index]?.code || ''" />
                </VisXYContainer>
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
