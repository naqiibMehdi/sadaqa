import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import {URL, fileURLToPath} from "node:url"
import Icons from "unplugin-icons/vite"


// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue(), Icons()],
  build: {
    minify: true,
    rollupOptions: {
      output: {
        manualChunks: {
          'stripe': ["@stripe/stripe-js"]
        }
      }
    }
  },
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url))
    }
  },
  server: {
    proxy: {
      "/api": {
        target: "http://127.0.0.1:8000",
        changeOrigin: true,
        secure: false,
      }
    }
  }
})
