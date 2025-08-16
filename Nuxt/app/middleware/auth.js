import { useAuthStore } from '@/stores/auth'

export default defineNuxtRouteMiddleware((to, from) => {
  if (process.server) return // Jangan cek di server

  const auth = useAuthStore()
  auth.initAuth() // Ambil token dari localStorage

  if (!auth.isLoggedIn()) {
    return navigateTo('')
  }
})