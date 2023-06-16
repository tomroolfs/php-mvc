declare global {
	interface Window {
		__core__: any;
	}
}

declare const window: Window & typeof globalThis;
