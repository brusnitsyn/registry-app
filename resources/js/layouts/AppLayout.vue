<script setup>
import { darkTheme, lightTheme } from 'naive-ui'
import Breadcrumb from "../components/app/Breadcrumb.vue"
import Sidebar from "../components/app/sidebar/Sidebar.vue"
import {breakpointsTailwind, useBreakpoints, useLocalStorage} from "@vueuse/core"

const theme = useLocalStorage('theme', 'dark')

const breakpoints = useBreakpoints(breakpointsTailwind)
const mediumAndLarger = breakpoints.greaterOrEqual('sm')

const currentTheme = computed({
    get: () => {
        if (theme.value === 'dark') return darkTheme
        else return lightTheme
    }
})
</script>

<template>
    <NConfigProvider :theme="currentTheme">
        <NLayout position="absolute">
            <NLayout :has-sider="mediumAndLarger" position="absolute">
                <Sidebar />
                <NLayout style="padding: 8px; height: 100%" :style="theme === 'dark' ? 'background-color: rgb(24, 24, 28);' : 'background-color: rgb(250, 250, 250);'"  :native-scrollbar="false">
                    <NFlex vertical style="background-color: var(--n-color); min-height: calc(100svh - 16px); border-radius: 12px; max-height: 100svh; padding-left: 16px; padding-right: 16px; padding-bottom: 16px;">
                        <Breadcrumb />
                        <slot />
                    </NFlex>
                </NLayout>
            </NLayout>
        </NLayout>
    </NConfigProvider>
</template>

<style>
:deep(.n-scrollbar > .n-scrollbar-container > .n-scrollbar-content) {
    height: 100%;
}
#app {
    max-height: 100vh;
    height: 100vh;
    width: 100vw;
    max-width: 100vw;
    position: relative;
}
</style>
