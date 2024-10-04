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

    return {
        zaps,
        zap,
        getZapsForZlListId,
        getZap,
        updateZap,
        updatePacient,
        updateZSl
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useRegistryStore, import.meta.hot))
}
