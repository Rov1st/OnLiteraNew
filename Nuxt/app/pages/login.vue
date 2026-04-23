<template>
    <div class="flex flex-col lg:flex-row w-full max-h-[calc(100vh-65px)] overflow-hidden">
        <!-- Left: Form -->
        <div class="w-full lg:w-1/2 px-6 py-12 overflow-hidden">
            <div class="max-w-md mx-auto space-y-8">
                <!-- Logo & Header -->
                <div>
                    <img src="/" alt="Logo" class="h-10 w-auto mb-4" />
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                        Sign in to your account
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Don't have an account?
                        <NuxtLink to="/register" class="font-semibold text-indigo-600 hover:text-indigo-500">
                            Register
                        </NuxtLink>
                    </p>
                </div>

                <!-- Session Status -->
                <p v-if="status" class="mb-4 text-green-600">{{ status }}</p>

                <!-- Form -->
                <form @submit.prevent="submitForm" class="space-y-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block font-medium text-sm text-gray-700">
                            Email
                        </label>
                        <input v-model="form.email" id="email"
                            class="block w-full h-10 mt-1 border border-slate-300 rounded px-2" type="email"
                            name="email" required autofocus autocomplete="username" />
                        <p v-if="errors.email" class="mt-2 text-red-600 text-sm">
                            {{ errors.email }}
                        </p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block font-medium text-sm text-gray-700">
                            Password
                        </label>
                        <input v-model="form.password" id="password"
                            class="block w-full h-10 mt-1 border border-slate-300 rounded px-2" type="password"
                            name="password" required autocomplete="current-password" />
                        <p v-if="errors.password" class="mt-2 text-red-600 text-sm">
                            {{ errors.password }}
                        </p>
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input v-model="form.remember" id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember" />
                            <span class="ms-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-between mt-6">
                        <NuxtLink to="/forgot-password" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            Forgot your password?
                        </NuxtLink>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Image -->
        <div class="hidden lg:block w-full lg:w-1/2 h-screen">
            <img src="/images/register-preview.jpg" alt="Login image" class="w-full h-full object-cover" />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'

// Ambil runtime config untuk base API URL
const config = useRuntimeConfig()
const auth = useAuthStore()

const form = ref({
    email: '',
    password: '',
    remember: false,
})
const errors = ref({})
const status = ref('')

const submitForm = async () => {
    errors.value = {}
    status.value = ''

    try {
        const res = await $fetch(`${config.public.apiBase}/login`, {
            method: 'POST',
            body: {
                email: form.value.email,
                password: form.value.password,
                remember: form.value.remember,
            },
            headers: {
                'Content-Type': 'application/json',
            },
        })

        status.value = 'Login successful!'
        console.log('Login response:', res)
        
        if (res.user?.id) {
            localStorage.setItem("user_id", res.user.id)
        }

        // Simpan token & user di store Pinia
        auth.login(res.access_token, res.user)

        // Redirect setelah login
        navigateTo('/')

    } catch (err) {
        console.error('Login error:', err)

        if (err.status === 422 && err.data && err.data.errors) {
            errors.value = Object.fromEntries(
                Object.entries(err.data.errors).map(([key, messages]) => [key, messages[0]])
            )
        } else if (err.data?.message) {
            status.value = err.data.message
        } else {
            status.value = 'Login failed. Please try again.'
        }
    }
}
</script>
