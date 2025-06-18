<script setup>
import {breakpointsTailwind, useBreakpoints, useLocalStorage} from "@vueuse/core";
import {Link, usePage} from "@inertiajs/vue3";
import SidebarHeader from "./SidebarHeader.vue";
import SidebarFooter from "./SidebarFooter.vue";

const collapseMenu = useLocalStorage('collapse-menu', false)
const theme = useLocalStorage('theme', 'dark')
const breakpoints = useBreakpoints(breakpointsTailwind)
const smaller = breakpoints.smallerOrEqual('sm')

const collapseDrawer = computed({
    get: () => {
        return !collapseMenu.value
    },
    set: (value) => {
        collapseMenu.value = !value
    }
})
const menuOptions = usePage().props.menu.map(item => {
    if (item.href !== null) {
        return {
            ...item,
            label: () => h(
                Link,
                {
                    href: route(item.href)
                },
                item.label
            )
        }
    } else {
        return item
    }
})
</script>

<template>
    <NDrawer v-if="smaller" v-model:show="collapseDrawer" placement="left" style="--n-body-padding: 8px 8px;" :style="theme === 'dark' ? 'background-color: rgb(24, 24, 28);' : 'background-color: rgb(250, 250, 250);'">
        <NDrawerContent>
            <NFlex justify="space-between" vertical :wrap="false" style="height: calc(100svh - 32px);">
                <NFlex :wrap="false" vertical>
                    <SidebarHeader />
                    <NMenu
                        :collapsed="collapseMenu"
                        :collapsed-width="64"
                        :collapsed-icon-size="22"
                        :options="menuOptions"
                    />
                </NFlex>
                <SidebarFooter />
            </NFlex>
        </NDrawerContent>
    </NDrawer>
    <NLayoutSider v-else style="padding-left: 8px; padding-bottom: 16px; padding-top: 16px; overflow-x: hidden;"
                  :style="theme === 'dark' ? 'background-color: rgb(24, 24, 28);' : 'background-color: rgb(250, 250, 250);'"
                  collapse-mode="width"
                  :collapsed-width="64"
                  :native-scrollbar="false"
                  :width="248"
                  :collapsed="collapseMenu">
        <NFlex justify="space-between" vertical :wrap="false" style="height: calc(100svh - 32px);">
            <NFlex :wrap="false" vertical>
                <SidebarHeader />
                <NMenu
                    :collapsed="collapseMenu"
                    :collapsed-width="64"
                    :collapsed-icon-size="22"
                    :options="menuOptions"
                />
            </NFlex>
            <SidebarFooter />
        </NFlex>
    </NLayoutSider>
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
