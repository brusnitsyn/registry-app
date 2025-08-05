<script setup>
import {useDebouncedRefHistory} from "@vueuse/core";
import {Search} from "@vicons/tabler";
import {NInput} from "naive-ui";

const model = defineModel('search')
const props = defineProps({
    debounce: {
        type: Number,
        default: 800
    },
    placeholder: String,
    loading: Boolean,
    size: {
        type: String,
        default: 'large'
    }
})
const emits = defineEmits(['searched'])

const searchValue = ref(model.value)
const searchInputRef = ref()
const { last } = useDebouncedRefHistory(searchValue, { debounce: props.debounce })

watch(() => last.value, (newSearch) => {
    model.value = newSearch.snapshot
    emits('searched', newSearch.snapshot)
})

onMounted(() => {
    searchInputRef.value.focus()
})
</script>

<template>
    <NInputGroup class="max-w-xl">
        <NInput ref="searchInputRef"
                v-model:value="searchValue"
                autofocus
                :size="size"
                :placeholder="placeholder"
                @keydown.enter.prevent="emits('searched', last.snapshot)"
                :loading="loading"
                clearable
        />
        <NButton secondary :loading="loading" :size="size" @click="emits('searched', last.snapshot)">
            <template #icon>
                <NIcon :component="Search" />
            </template>
        </NButton>
    </NInputGroup>
</template>

<style scoped>
:deep(.n-input-wrapper) {
    padding-right: 0 !important;
}
</style>
