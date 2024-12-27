import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'
import path from 'path'
import { fileURLToPath } from 'url'
const file = fileURLToPath(import.meta.url)
const dir = path.dirname(file).replace(/\\+/, '/')

// https://vite.dev/config/
export default defineConfig({
  plugins: [svelte()],
  resolve: {
    alias: {
      $lib: `${path.resolve(dir, 'src/client/lib')}`,
    },
  },
  publicDir: 'assets',
  build: {
    sourcemap: false,
    outDir: 'statics',
    minify: true,
    emptyOutDir: false,
    rollupOptions: {
      output: {
        entryFileNames: `assets/[name].js`,
        chunkFileNames: `assets/[name].js`,
        assetFileNames: `assets/[name].[ext]`,
      },
    },
  },
  server: {
    host: '::',
    proxy: {
      '^/api/.*': {
        target: 'http://localhost:5757',
        changeOrigin: false,
        secure: false,
        ws: true,
      },
    },
  },
})
