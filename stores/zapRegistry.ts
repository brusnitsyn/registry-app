import { defineStore } from 'pinia'
import {useAPI} from "~/composables/useAPI";

export const useZapRegistryStore = defineStore('zapRegistry', () => {
    const zaps = ref([])
    const zap = ref({})

    async function getZapsForZlListId(zlListId: number) {
        const {data, status} = await useAPI(`/api/v1/registry/zap?zlListId=${zlListId}`)
        if (status.value === 'success') {
            zaps.value = data.value
        }
    }

    async function getZap(zapId: number) {
        const {data, status} = await useAPI(`/api/v1/registry/zap/${zapId}`)
        if (status.value === 'success') {
            zap.value = data.value
        }
    }

    return {
        zaps,
        zap,
        getZapsForZlListId,
        getZap
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRegistryStore, import.meta.hot))
}
