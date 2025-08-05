<script setup>
import {breakpointsTailwind, useBreakpoints, useFetch, useLocalStorage} from "@vueuse/core";
import {Selector, Sun} from '@vicons/tabler'
import AppThemeSwitcher from "../AppThemeSwitcher.vue";
import {router, usePage} from "@inertiajs/vue3";
import {NIcon} from "naive-ui";
import {useAuthFetch} from "../../../../composables/useAuthFetch.js";
const collapseMenu = useLocalStorage('collapse-menu', false)
const user = usePage().props.auth.user
const breakpoints = useBreakpoints(breakpointsTailwind)
const smaller = breakpoints.smallerOrEqual('sm')
const options = computed(() => [
    {
        label: 'Выйти из учетной записи',
        key: 'exit',
        onClick: () => {
            useAuthFetch(route('web.logout')).post().then(() => {
                router.reload()
            })
        }
    }
])
const selectOption = (option) => {
    if (option.onClick)
        option.onClick()
}
</script>

<template>
    <NFlex vertical :wrap="false">
        <NFlex>
            <AppThemeSwitcher />
        </NFlex>
        <NDropdown v-if="!collapseMenu" :options="options" :placement="smaller ? 'bottom-end' : 'right-start'" trigger="click" style="border-radius: 4px; width: 240px;" @select="(key, option) => selectOption(option)">
            <NButton quaternary style="--n-border-radius: 8px; height: 48px; position: relative;" >
                <NFlex size="small" align="center" justify="start" :wrap="false" inline style="position: absolute; left: 11px;">
                    <div style="height: 32px; width: 32px; border-radius: 8px; border: var(--n-border-hover); border-style: dashed; background-size: 32px; background-clip: content-box; background-image: url('https://placeholder.co/32')" />
                    <transition>
                        <NSpace v-if="!collapseMenu" vertical align="start" :size="2" inline>
                        <span style="font-weight: 500;">
                            {{ user?.name }}
                        </span>
                            <NText v-text="'{{ role_name }}'">

                            </NText>
                        </NSpace>
                    </transition>
                </NFlex>
            </NButton>
        </NDropdown>
    </NFlex>
</template>

<style scoped>
.v-leave-active {
    transition: opacity .4s ease;
}
.v-enter-active {
    transition: opacity .3s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
