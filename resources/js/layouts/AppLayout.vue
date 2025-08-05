<script setup>
import {darkTheme, dateRuRU, lightTheme, ruRU} from 'naive-ui'
import Breadcrumb from "../components/app/Breadcrumb.vue"
import Sidebar from "../components/app/sidebar/Sidebar.vue"
import {breakpointsTailwind, useBreakpoints, useLocalStorage} from "@vueuse/core"

const props = defineProps({
    title: String
})
const theme = useLocalStorage('theme', 'dark')

const breakpoints = useBreakpoints(breakpointsTailwind)
const mediumAndLarger = breakpoints.greaterOrEqual('sm')

const currentTheme = computed({
    get: () => {
        if (theme.value === 'dark') return darkTheme
        else return lightTheme
    }
})

const themeOverrides = {
    common: {
        borderRadius: '8px'
    }
}
</script>

<template>
    <NConfigProvider :theme="currentTheme" :theme-overrides="themeOverrides" :locale="ruRU" :date-locale="dateRuRU">
        <NLayout position="absolute">
            <NLayout :has-sider="mediumAndLarger" position="absolute">
                <Sidebar />
                <NLayout style="padding: 8px;" :style="theme === 'dark' ? 'background-color: rgb(24, 24, 28);' : 'background-color: rgb(250, 250, 250);'"  :native-scrollbar="false">
                    <NFlex vertical :size="0" style="background-color: var(--n-color); height: calc(100vh - 16px); border-radius: 12px; padding-left: 16px; padding-right: 16px; padding-bottom: 16px; overflow: hidden">
                        <NFlex align="center" justify="space-between">
                            <NSpace align="center">
                                <Breadcrumb />
                                <NH2 style="font-size: 16px; margin-bottom: 0; margin-top: 0; font-weight: 500;">
                                    {{ title }}
                                </NH2>
                            </NSpace>
                            <slot name="header-extension" />
                        </NFlex>
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
