<script setup>
import {breakpointsTailwind, useBreakpoints, useFetch, useLocalStorage} from "@vueuse/core";
import {NEl, NFlex, NIcon} from "naive-ui";
import {Frame, Replace, Selector, SquarePlus} from "@vicons/tabler";
import {Link, router, usePage, usePrefetch} from "@inertiajs/vue3";
import Modal from "../modal/UploadRegistryModal.vue";
import {useAuthFetch} from "../../../../composables/useAuthFetch.js";
import {useRouterQuery} from "../../../../composables/useRouterQuery.js";

const collapseMenu = useLocalStorage('collapse-menu', false)
const menuFile = ref([])
const isComponentFetching = ref(true)
const renderIcon = (icon) => {
    return h(
        NFlex,
        {
            align: 'center',
            justify: 'center',
            style: 'background-color: rgb(--tab-color); border-radius: 4px; padding: 2px; align: center; margin-left: 2px;'
        },
        h(NIcon, { size: 18 }, {
            default: () => h(icon)
        })
    )
}
const options = computed(() => {
    return [
        {
            type: 'group',
            label: 'Доступные реестры',
            key: 'registry',
            show: menuFile.value.length > 0,
            children: [...menuFile.value].map(item => ({
                ...item,
                selected: true
            })),
        },
        {
            type: 'render',
            key: 'no-available',
            show: menuFile.value.length === 0,
            render: () => h(
                NEl,
                {
                    style: 'padding: 4px 12px; color: var(--text-color-1)'
                },
                'Нет доступных реестров'
            )
        },
        {
            type: 'divider',
            key: 'd1'
        },
        {
            label: 'Загрузить реестр',
            key: 'upload-registry',
            icon: () => renderIcon(SquarePlus),
            onClick: () => {
                hasOpenUploaderModal.value = true
            }
        }
    ]
})
const selectedOption = ref(null)
const breakpoints = useBreakpoints(breakpointsTailwind)
const smaller = breakpoints.smallerOrEqual('sm')
const hasOpenUploaderModal = ref(false)
const {value: registryFile, setQuery: setRegistryFile} = useRouterQuery('registry', null)
const {query} = useRouterQuery()
const viewType = useLocalStorage('view', 'registry')

const emits = defineEmits(['updateRegistry'])

const selectOption = async (option) => {
    if (option.selected === true) {
        isComponentFetching.value = true
        selectedOption.value = option
        router.get(
            route(route().current()),
            {
                ...query.value,
                zglv: undefined, // удаляем параметр
                registry: option.key // устанавливаем новый
            },
            {
                preserveState: true,
                replace: true
            }
        )
        emits('updateRegistry', option.key)
        isComponentFetching.value = false
    }
    else
        option.onClick()
}

const changeView = async () => {
    if (viewType.value === 'registry') {
        viewType.value = 'mis'
        await useAuthFetch(route('web.session.update-view-type')).post({ view_type: viewType.value })
        router.reload({
            preserveState: true
        })
    }
    else {
        viewType.value = 'registry'
        await useAuthFetch(route('web.session.update-view-type')).post({ view_type: viewType.value })
        router.reload({
            preserveState: true
        })
    }
}

onMounted(async () => {
    const {data, isFetching, error} = await useFetch(route('api.registry.files')).json()

    isComponentFetching.value = isFetching.value
    if (error) {
        // console.log(error)
    }
    if (data.value.length > 0) {
        menuFile.value = data.value
        if (registryFile.value !== null) {
            selectedOption.value = menuFile.value.find(itm => itm.key === Number(registryFile.value))
        } else {
            selectedOption.value = menuFile.value[menuFile.value.length - 1]
            await setRegistryFile(selectedOption.value.key)
        }
    }
})
</script>

<template>
    <NButton quaternary style="--n-border-radius: 8px; height: 48px; position: relative;">
        <Link href="/" style="position: absolute; left: 11px; top: 8px;">
            <NFlex size="small" align="center" justify="start" :wrap="false" inline>
                <NFlex align="center" justify="center" style="height: 32px; width: 32px; border-radius: 8px; border: var(--n-border-hover); border-style: dashed; background-color: var(--n-item-color-active)">
                    <NIcon :component="Frame" size="20" />
<!--                    <img src="/img/logo.svg"  alt="" width="24" />-->
                </NFlex>
                <transition>
                    <div v-if="!collapseMenu">
                        <NSpace vertical align="start" :size="2" inline>
                            <span style="font-weight: 500;" v-text="viewType === 'mis' ? 'ВЕБ-МИС' : 'Реестр'" />
                            <NSkeleton v-if="isComponentFetching" style="width: 54px; height: 15px;" animated round />
                            <NText v-else-if="viewType === 'registry'">
                                {{ selectedOption?.label }}
                            </NText>
                        </NSpace>
                    </div>
                </transition>
            </NFlex>
        </Link>
        <transition>
            <NFlex v-if="!collapseMenu" align="center">
<!--                <NTooltip>-->
<!--                    <template #trigger>-->
<!--                        <NButton @click="changeView" quaternary style="&#45;&#45;n-border-radius: 8px; &#45;&#45;n-padding: 0 8px; position: absolute; z-index: 99990;" :style="viewType === 'registry' ? 'right: 48px;' : 'right: 8px;'">-->
<!--                            <NIcon :component="Replace" size="18" />-->
<!--                        </NButton>-->
<!--                    </template>-->
<!--                    Перейти к представлению {{ viewType === 'mis' ? 'реестра' : 'ВЕБ-МИС' }}-->
<!--                </NTooltip>-->
                <NDropdown v-if="viewType === 'registry'" :options="options" :placement="smaller ? 'bottom-end' : 'right-start'" trigger="click" style="border-radius: 4px; width: 240px;" @select="(key, option) => selectOption(option)">
                    <NButton quaternary style="--n-border-radius: 8px; --n-padding: 0 8px; position: absolute; right: 8px; z-index: 99990;">
                        <NIcon :component="Selector" size="18" />
                    </NButton>
                </NDropdown>
            </NFlex>
        </transition>
    </NButton>
    <Modal v-model:show="hasOpenUploaderModal" />
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
