import './../css/app.css';

import { HeroUIProvider, ToastProvider } from '@heroui/react';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { StrictMode } from 'react';
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
            <StrictMode>
                <HeroUIProvider>
                    <ToastProvider />
                    <div className="absolute left-1/2 top-1/2 h-full max-h-[1000px] w-full max-w-[500px] -translate-x-1/2 -translate-y-1/2 overflow-y-auto overflow-x-hidden">
                        <App {...props} />
                    </div>
                </HeroUIProvider>
            </StrictMode>,
        );
    },
    progress: {
        color: '#4B5563',
    },
});
