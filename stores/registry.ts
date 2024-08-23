import { defineStore } from 'pinia'
import {encodeQueryValue, normalizeURL, stringifyQuery, withQuery} from "ufo";
type Pers = {
    fam?:string,
    im:string,
    ot?:string,
    w:number,
    dr:string,
    snils?:string,
    okatog?:string,
    okatop?:string,
}

type PacientRegistry = {
    id:number,
    id_pac:string,
    vpolis:number,
    spolis?:string,
    npolis?:string,
    enp?:string,
    st_okato?:string,
    smo?:string,
    smo_nam?:string,
    inv?:number,
    mse?:string,
    novor?:string,
    vnov_d?:string,
    pers:Pers
}

export const useRegistryStore = defineStore('registry', () => {
    const currentHeader = ref(null)
    const currentZlList = ref(null)
    const currentZaps = ref(null)
    const currentPacient = ref<PacientRegistry|null>()

    async function fetchZlList(header_id:number|string) {
        const response = await useAPI('/api/registry/zl-list', {
            method: 'POST',
            body: {
                header_id
            }
        })
        currentZlList.value = response?.data
    }

    async function fetchHeader(header_id:number|string) {
        const { data } = await useAPI('/api/registry/header', {
            method: 'POST',
            body: {
                header_id
            }
        })
        console.log(data)
        currentHeader.value = data?.value
    }

    async function fetchZaps(zl_list_id:number, page:number|null, search:object|null) {
        const query = {page, ...search}

        const response = await useAPI('/api/registry/zaps', {
            method: 'POST',
            body: {
                zl_list_id
            },
            query
        })

        currentZaps.value = response.data
    }

    async function fetchPacient(zap_id:number) {
        if (zap_id === null) return
        const response = await useAPI('/api/registry/pacient', {
            method: 'POST',
            body: {
                zap_id
            }
        })

        currentPacient.value = response?.data.data
    }

    return {
        fetchHeader,
        currentHeader,
        fetchZlList,
        currentZlList,
        fetchZaps,
        currentZaps,
        fetchPacient,
        currentPacient
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRegistryStore, import.meta.hot))
}
