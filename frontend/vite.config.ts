import vue from '@vitejs/plugin-vue'
import { defineConfig } from 'vite'
import { quasar } from '@quasar/vite-plugin'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    quasar(),
  ],
  resolve: {
    alias: {
      '@': '/src',
    },
  },
  server: {
    proxy: {
      '/api': {
        target: 'http://127.0.0.1:8000',
        changeOrigin: true,
      },
    },
  },
})
