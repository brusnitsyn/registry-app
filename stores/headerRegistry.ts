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

    async function deleteRegistryHeader(headerRegistryId: number) {
        const { status } = await useAPI(`/api/v1/registry/${headerRegistryId}`, {
            method: "DELETE",
        })

        if (status.value === 'success') {
            const deletedHeaderRegistry = registryHeaders.value.findIndex(item => item.id === headerRegistryId)
            registryHeaders.value.splice(deletedHeaderRegistry, 1)
            return true
        }

        return false
    }

    return {
        registryHeaders,
        getAllRegistryHeader,
        deleteRegistryHeader
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRegistryStore, import.meta.hot))
}
