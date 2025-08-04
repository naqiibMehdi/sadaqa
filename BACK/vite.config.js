import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    host: process.env.FRONTEND_URL || 'localhost',
    hmr: {
      host: process.env.FRONTEND_URL || 'localhost',
    },
  },
});
