import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mixin({
                methods:{
                    can: function(permission){
                        return this.$page.props.auth
                            ? this.$page.props.auth.permissions.includes(permission)
                            : false;
                    },
                    canAny: function(canAny){
                        if(this.$page.props.auth){
                            const permissions = this.$page.props.auth.permissions
                             return canAny.filter(permission => {
                                return permissions.includes(permission)
                            }).length
                        }
                        return false
                    }
                }
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
