import type {UseFetchOptions} from "#app";
import defu from "defu";

export function useSanctumFetch() {
    const config = useRuntimeConfig()

    async function client<T>(url:string, options:UseFetchOptions<T> = {}) {
        const cookieToken = ''
        const defaults: UseFetchOptions<T> = {
            baseURL: config.public.apiUrl ?? 'http://127.0.0.1:8000/api',
            // set user token if connected
            headers: cookieToken.value
                ? { Authorization: `Bearer ${cookieToken.value}`, Accept: 'application/json' }
                : { Accept: 'application/json' },

            onResponse(_ctx) {
                // _ctx.response._data = new myBusinessResponse(_ctx.response._data)
            },

            onResponseError(_ctx) {
                // throw new myBusinessError()
            }
        }

        const params = defu(defaults, options)

        return $fetch(url, params)
    }

    return {
        client
    }
}