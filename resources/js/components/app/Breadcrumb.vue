<script setup>
import {LayoutSidebar} from "@vicons/tabler"
import {useLocalStorage} from "@vueuse/core"
const collapseMenu = useLocalStorage('collapse-menu', false)
</script>

<template>
    <NFlex align="center" style="height: 64px" size="small">
        <NButton @click="collapseMenu = !collapseMenu" quaternary style="--n-padding: 0 8px; --n-border-radius: 8px;">
            <NIcon :component="LayoutSidebar" size="18" />
        </NButton>
        <NDivider vertical />
    </NFlex>
</template>

<style scoped>

</style>
