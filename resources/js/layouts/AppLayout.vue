<script setup>
import { darkTheme } from 'naive-ui'
import Breadcrumb from "../components/app/Breadcrumb.vue"
import Sidebar from "../components/app/sidebar/Sidebar.vue"
import {useLocalStorage} from "@vueuse/core"
import SidebarHeader from "../components/app/sidebar/SidebarHeader.vue";
const collapseMenu = useLocalStorage('collapse-menu', false)
</script>

<template>
    <NConfigProvider :theme="darkTheme">
        <NLayout position="absolute">
            <NLayout has-sider position="absolute">
                <NLayoutSider style="padding-left: 8px; padding-bottom: 8px; padding-top: 16px;"
                              collapse-mode="width"
                              :collapsed-width="64"
                              :width="248"
                              :collapsed="collapseMenu">
                    <NFlex vertical>
                        <SidebarHeader />
                        <Sidebar />
                    </NFlex>
                </NLayoutSider>
                <NLayout style="padding: 8px; background-color: rgb(24, 24, 28); height: 100%" :native-scrollbar="false">
                    <NFlex vertical style="background-color: var(--n-color); min-height: calc(100svh - 32px); border-radius: 12px; max-height: 100svh; padding-left: 16px; padding-right: 16px; padding-bottom: 16px;">
                        <Breadcrumb />
                        <slot />
                    </NFlex>
                </NLayout>
            </NLayout>
        </NLayout>
    </NConfigProvider>
</template>

<style>
#app {
    max-height: 100vh;
    height: 100vh;
    width: 100vw;
    max-width: 100vw;
    position: relative;
}
</style>
