<template>
  <div>
    <p>Selamat datang, {{ auth.user?.name }}</p>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
const auth = useAuthStore()

definePageMeta({
  middleware: 'auth'
})
</script>