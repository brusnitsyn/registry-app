import { defineStore } from 'pinia'
import {useAPI} from "~/composables/useAPI";

export const useZapRegistryStore = defineStore('zapRegistry', () => {
    const zaps = ref([])
    const zap = ref({})

    async function getZapsForQuery(query: object) {
        const {data, status} = await useAPI(`/api/v1/registry/zap`, {
            query
        })
        if (status.value === 'success') {
            zaps.value = data.value
        }
    }

    async function getZap(zapId: number, query: object) {
        const {data, status} = await useAPI(`/api/v1/registry/zap/${zapId}`, {
            query
        })
        if (status.value === 'success') {
            zap.value = data.value
        }
    }

    async function updateZap(zapData: object) {
        const { data, status } = await useAPI(`/api/v1/registry/zap`, {
            method: "PUT",
            body: zapData
        })

        if (status.value === 'success') {
            zap.value = {
                ...zap.value,
                ...data.value
            }
        }
    }

    async function updatePacient(pacientData: object) {
        const { data, status } = await useAPI(`/api/v1/registry/pacient`, {
            method: "PUT",
            body: pacientData
        })

        if (status.value === 'success') {
            zap.value = {
                ...zap.value,
                pacient: data.value
            }
        }
    }

    async function updateZSl(zslData: object) {
        const { data, status } = await useAPI(`/api/v1/registry/zsl`, {
            method: "PUT",
            body: zslData
        })

        if (status.value === 'success') {
            zap.value = {
                ...zap.value,
                z_sl: {
                    ...zap.value.z_sl,
                    ...data.value
                }
            }
        }
    }

    async function updateSl(slData: object) {
        const { data, status } = await useAPI(`/api/v1/registry/sl`, {
            method: "PUT",
            body: slData
        })

        if (status.value === 'success') {

        }
    }

    async function updateCons(consData: object) {
        const { data, status } = await useAPI(`/api/v1/registry/cons`, {
            method: "PUT",
            body: consData
        })

        if (status.value === 'success') {

        }
    }

    return {
        zaps,
        zap,
        getZapsForQuery,
        getZap,
        updateZap,
        updatePacient,
        updateZSl,
        updateSl
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRegistryStore, import.meta.hot))
}
