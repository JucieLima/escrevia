import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    // Se você tiver problemas com certificados SSL (como o cacert.pem),
    // você pode precisar de uma configuração de servidor HTTPS aqui,
    // mas vamos focar na funcionalidade básica primeiro.
    // server: {
    //     https: {
    //         key: './.certs/your-key.pem', // Seu caminho para a chave SSL
    //         cert: './.certs/your-cert.pem', // Seu caminho para o certificado SSL
    //     },
    // },
});
