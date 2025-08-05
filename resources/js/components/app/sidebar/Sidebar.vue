<script setup>
import {breakpointsTailwind, useBreakpoints, useLocalStorage} from "@vueuse/core";
import {Link, usePage} from "@inertiajs/vue3";
import SidebarHeader from "./SidebarHeader.vue";
import SidebarFooter from "./SidebarFooter.vue";
import SidebarFileSelector from "./SidebarFileSelector.vue";
import {useRouterQuery} from "../../../../composables/useRouterQuery.js";
import {NIcon} from "naive-ui";
import * as TablerIcons from '@vicons/tabler'

const collapseMenu = useLocalStorage('collapse-menu', false)
const theme = useLocalStorage('theme', 'dark')
const breakpoints = useBreakpoints(breakpointsTailwind)
const smaller = breakpoints.smallerOrEqual('sm')
const registryFileId = ref(null)
const {query, value: registryFile} = useRouterQuery('registry', null)
const viewType = useLocalStorage('view', 'registry')

const iconComponents = {
    Books: TablerIcons.Books,
    Servicemark: TablerIcons.Servicemark,
}

const loadTablerIcon = (iconName) => {
    return iconComponents[iconName] || TablerIcons.CircleDotted
}

const _activeMenuItem = ref(null)
const collapseDrawer = computed({
    get: () => {
        return !collapseMenu.value
    },
    set: (value) => {
        collapseMenu.value = !value
    }
})
const registryMenuOptions = computed(() => (usePage().props.menu.map(item => {
    if (item.href !== null) {
        const menuItem = {
            ...item,
            key: item.href,
            label: () => h(
                Link,
                {
                    href: route(item.href, {
                        registry: query.value.registry ?? null,
                        zglv: query.value.zglv ?? null
                    })
                },
                item.label
            ),
        }

        if (item.icon) {
            menuItem.icon = () => h(NIcon, null, {
                default: () => h(loadTablerIcon(item.icon))
            })
        }

        return menuItem
    } else {
        return item
    }
})))
const misMenuOptions = usePage().props.menu.map(item => {
    if (item.href !== null) {
        return {
            ...item,
            label: () => h(
                Link,
                {
                    href: route(item.href, {...query.value})
                },
                item.label
            )
        }
    } else {
        return item
    }
})

const getCurrentMenu = computed(() => {
    if(viewType.value === 'registry')
        return registryMenuOptions.value
    else
        return misMenuOptions
})

const activeMenuItem = computed({
    get: () => {
        if (_activeMenuItem.value !== null) {
            return _activeMenuItem.value
        }

        const currentRoute = route().current()
        if (!currentRoute) return null

        // Находим первый пункт меню, чей key является префиксом текущего маршрута
        const menuItem = getCurrentMenu.value.find(item =>
            item.key && currentRoute.startsWith(item.key))

        return menuItem?.key || currentRoute
    },
    set: (route) => {
        _activeMenuItem.value = route
    }
})

const updateRegistryFileId = (registryId) => {
    registryFileId.value = registryId
}

</script>

<template>
    <NDrawer v-if="smaller" v-model:show="collapseDrawer" placement="left" style="--n-body-padding: 8px 8px;" :style="theme === 'dark' ? 'background-color: rgb(24, 24, 28);' : 'background-color: rgb(250, 250, 250);'">
        <NDrawerContent>
            <NFlex justify="space-between" vertical :wrap="false" style="height: calc(100svh - 32px);">
                <NFlex :wrap="false" vertical>
                    <SidebarHeader />
                    <SidebarFileSelector />
                    <NMenu
                        v-model:value="activeMenuItem"
                        :collapsed="collapseMenu"
                        :collapsed-width="64"
                        :collapsed-icon-size="22"
                        :options="getCurrentMenu"
                    />
                </NFlex>
                <SidebarFooter />
            </NFlex>
        </NDrawerContent>
    </NDrawer>
    <NLayoutSider v-else style="padding-left: 8px; padding-bottom: 16px; padding-top: 16px; overflow-x: hidden;"
                  :style="theme === 'dark' ? 'background-color: rgb(24, 24, 28);' : 'background-color: rgb(250, 250, 250);'"
                  collapse-mode="width"
                  :collapsed-width="64"
                  :native-scrollbar="false"
                  :width="248"
                  :collapsed="collapseMenu">
        <NFlex justify="space-between" vertical :wrap="false" style="height: calc(100svh - 32px);">
            <NFlex :wrap="false" vertical>
                <SidebarHeader @update-registry="registryId => updateRegistryFileId(registryId)" />
                <SidebarFileSelector v-if="registryFile !== null && viewType === 'registry'" :registry-file-id="registryFileId" />
                <NMenu
                    v-model:value="activeMenuItem"
                    :collapsed="collapseMenu"
                    :collapsed-width="64"
                    :collapsed-icon-size="22"
                    :options="getCurrentMenu"
                />
            </NFlex>
            <SidebarFooter />
        </NFlex>
    </NLayoutSider>
</template>

<style scoped>
:deep(.n-menu.n-menu--collapsed .n-menu-item-content__icon) {
    margin-left: 2px;
}
:deep(.n-menu-item-content) {
    padding-left: 14px !important;
}
:deep(.n-menu-item-content::before) {
    left: 4px;
    right: 4px;
    border-radius: 8px;
}
</style>
