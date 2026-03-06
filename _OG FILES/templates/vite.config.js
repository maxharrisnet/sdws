import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  publicDir: false,
  build: {
    outDir: 'assets/js/dist',
    emptyOutDir: false,
    sourcemap: true,
    rollupOptions: {
      input: {
        background: path.resolve(__dirname, 'src/background/index.js'),
      },
      output: {
        entryFileNames: '[name].js',
        assetFileNames: '[name][extname]',
        format: 'iife',
        name: 'AeraBackgroundBundle',
      },
    },
  },
});
