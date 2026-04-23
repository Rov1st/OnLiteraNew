<template>
    <div class="flex flex-col min-h-screen bg-white">
        <!-- Header -->
        <header>
            <nav :class="[
                'fixed top-0 w-full z-50 shadow-md transition-colors duration-300 p-5 md:p-4',
                isScrolled ? 'bg-transparent backdrop-blur-sm' : 'bg-blue-400'
            ]">
                <div class="flex flex-row justify-between items-center mx-2 md:mx-4">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <NuxtLink to="">

                            <img src="" alt="logo" class="w-8 h-8 md:w-10 md:h-10" />
                        </NuxtLink>
                        <NuxtLink to="/" :class="[
                            'text-2xl md:text-4xl font-bold bg-gradient-to-r from-blue-200 to-white bg-clip-text text-transparent transition-colors duration-300',
                            isScrolled ? '!text-black !bg-none' : ''
                        ]">
                            OnLitera
                        </NuxtLink>
                    </div>

                    <!-- Mobile menu button -->
                    <button @click="isMenuOpen = !isMenuOpen" class="md:hidden focus:outline-none"
                        :class="isScrolled ? 'text-black' : 'text-white'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex space-x-6 lg:space-x-12">
                        <NuxtLink to="/#" :class="[
                            'text-xl lg:text-2xl font-bold border-b-4 border-transparent transition duration-300',
                            isScrolled ? 'text-black hover:border-black' : 'text-white hover:border-white'
                        ]">
                            Home
                        </NuxtLink>
                        <NuxtLink to="/#aboutus" :class="[
                            'text-xl lg:text-2xl font-bold border-b-4 border-transparent transition duration-300',
                            isScrolled ? 'text-black hover:border-black' : 'text-white hover:border-white'
                        ]">
                            About Us
                        </NuxtLink>
                        <NuxtLink to="/#contactus" :class="[
                            'text-xl lg:text-2xl font-bold border-b-4 border-transparent transition duration-300',
                            isScrolled ? 'text-black hover:border-black' : 'text-white hover:border-white'
                        ]">
                            Contact Us
                        </NuxtLink>
                        <NuxtLink to="/perpustakaan" :class="[
                            'text-xl lg:text-2xl font-bold border-b-4 border-transparent transition duration-300',
                            isScrolled ? 'text-black hover:border-black' : 'text-white hover:border-white'
                        ]">
                            Library
                        </NuxtLink>

                        <!-- Auth -->
                        <NuxtLink v-if="!auth.isLoggedIn()" to="/login" :class="[
                            'text-xl lg:text-2xl font-bold border-b-4 border-transparent transition duration-300',
                            isScrolled ? 'text-black hover:border-black' : 'text-white hover:border-white'
                        ]">
                            Login
                        </NuxtLink>

                        <!-- Profile Dropdown -->
                        <div v-else class="relative inline-block text-left">
                            <button @click="isOpen = !isOpen" :class="[
                                'text-xl lg:text-2xl font-bold border-b-4 border-transparent transition duration-300 flex flex-row',
                                isScrolled ? 'text-black hover:border-black' : 'text-white hover:border-white'
                            ]">
                                Profile
                                <svg class="-mr-1 ml-2 h-5 w-5 mt-2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div v-if="isOpen" class="absolute bg-white w-full rounded-b-md shadow-md text-center">
                                <div>
                                    <NuxtLink to="/profile">
                                        <p class="text-xl p-1 hover:bg-gray-200">Profile</p>
                                    </NuxtLink>
                                </div>
                                <div>
                                    <NuxtLink to="/transaksi">
                                        <p class="text-xl p-1 hover:bg-gray-200">Transaksi</p>
                                    </NuxtLink>
                                </div>
                                <div>
                                    <NuxtLink @click="handleLogout(); refreshPage()" to="">
                                        <p class="text-xl px-1 py-2 hover:bg-gray-200">Logout</p>
                                    </NuxtLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div v-show="isMenuOpen" class="md:hidden mt-2 py-2 px-4 rounded-lg"
                    :class="isScrolled ? 'bg-white' : 'bg-blue-500/90'">
                    <div class="flex flex-col space-y-3">
                        <NuxtLink to="/#" :class="[
                            'text-lg font-bold border-b-2 border-transparent hover:border-black transition duration-300 py-1',
                            isScrolled ? 'text-black' : 'text-white'
                        ]">
                            Home
                        </NuxtLink>
                        <NuxtLink to="/#aboutus" :class="[
                            'text-lg font-bold border-b-2 border-transparent hover:border-black transition duration-300 py-1',
                            isScrolled ? 'text-black' : 'text-white'
                        ]">
                            About Us
                        </NuxtLink>
                        <NuxtLink to="/#contactus" :class="[
                            'text-lg font-bold border-b-2 border-transparent hover:border-black transition duration-300 py-1',
                            isScrolled ? 'text-black' : 'text-white'
                        ]">
                            Contact Us
                        </NuxtLink>
                        <NuxtLink to="/perpustakaan" :class="[
                            'text-lg font-bold border-b-2 border-transparent hover:border-black transition duration-300 py-1',
                            isScrolled ? 'text-black' : 'text-white'
                        ]">
                            Library
                        </NuxtLink>

                        <!-- Auth -->
                        <NuxtLink v-if="!auth.isLoggedIn()" to="/login" :class="[
                            'text-lg font-bold border-b-2 border-transparent hover:border-black transition duration-300 py-1',
                            isScrolled ? 'text-black' : 'text-white'
                        ]">
                            Login
                        </NuxtLink>
                        <NuxtLink v-if="auth.isLoggedIn()" to="/profile" :class="[
                            'text-lg font-bold border-b-2 border-transparent hover:border-black transition duration-300 py-1',
                            isScrolled ? 'text-black' : 'text-white'
                        ]">
                            Profile
                        </NuxtLink>
                        <NuxtLink v-if="auth.isLoggedIn()" to="/transaksi" :class="[
                            'text-lg font-bold border-b-2 border-transparent hover:border-black transition duration-300 py-1',
                            isScrolled ? 'text-black' : 'text-white'
                        ]">
                            Transaksi
                        </NuxtLink>
                        <NuxtLink v-if="auth.isLoggedIn()" @click="handleLogout(); navigateTo(''); refreshPage()" :class="[
                            'text-lg font-bold border-b-2 border-transparent hover:border-black transition duration-300 py-1',
                            isScrolled ? 'text-black' : 'text-white'
                        ]">
                            Logout
                        </NuxtLink>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <html class="flex-grow scroll-smooth">

        <main class="pt-18">
            <!-- biar tidak ketiban navbar fixed -->
            <slot />
        </main>

        </html>

        <!-- Footer -->
        <footer v-if="!isAuthPage" class="w-full bg-gray-800 text-white p-4">
            <div class="container mx-auto text-center">
                <p>© 2025 OnLitera. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>


<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRoute, navigateTo } from '#app'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

const isMenuOpen = ref(false)
const isScrolled = ref(false)
const isOpen = ref(false)

const route = useRoute()
const isAuthPage = computed(() => ['/login', '/register'].includes(route.path))

function refreshPage() {
    window.location.reload()
}

function handleLogout() {
    auth.logout()
    navigateTo('/')
}

function handleScroll() {
    isScrolled.value = window.scrollY > 10
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
    window.addEventListener('click', (e) => {
        if (!e.target.closest('.relative')) {
            isOpen.value = false
        }
    })
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>
