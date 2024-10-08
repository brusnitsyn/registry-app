<script setup lang="ts">
import {
  IconChevronLeft
} from '@tabler/icons-vue'
import { NuxtLink } from "#components";
import { NIcon } from "naive-ui";

function renderIcon(icon: Component) {
  return () => h(NIcon, null, { default: () => h(icon) })
}

const menuOptions = [
  {
    label: 'Назад',
    icon: renderIcon(IconChevronLeft),
    onClick: () => {
      useRouter().back()
    }
  },
  {
    type: 'divider'
  },
  {
    label: () =>
        h(
            NuxtLink,
            {
              to: { name: 'ws', query: { registryId: useRoute().query.registryId } }
            },
            'Реестр'
        ),
    key: 'registry'
  },
  {
    label: () =>
        h(
            NuxtLink,
            {
              to: { name: 'ws-report', query: { registryId: useRoute().query.registryId } }
            },
            'Отчеты'
        ),
    key: 'report'
  }
]
</script>

<template>
  <NLayout has-sider position="absolute">
    <NLayoutSider bordered>
      <NMenu :options="menuOptions"  />
    </NLayoutSider>
    <NLayout>
      <slot />
    </NLayout>
  </NLayout>
</template>

<style scoped>

</style>