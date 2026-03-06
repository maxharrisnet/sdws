import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig(({ mode }) => ({
	publicDir: false,
	build: {
		outDir: 'assets/js/dist',
		emptyOutDir: true,
		sourcemap: mode !== 'production',
		rollupOptions: {
			input: {
				theme: path.resolve(__dirname, 'assets/js/theme.js'),
			},
			output: {
				entryFileNames: '[name].js',
				format: 'iife',
				name: 'StarterCoatBundle',
			},
		},
	},
}));
