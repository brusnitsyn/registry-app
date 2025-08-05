<script setup>
import {useAuthFetch} from "../../../../composables/useAuthFetch.js";
import {registryComment, registryType} from "../../../constants.js";
import {useLocalStorage} from "@vueuse/core";
import {useRouterQuery} from "../../../../composables/useRouterQuery.js";
import {decode} from "ufo";
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    registryFileId: {
        type: Number
    }
})
const collapseMenu = useLocalStorage('collapse-menu', false)
const menuFiles = ref([])
const selectedItem = ref(null)
const isComponentFetching = ref(true)
const {value: registryFile} = useRouterQuery('registry', null)
const {value: zglv, setQuery: setZglv} = useRouterQuery('zglv', null)

onMounted(async () => {
    await prefetch()
})

const prefetch = async () => {
    isComponentFetching.value = true
    // const {data, isFetching, error} = await useAuthFetch(route('registry.files', { registry: registryFile.value })).json()
    //
    // console.log(data.value)
    //
    // if (error) {
    //     console.log(error)
    // }
    const data = usePage().props.accessRegistryFiles
    if (data.length > 0) {
        menuFiles.value = data
        if (zglv.value !== null) {
            selectedItem.value = menuFiles.value.find(itm => itm.id === zglv.value)
            if (typeof selectedItem.value !== 'undefined')
                selectedItem.value.active = true
        } else {
            menuFiles.value[0].active = true
            selectedItem.value = menuFiles.value[0]
            await setZglv(selectedItem.value.id)
        }
    }

    isComponentFetching.value = false
}

const selectListItem = (menuFile) => {
    if (selectedItem.value !== null && typeof selectedItem.value !== 'undefined')
        selectedItem.value['active'] = false
    menuFile.active = true
    selectedItem.value = menuFile

    setZglv(menuFile.id)
}

const selectedRegistry = ref()
const registryComputed = computed({
    get: () => {
        if (zglv.value !== null) {
            return zglv.value.split(',').map(item => (Number(item)))
        }
        return selectedRegistry.value
    },
    set: (value) => {
        selectedRegistry.value = value
        setZglv(decode(value))
    }
})

watch(registryFile, async () => {
    await prefetch()
})
</script>

<template>
    <NFlex v-if="isComponentFetching" vertical>
        <NSkeleton height="22px" width="88px" style="margin-left: 8px; border-radius: 8px" animated />
        <NSkeleton height="132px" width="226px" style="margin-left: 8px; border-radius: 8px" animated />
    </NFlex>
    <transition v-else>
        <NFlex v-if="!collapseMenu" vertical :wrap="false">
            <NText style="margin-left: 8px; text-wrap: nowrap">
                Тип реестра
            </NText>
            <NEl class="list_container">
                <NScrollbar>
                    <NCheckboxGroup v-model:value="registryComputed">
                        <NCheckbox v-for="menuFile in menuFiles" :value="menuFile.id">
                            <NTooltip>
                                <template #trigger>
                                    {{ registryType[menuFile.type] }}
                                </template>
                                {{ registryComment[`COMMENT_${menuFile.type}`] }}
                            </NTooltip>
                        </NCheckbox>
                    </NCheckboxGroup>
<!--                    <NList hoverable clickable :show-divider="false">-->
<!--                        <NListItem v-for="menuFile in menuFiles" style="border-radius: 6px;" :style="menuFile.active ? 'background-color: var(&#45;&#45;close-color-hover)' : ''" @click="selectListItem(menuFile)">-->
<!--                            {{ registryType[menuFile.type] }}-->
<!--                        </NListItem>-->
<!--                    </NList>-->
                </NScrollbar>
            </NEl>
        </NFlex>
    </transition>
</template>

<style scoped>
:deep(.n-checkbox-box-wrapper) {
    display: none;
}
:deep(.n-checkbox) {
    transition: background-color 150ms;
    padding: 6px 4px;
    border-radius: 6px;
    width: 100%;
}
:deep(.n-checkbox__label) {
    text-wrap: nowrap;
}
:deep(.n-checkbox-group) {
    display: flex;
    flex-direction: column;
    row-gap: 2px;
}
:deep(.n-checkbox--checked) {
    background-color: var(--close-color-hover);
}
:deep(.n-list-item) {
    padding: 0 16px !important;
    height: 42px;
}
.list_container {
    margin: 0 4px;
    border-radius: 8px;
    border: 1px solid var(--n-border-color);
    padding: 2px;
    overflow: hidden;
}

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
