import { defineStore } from 'pinia'

export const useRegistryStore = defineStore('registry', () => {
    const currentHeader = ref({})
    const currentZlList = ref({})

    async function fetchZlList(header_id:number|string) {
        const {data: zlList} = await useFetch('http://registry-server.test/api/registry/zl-list', {
            method: 'POST',
            body: {
                header_id
            }
        })
        currentZlList.value = zlList.value?.data
    }

    return {
        currentHeader,
        fetchZlList,
        currentZlList
    }
})
