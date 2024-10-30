import '../css/app.css';
import './bootstrap';
import { createI18n } from 'vue-i18n'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import en from './lang/en.json'
import tr from './lang/tr.json'
import ar from './lang/ar.json'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const storedLocale = localStorage.getItem('locale'); // Default to 'en' if not found

const appName =  'Thunder Catelog';
const i18n = createI18n({
    locale: 'en', // default language
    fallbackLocale: 'en', // fallback language
    messages: {
        en,
        ar,
        tr
    }
})
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
