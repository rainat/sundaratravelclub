import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import path from "path"
// import { v4wp } from '@kucrut/vite-for-wp';
// import { wp_scripts } from '@kucrut/vite-for-wp/plugins';

const BUILD = path.resolve('../dist')
// https://vitejs.dev/config/

const php_plugin_refresh = () => {
  return {
    name: 'php',
    handleHotUpdate({ file, server }) {
      if (file.endsWith('.php')) server.ws.send({ type: 'full-reload' })
    }
  } 
}

export default defineConfig({
  plugins: [
    //   v4wp({
    //   input: 'src/main.tsx',
    //   outDir: `${BUILD}`,
    // }),
    // wp_scripts(),
    // react({
    //   jsxRuntime: 'classic',
    // }), 
    react(),
    // php_plugin_refresh()
  ],
  build: {
    rollupOptions: {
      // external: ['react', 'react/jsx-runtime'],
      input: {
        index: 'src/main.tsx',
        wc: 'src/wc.ts'
      },
      output: {
        entryFileNames: `[name].js`,
        chunkFileNames: `[name].js`,
        assetFileNames: `[name].[ext]`
      }
    },

    manifest: true,
    assetsDir: '.',
    outDir: `${BUILD}`,
    emptyOutDir: true,
    // sourcemap: true, 
  }, 
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
  },
})
