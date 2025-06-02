<script setup>
import {useLocalStorage} from "@vueuse/core";

const collapseMenu = useLocalStorage('collapse-menu', false)
const menuOptions = [
    {
        label: 'Медицинские услуги',
        key: 'medical-services',
        href: 'https://en.wikipedia.org/wiki/Hear_the_Wind_Sing'
    }
]
</script>

<template>
    <NMenu
        :collapsed="collapseMenu"
        :collapsed-width="64"
        :collapsed-icon-size="22"
        :options="menuOptions"
    />
</template>

<style scoped>
:deep(.n-menu-item-content) {
    padding-left: 14px !important;
}
:deep(.n-menu-item-content::before) {
    left: 4px;
    right: 4px;
    border-radius: 8px;
}
</style>
