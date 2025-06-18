<script setup>
import {breakpointsTailwind, useBreakpoints, useFetch, useLocalStorage} from "@vueuse/core";
import {NFlex, NIcon} from "naive-ui";
import {Selector, SquarePlus} from "@vicons/tabler";
import {Link, router, usePrefetch} from "@inertiajs/vue3";
import Modal from "../modal/Modal.vue";

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
const options = [
    {
        type: 'group',
        label: 'Доступные реестры', //: 'Нет доступных реестров',
        key: 'registry',
        children: [
            {
                label: '2025.02',
                key: '2025.02',
                icon: () => renderIcon(SquarePlus),
                selected: true,
            }
        ],
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
const selectedOption = ref(options[0].children[0])
const breakpoints = useBreakpoints(breakpointsTailwind)
const smaller = breakpoints.smallerOrEqual('sm')
const hasOpenUploaderModal = ref(false)
const selectOption = (option) => {
    if (option.selected === true)
        selectedOption.value = option
    else
        option.onClick()
}

onMounted(async () => {
    const {data, isFetching} = await useFetch(route('api.registry.files')).json()
    isComponentFetching.value = isFetching.value
    menuFile.value = data.value
})
</script>

<template>
    <NButton quaternary style="--n-border-radius: 8px; height: 48px; position: relative;">
        <Link href="/" style="position: absolute; left: 11px; top: 8px;">
            <NFlex size="small" align="center" justify="start" :wrap="false" inline>
                <NFlex align="center" justify="center" style="height: 32px; width: 32px; border-radius: 8px; border: var(--n-border-hover); border-style: dashed; background-color: var(--n-item-color-active)">
                    <img src="/img/logo.svg"  alt="" width="24" />
                </NFlex>
                <transition>
                    <div v-if="!collapseMenu">
                        <NSpace vertical align="start" :size="2" inline>
                            <span style="font-weight: 500;">
                                Реестр
                            </span>
                            <NSkeleton v-if="isComponentFetching" style="width: 54px; height: 15px;" animated round />
                            <NText v-else>
                                {{ selectedOption.label }}
                            </NText>
                        </NSpace>
                    </div>
                </transition>
            </NFlex>
        </Link>
        <transition>
            <NDropdown v-if="!collapseMenu" :options="options" :placement="smaller ? 'bottom-end' : 'right-start'" trigger="click" style="border-radius: 4px; width: 240px;" @select="(key, option) => selectOption(option)">
                <NButton quaternary style="--n-border-radius: 8px; --n-padding: 0 8px; position: absolute; right: 8px; z-index: 99990;">
                    <NIcon :component="Selector" size="18" />
                </NButton>
            </NDropdown>
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
