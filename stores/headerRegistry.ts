import { defineStore } from 'pinia'
import {useAPI} from "~/composables/useAPI";

export const useHeaderRegistryStore = defineStore('headerRegistry', () => {
    const registryHeaders = ref([])

    async function getAllRegistryHeader() {
        const {data, status} = await useAPI('/api/v1/registry')
        if (status.value === 'success') {
            registryHeaders.value = data.value
        }
    }

    return {
        registryHeaders,
        getAllRegistryHeader,
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRegistryStore, import.meta.hot))
}
