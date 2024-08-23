<script setup lang="ts">
const data = await useRegistryStore().fetchZaps(2)
</script>

<template>
  <pre>
    {{ useRegistryStore().currentZaps }}
  </pre>
</template>

<style scoped>

</style>