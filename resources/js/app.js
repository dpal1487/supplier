import('./bootstrap');
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

// Import modules...
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import CKEditor from '@ckeditor/ckeditor5-vue';
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'


const vuetify = createVuetify({
    components,
    directives,
})

import Vue3Toastify from 'vue3-toastify';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    // host: "http://localhost:6001",
    host: window.location.hostname + ':6001',
});

import "vue3-toastify/dist/index.css";
import VueClipboard from 'vue3-clipboard';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    //
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(VueClipboard, {
                autoSetContainer: true,
                appendToBody: true,
            })
            .use(CKEditor)
            .use(vuetify)
            .use(plugin).use(Vue3Toastify, { autoClose: 3000, theme: "colored" })
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#ad3861' });
