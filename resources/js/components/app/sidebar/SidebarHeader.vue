<script setup>
import {useLocalStorage} from "@vueuse/core";

const collapseMenu = useLocalStorage('collapse-menu', false)
</script>

<template>
    <NButton quaternary style="--n-border-radius: 8px; height: 48px;" :style="collapseMenu ? 'padding-left: 11px;' : '--n-padding: 0; display: block; margin-left: 4px; margin-right: 4px; padding-left: 8px;'">
        <NFlex size="small" align="center" justify="start" :wrap="false" inline>
            <NFlex align="center" justify="center" style="height: 32px; width: 32px; border-radius: 8px; background-color: #1d4ed8">
                <img src="/img/logo.svg"  alt="" width="24" />
            </NFlex>
            <transition>
                <NSpace v-if="!collapseMenu" vertical align="start" :size="2" >
                    <span style="font-weight: 700;">
                        ГАУЗ АО АОКБ
                    </span>
                    <NText>
                        Регистры
                    </NText>
                </NSpace>
            </transition>
        </NFlex>
    </NButton>
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
