import { defineStore } from 'pinia'
import {useAPI} from "~/composables/useAPI";

export const usePacientRegistryStore = defineStore('pacientRegistry', () => {
    const vpolisOptions = ref([
        {
            label: '1 - Полис старого образца',
            value: 1
        },
        {
            label: '2 - Временное свидетельство',
            value: 2
        },
        {
            label: '3 - Полис единого образца',
            value: 3
        },
        {
            label: '4 - Состояние на учёте без полиса',
            value: 4
        },
        {
            label: '5 - Состояние на учёте без временого свидетельства',
            value: 5
        },
    ])
    const invOptions = ref([
        {
            label: '0 - нет инвалидности',
            value: 0
        },
        {
            label: '1 - 1 группа',
            value: 1
        },
        {
            label: '2 - 2 группа',
            value: 2
        },
        {
            label: '3 - 3 группа',
            value: 3
        },
        {
            label: '4 - дети-инвалиды',
            value: 4
        },
    ])

    return {
        vpolisOptions,
        invOptions
    }
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(usePacientRegistryStore, import.meta.hot))
}
