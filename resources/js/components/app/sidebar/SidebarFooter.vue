<script setup>
import {useLocalStorage} from "@vueuse/core";
import {Sun} from '@vicons/tabler'
import AppThemeSwitcher from "../AppThemeSwitcher.vue";
const collapseMenu = useLocalStorage('collapse-menu', false)
</script>

<template>
    <NFlex vertical :wrap="false">
        <NFlex>
            <AppThemeSwitcher />
        </NFlex>
        <NButton quaternary style="--n-border-radius: 8px; height: 48px; position: relative;" >
            <NFlex size="small" align="center" justify="start" :wrap="false" inline style="position: absolute; left: 11px;">
                <div style="height: 32px; width: 32px; border-radius: 8px; border: var(--n-border-hover); border-style: dashed; background-size: 32px; background-clip: content-box; background-image: url('https://avatars.githubusercontent.com/u/42877650?v=4')" />
                <transition>
                    <NSpace v-if="!collapseMenu" vertical align="start" :size="2" inline>
                        <span style="font-weight: 500;">
                            Брусницын Андрей
                        </span>
                        <NText>
                            Разработчик
                        </NText>
                    </NSpace>
                </transition>
            </NFlex>
        </NButton>
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
