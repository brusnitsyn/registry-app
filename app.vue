<script setup lang="ts">
import { ruRU, dateRuRU } from 'naive-ui'
</script>

<template>
  <NConfigProvider :locale="ruRU" :date-locale="dateRuRU">
    <NaiveConfig>
      <NuxtLayout>
        <NuxtPage />
      </NuxtLayout>
    </NaiveConfig>
  </NConfigProvider>
</template>