import { defineStore } from 'pinia'
import {useSanctumFetch} from "#build/imports";

export const useRegistryStore = defineStore('registry', () => {
    const { client } = useSanctumFetch()

    const currentHeader = ref(null)
    const currentZlList = ref(null)
    const currentZaps = ref(null)

    async function fetchZlList(header_id:number|string) {
        const response = await client('/api/registry/zl-list', {
            method: 'POST',
            body: {
                header_id
            }
        })
        currentZlList.value = response?.data
    }

    async function fetchZaps(registry_id:number) {
        const response = await client('/api/registry/zaps', {
            method: 'POST',
            body: {
                registry_id
            }
        })

        currentZaps.value = response?.data
    }

    return {
        currentHeader,
        fetchZlList,
        currentZlList,
        fetchZaps,
        currentZaps,
    }
})
