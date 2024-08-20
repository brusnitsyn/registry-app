// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-04-03',
  devtools: { enabled: true },
  modules: ["@nuxtjs/tailwindcss", "@pinia/nuxt", "shadcn-nuxt", "@bg-dev/nuxt-naiveui"],
  pinia: {
    storesDirs: ['./stores/**'],
  },
  shadcn: {
    prefix: '',
    componentDir: './components/ui'
  },
  runtimeConfig: {
    public: {
      apiUrl: ''
    }
  }
})