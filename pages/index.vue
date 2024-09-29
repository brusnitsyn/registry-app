<script setup lang="ts">
import {useHeaderRegistryStore} from "~/stores/headerRegistry";

await useHeaderRegistryStore().getAllRegistryHeader()


</script>

<template>
  <pre>
    {{ useHeaderRegistryStore().registryHeaders }}
  </pre>
</template>

<style scoped>

</style>