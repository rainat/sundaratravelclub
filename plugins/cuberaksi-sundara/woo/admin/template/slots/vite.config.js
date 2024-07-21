import { defineConfig } from 'vite'
import preact from '@preact/preset-vite'
import path from "path"
// https://vitejs.dev/config/
export default defineConfig({
  plugins: [preact()],
  build: {
    rollupOptions: {
      // external: ['react', 'react/jsx-runtime'],
      input: {
        admin: 'src/main.jsx',
        
      },
      output: {
        entryFileNames: `[name].js`,
        chunkFileNames: `[name].js`,
        assetFileNames: `[name].[ext]`
      }
    },

    manifest: true,
    assetsDir: '.',
    outDir: path.resolve('../dist'),
    emptyOutDir: true,
    // sourcemap: true, 
  }, 
  
})
