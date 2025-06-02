<script setup>
import AppLayout from "../layouts/AppLayout.vue";

defineOptions({ layout: AppLayout })
</script>

<template>
    <NFlex style="flex: 1 1 0;">
        <NGrid :cols="4">
            <NGi span="3">
                span 3/4
            </NGi>
            <NGi>
                span 1
            </NGi>
            <NGi span="4">
                span 4/4
            </NGi>
        </NGrid>
    </NFlex>
</template>

<style scoped>

</style>
