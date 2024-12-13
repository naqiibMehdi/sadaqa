import {defineConfig} from 'vite'
import vue from '@vitejs/plugin-vue'
import {URL, fileURLToPath} from "node:url"
import Icons from "unplugin-icons/vite"


// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue(), Icons()],
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("./src", import.meta.url))
        }
    }
})
