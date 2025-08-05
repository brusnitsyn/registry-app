import {router, usePage} from "@inertiajs/vue3"
import { computed } from "vue"
import {decode, encode, getQuery, parseQuery, stringifyQuery} from "ufo";

export const useRouterQuery = (key = null, defaultValue = null) => {
    const query = computed({
        get: () => {
            return getQuery(usePage().url);
        }
    })

    const value = ref(query.value[key] ?? defaultValue)

    watch(
        () => query.value[key],
        (newVal) => {
            value.value = newVal ?? defaultValue
        },
        { immediate: true }
    )

    // Функция для обновления query-параметра
    const setQuery = async (newValue) => {
        const str = { ...query.value, [key]: newValue }
        console.log(str)
        await router.get(
            route(route().current()), // Текущий URL
            { ...query.value, [key]: newValue }, // Новые параметры
            {
                preserveState: true,
                replace: true,
            }
        )
    }

    const removeQuery = async () => {
        if (!(key in query.value)) return
        const newQuery = { ...query.value }
        delete newQuery[key]
        await router.get(
            route(route().current()),
            newQuery,
            { preserveState: true, replace: true }
        )
    }

    return {
        query,
        value,
        setQuery,
        removeQuery
    }
}
