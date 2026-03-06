import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs';

const jsDir = path.resolve(__dirname, 'js');
const scriptFiles = fs.readdirSync(jsDir)
  .filter((file) => file.endsWith('.js') && file !== 'customizer.js')
  .reduce((entries, file) => {
    entries[file.replace('.js', '')] = path.resolve(jsDir, file);
    return entries;
  }, {});

export default defineConfig(({ mode }) => ({
  publicDir: false,
  build: {
    outDir: 'assets/js/min',
    emptyOutDir: true,
    sourcemap: mode !== 'production',
    rollupOptions: {
      input: scriptFiles,
      output: {
        entryFileNames: '[name].min.js',
        format: 'es',
      },
    },
  },
}));
