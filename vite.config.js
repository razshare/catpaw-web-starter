import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'

// https://vite.dev/config/
export default defineConfig({
  plugins: [svelte()],
  resolve: {
    alias: {
      $lib: './src/client/lib',
    },
  },
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
        target: 'http://127.0.0.1:5757',
        changeOrigin: false,
        rewrite: function replace(path) {
          return path.replace(/^\/api/, '')
        },
        secure: false,
        ws: true,
      },
    },
  },
})
