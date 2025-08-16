import tailwindcss from "@tailwindcss/vite";
export default defineNuxtConfig({
  modules: ['@pinia/nuxt',],
  components: true,
  runtimeConfig: {
    public: {
      apiBase: 'http://localhost:8000/api'
    }
  },
  compatibilityDate: "2025-07-15",
  devtools: { enabled: true },
  css: ['~/assets/css/main.css'],
  vite: {
    plugins: [
      tailwindcss(),
    ],
  },
});