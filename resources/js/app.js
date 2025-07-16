import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
// Esta importação agora funcionará se o plugin estiver correto e atualizado
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import MainLayout from './Layouts/MainLayout.vue';
import { ZiggyVue } from 'ziggy-js';

createInertiaApp({
    title: (title) => {
        const appName = window.Inertia && window.Inertia.page && window.Inertia.page.props.appName
            ? window.Inertia.page.props.appName
            : 'Escrevia';
        return `${title} - ${appName}`;
    },
    // Use resolvePageComponent diretamente para o Inertia
    resolve: (name) => {
        const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));
        // Inertia automaticamente aplica o layout se a página não tiver um
        // Mas podemos garantir que MainLayout é o padrão
        page.then((module) => {
            if (module.default.layout === undefined) {
                module.default.layout = MainLayout;
            }
        });
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, props.ziggy)
            .component('Link', Link)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
