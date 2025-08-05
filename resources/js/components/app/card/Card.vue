<script setup>
const props = defineProps({
    title: String
})
</script>

<template>
    <NCard :title="title" bordered style="height: 100%; border-radius: 8px;">
        <slot />
        <template #footer>
            <slot name="footer" />
        </template>
    </NCard>
</template>

<style scoped>

</style>
