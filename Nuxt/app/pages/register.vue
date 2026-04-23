<template>
  <div class="flex flex-col lg:flex-row w-full max-h-[calc(100vh-65px)] overflow-hidden">
    <!-- Left: Form -->
    <div class="w-full lg:w-1/2 px-6 py-12 overflow-hidden">
      <div class="max-w-md mx-auto space-y-8">
        <!-- Logo & Header -->
        <div>
          <img src="/" alt="Logo" class="h-10 w-auto mb-4" />
          <h2 class="text-2xl font-bold tracking-tight text-gray-900">
            Create your account
          </h2>
          <p class="mt-2 text-sm text-gray-600">
            Already have an account?
            <NuxtLink to="/login" class="font-semibold text-indigo-600 hover:text-indigo-500">
              Sign in
            </NuxtLink>
          </p>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitForm" class="space-y-6">
          <!-- Full Name -->
          <div>
            <label for="name" class="block font-medium text-sm text-gray-700">
              Full Name
            </label>
            <input v-model="form.name" id="name" name="name" type="text" required autofocus
              class="block w-full h-10 mt-1 border border-slate-300 rounded px-2" />
            <p v-if="errors.name" class="mt-2 text-sm text-red-600">
              {{ errors.name }}
            </p>
          </div>

          <!-- Display Name -->
          <div>
            <label for="display_name" class="block font-medium text-sm text-gray-700">
              Display Name
            </label>
            <input v-model="form.display_name" id="display_name" name="display_name" type="text" required
              class="block w-full h-10 mt-1 border border-slate-300 rounded px-2" />
            <p v-if="errors.display_name" class="mt-2 text-sm text-red-600">
              {{ errors.display_name }}
            </p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block font-medium text-sm text-gray-700">
              Email
            </label>
            <input v-model="form.email" id="email" name="email" type="email" required
              class="block w-full h-10 mt-1 border border-slate-300 rounded px-2" />
            <p v-if="errors.email" class="mt-2 text-sm text-red-600">
              {{ errors.email }}
            </p>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block font-medium text-sm text-gray-700">
              Password
            </label>
            <input v-model="form.password" id="password" name="password" type="password" required
              autocomplete="new-password" class="block w-full h-10 mt-1 border border-slate-300 rounded px-2" />
            <p v-if="errors.password" class="mt-2 text-sm text-red-600">
              {{ errors.password }}
            </p>
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">
              Confirm Password
            </label>
            <input v-model="form.password_confirmation" id="password_confirmation" name="password_confirmation"
              type="password" required autocomplete="new-password"
              class="block w-full h-10 mt-1 border border-slate-300 rounded px-2" />
            <p v-if="errors.password_confirmation" class="mt-2 text-sm text-red-600">
              {{ errors.password_confirmation }}
            </p>
          </div>

          <!-- Register Button -->
          <div>
            <button type="submit"
              class="w-full justify-center inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
              Register
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Right: Full Image -->
    <div class="hidden lg:block w-full lg:w-1/2 h-screen">
      <img src="/images/register-preview.jpg" alt="Register image" class="w-full h-full object-cover" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Ambil base API dari runtime config (pastikan di nuxt.config.js sudah diset)
const config = useRuntimeConfig()

const form = ref({
  name: "",
  display_name: "",
  email: "",
  password: "",
  password_confirmation: "",
})

const errors = ref({})
const status = ref("")

const submitForm = async () => {
  errors.value = {}
  status.value = ""

  try {
    const res = await $fetch(`${config.public.apiBase}/register`, {
      method: "POST",
      body: {
        name: form.value.name,
        display_name: form.value.display_name,
        email: form.value.email,
        password: form.value.password,
        password_confirmation: form.value.password_confirmation,
      },
      headers: {
        'Content-Type': 'application/json',
      },
    })

    console.log("Register success:", res)
    status.value = "Registration successful!"

    // Jika API langsung mengirim token, simpan di localStorage
    if (res.access_token) {
      localStorage.setItem("token", res.access_token)
      // Lakukan redirect atau update state login jika perlu
    }

    navigateTo('/login')

  } catch (err) {
    console.error("Register error:", err)
    if (err.status === 422 && err.data?.errors) {
      errors.value = err.data.errors
    } else if (err.data?.message) {
      status.value = err.data.message
    } else {
      status.value = "Registration failed. Please try again."
    }
  }
}

// watch(
//     () => auth.user,
//     (user) => {
//         if (user) {
//             navigateTo("/perpustakaan")
//         } else {
//             navigateTo("")
//         }
//     },
//     { immediate: true }
// )
</script>

