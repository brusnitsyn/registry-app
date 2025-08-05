import {createFetch, useFetch} from "@vueuse/core"
import {usePage} from "@inertiajs/vue3"

const page = usePage()
const token = computed(() => page.props.auth?.token)
export const useAuthFetch = createFetch({
    baseUrl: '/api',
    combination: 'overwrite',
    options: {
        // beforeFetch in pre-configured instance will only run when the newly spawned instance do not pass beforeFetch
        async beforeFetch({ options }) {
            await useFetch('/api/csrf-cookie', {
                credentials: 'include'
            }).get().json()

            const token = getCookie('XSRF-TOKEN')

            options.headers.Accept = 'application/json'
            options.headers['X-Requested-With'] = 'XMLHttpRequest'
            options.headers['X-XSRF-TOKEN'] = token
            options.credentials = 'include'

            return { options }
        },
    },
})

const getCookie = (name) => {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
