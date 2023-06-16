import { defineConfig } from "vite";
import liveReload from "vite-plugin-live-reload";

// clear out dir before build
export default defineConfig({
	build: {
		manifest: true,
		emptyOutDir: true,
		rollupOptions: {
			input: [
				"./resources/ts/core.d.ts",
				"./resources/ts/main.ts",
				"./resources/style/tailwind.base.scss",
			],
			output: {
				dir: "./public/dist",
			},
		},
	},

	resolve: {
		alias: {
			"@/": "/resources/",
		},
	},
});
