import './bootstrap'
import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy-js';
import AppLayout from "./layouts/AppLayout.vue";
import {useLocalStorage} from "@vueuse/core";
import MisLayout from "./layouts/MisLayout.vue";
import AuthLayout from "./layouts/AuthLayout.vue";

createInertiaApp({
    title: title => `${title}`,
    resolve: name => {
        const pages = import.meta.glob('./pages/**/*.vue', {eager: true})
        let page = pages[`./pages/${name}.vue`]
        const viewType = useLocalStorage('view', 'registry')

        // if (page.default.__name === 'Login') {
        //     page.default.layout = AuthLayout
        // } else {
        //     if (viewType.value === 'registry') {
        //         page.default.layout = AppLayout
        //     } else {
        //         page.default.layout = MisLayout
        //     }
        // }
        //
        // console.log(page.default)
        //
        // page.default.layout.props.title = '123123123'

        return page
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .mount(el)
    },
})
