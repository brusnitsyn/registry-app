<script setup lang="ts">
import { ruRU, dateRuRU } from 'naive-ui'
</script>

<template>
  <NConfigProvider :locale="ruRU" :date-locale="dateRuRU">
    <NMessageProvider>
      <NDialogProvider>
        <NuxtLayout>
          <NuxtPage />
        </NuxtLayout>
      </NDialogProvider>
    </NMessageProvider>

  </NConfigProvider>
</template>