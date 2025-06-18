<script setup>
const props = defineProps({
    title: String
})
</script>

<template>
    <NCard :title="title" bordered style="height: 100%; border-radius: 8px;">
        <slot />
    </NCard>
</template>

<style scoped>

</style>
