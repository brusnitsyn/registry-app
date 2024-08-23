export default defineNuxtPlugin((nuxtApp) => {
    const config = useRuntimeConfig()
    const cookieToken = ''
    const api = $fetch.create({
        baseURL: config.public.apiUrl ?? 'http://127.0.0.1:8000/api',
        onRequest({ request, options, error }) {
            if (cookieToken) {
                const headers = options.headers ||= {}
                if (Array.isArray(headers)) {
                    headers.push(['Authorization', `Bearer ${cookieToken}`])
                } else if (headers instanceof Headers) {
                    headers.set('Authorization', `Bearer ${cookieToken}`)
                } else {
                    headers.Authorization = `Bearer ${cookieToken}`
                }
            }
        },
        async onResponseError({ response }) {
            // if (response.status === 401) {
            //     await nuxtApp.runWithContext(() => navigateTo('/login'))
            // }
        }
    })

    // Expose to useNuxtApp().$api
    return {
        provide: {
            api
        }
    }
})
