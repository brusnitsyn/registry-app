<script setup>
import { VisXYContainer, VisLine, VisAxis } from '@unovis/vue'

const props = defineProps({
    data: Array,
    xKey: String,
    yKey: String,
    height: {
        type: Number,
        default: 100
    }
})

const x = (d) => {
    return new Date(d[props.xKey])
}
const y = (d) => {
    return d[props.yKey]
}
</script>

<template>
    <NEl>
        <VisXYContainer :data="data" :height="height">
            <VisLine :x="x" :y="y" color="var(--success-color)" />
        </VisXYContainer>
    </NEl>
</template>

<style scoped>

</style>
