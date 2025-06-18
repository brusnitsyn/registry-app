<script setup>
import {Sun, Moon} from "@vicons/tabler";
import {useLocalStorage} from "@vueuse/core";
const theme = useLocalStorage('theme', 'dark')
const changeTheme = () => {
    if (theme.value === 'dark') theme.value = 'light'
    else theme.value = 'dark'
}
</script>

<template>
    <NButton quaternary style="--n-border-radius: 8px; height: 38px; --n-padding: 0 12px;" @click="changeTheme">
        <NIcon :component="theme === 'dark' ? Moon : Sun" size="22" />
    </NButton>
</template>

<style scoped>

</style>
