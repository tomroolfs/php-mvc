/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ["./resources/**/*.{twig,html,js,ts}"],
	theme: {
		extend: {},
	},
	plugins: [require("@tailwindcss/typography")],
};
