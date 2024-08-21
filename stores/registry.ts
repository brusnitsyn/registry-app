import { defineStore } from 'pinia'

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

    async function fetchHeader(header_id:number|string) {
        const response = await client('/api/registry/header', {
            method: 'POST',
            body: {
                header_id
            }
        })
        currentHeader.value = response?.data
    }

    async function fetchZaps(zl_list_id:number, page:number|null) {
        const response = await client('/api/registry/zaps', {
            method: 'POST',
            body: {
                zl_list_id
            },
            query: {
                page,
            }
        })

        currentZaps.value = response
    }

    return {
        fetchHeader,
        currentHeader,
        fetchZlList,
        currentZlList,
        fetchZaps,
        currentZaps,
    }
})
