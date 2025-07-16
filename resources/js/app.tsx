import './../css/app.css';

import { HeroUIProvider, ToastProvider } from '@heroui/react';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

// @ts-expect-error meta value
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        // @ts-expect-error meta value
        return resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx'));
    },
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <HeroUIProvider>
                <ToastProvider />
                <App {...props} />
            </HeroUIProvider>,
        );
    },
    progress: {
        color: '#4B5563',
    },
});
