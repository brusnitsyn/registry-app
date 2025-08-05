<script setup>
import {createDiscreteApi, darkTheme, dateRuRU, lightTheme, ruRU} from 'naive-ui'
import {useLocalStorage} from "@vueuse/core"

const theme = useLocalStorage('theme', 'dark')

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
            <div style="position: relative; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%); max-height: 450px; max-width: 450px;">
                <slot />
            </div>
        </NLayout>
    </NConfigProvider>
</template>

<style>

</style>
