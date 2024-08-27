<script setup lang="ts">
const { data: registryHeaders } = await useAPI('/api/registry/headers')
</script>


<template>
  <NLayout class="h-screen">
    <NLayoutHeader bordered>
      поиск и пр
    </NLayoutHeader>
    <NLayout position="absolute" style="top: 20px; bottom: 20px" has-sider>
      <NLayoutSider
          bordered
      >
        <CoreRecentRegistryMenu :items="registryHeaders" />
      </NLayoutSider>
      <NLayout content-style="padding: 0 24px;" :native-scrollbar="false">
        <slot />
      </NLayout>
    </NLayout>
    <NLayoutFooter
        position="absolute"
        bordered
    >
      footer
    </NLayoutFooter>
  </NLayout>
</template>

<!--<template>-->
<!--  <div class="relative h-full">-->
<!--    <NLayout position="absolute">-->
<!--      <NLayoutHeader bordered class="h-10">поиск и пр</NLayoutHeader>-->
<!--      <NLayout has-sider position="absolute">-->
<!--        <NLayoutSider bordered>-->
<!--          <CoreRecentRegistryMenu :items="registryHeaders" class="" />-->
<!--        </NLayoutSider>-->
<!--        <NLayout>-->
<!--          <slot />-->
<!--        </NLayout>-->
<!--      </NLayout>-->
<!--      &lt;!&ndash;    <n-layout-footer>Chengfu Road</n-layout-footer>&ndash;&gt;-->
<!--    </NLayout>-->
<!--  </div>-->
<!--&lt;!&ndash;  <div class="relative grid grid-cols-[280px_1fr] grid-rows-[auto_1fr] min-h-screen max-h-screen">&ndash;&gt;-->
<!--&lt;!&ndash;    <div class="border-b sticky top-0 inset-x-0 bg-white z-50 col-span-2">&ndash;&gt;-->
<!--&lt;!&ndash;      поиск и пр&ndash;&gt;-->
<!--&lt;!&ndash;    </div>&ndash;&gt;-->

<!--&lt;!&ndash;    <aside class="max-h-screen sticky top-0">&ndash;&gt;-->
<!--&lt;!&ndash;      <div class="h-full">&ndash;&gt;-->
<!--&lt;!&ndash;        <div class="relative h-full">&ndash;&gt;-->
<!--&lt;!&ndash;          <div class="absolute inset-0 border-r flex">&ndash;&gt;-->
<!--&lt;!&ndash;            <CoreRecentRegistryMenu :items="registryHeaders" class="" />&ndash;&gt;-->
<!--&lt;!&ndash;          </div>&ndash;&gt;-->
<!--&lt;!&ndash;        </div>&ndash;&gt;-->
<!--&lt;!&ndash;      </div>&ndash;&gt;-->
<!--&lt;!&ndash;    </aside>&ndash;&gt;-->

<!--&lt;!&ndash;    <div class="max-h-[calc(100vh-20px)] row-span-2">&ndash;&gt;-->
<!--&lt;!&ndash;      <slot />&ndash;&gt;-->
<!--&lt;!&ndash;    </div>&ndash;&gt;-->
<!--&lt;!&ndash;  </div>&ndash;&gt;-->
<!--</template>-->

<style scoped>

</style>
