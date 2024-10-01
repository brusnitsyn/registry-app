import { defineStore } from 'pinia'
import {useAPI} from "~/composables/useAPI";

export const useZlListRegistryStore = defineStore('zlListRegistry', () => {
    const zlLists = ref([])

    async function getAllZlListForHeaderId(registryId: number) {
        const {data, status} = await useAPI(`/api/v1/registry/zl-list?registryId=${registryId}`)
        if (status.value === 'success') {
            zlLists.value = data.value
        }
    }

    return {
        zlLists,
        getAllZlListForHeaderId,
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRegistryStore, import.meta.hot))
}
