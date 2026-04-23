<template>
  <div class="flex">
    <aside class="hidden md:block w-100 h-236.5 sticky top-0 bg-gray-800 text-white p-4">
      <div class="items-center justify-center text-center p-3 flex">
        <img src="/images/img1.jpg" alt="User Profile Picture" class="rounded-full w-50 h-50 hidden">
      </div>
      <div class="items-center justify-center text-center flex-col mt-2">
        <p class="text-4xl font-bold">{{ auth.user?.name }}</p>
        <p class="text-2xl font-semibold">{{ createdAt }}</p>
      </div>
      <div class="items-center justify-center text-center flex flex-col mt-5">
        <a href="" class="text-3xl border-b-2 border-transparent hover:border-gray-400 hover:text-gray-400">
          Personal Information
        </a>
      </div>
    </aside>

    <div v-if="isMobileSidebarOpen" class="fixed inset-0 flex z-50 md:hidden">
      <div @click="closeMobileSidebar" class="fixed inset-0 bg-black/60"></div>

      <aside class="relative w-80 bg-gray-800 text-white p-4">
        <button @click="closeMobileSidebar" class="absolute top-3 right-3 text-white">
          <XMarkIcon class="w-8 h-8" />
        </button>
        <div class="items-center justify-center text-center flex-col mt-12">
          <p class="text-4xl font-bold">{{ auth.user?.name }}</p>
          <p class="text-2xl font-semibold">{{ createdAt }}</p>
        </div>
        <div class="items-center justify-center text-center flex flex-col mt-8">
          <a href="" class="text-3xl border-b-2 border-transparent hover:border-gray-400 hover:text-gray-400">
            Personal Information
          </a>
        </div>
      </aside>
    </div>


    <section class="flex flex-col p-6 w-full h-220">
      <div class="md:hidden flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Profile</h1>
        <button @click="openMobileSidebar" class="text-gray-800">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>

      <div class="flex flex-col space-y-8">
        <div>
          <h1 class="text-xl font-semibold mb-4">Sensitive Information</h1>
          <div class="space-y-4">
            <div class="flex items-center">
              <label for="email" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                E-mail
              </label>
              <input type="email" id="email" class="flex-1 h-10 px-3 rounded-lg border border-slate-300"
                v-model="auth.user.email" readonly disabled>
              <button class="flex items-center gap-2 text-black/70 hover:text-black">
                <p class="w-6 h-6 ml-4"></p>
              </button>
            </div>

            <div class="flex items-center">
              <label for="password" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                Password
              </label>
              <input type="password" id="password" class="flex-1 h-10 px-3 rounded-lg border border-slate-300"
                value="***********************" readonly disabled>
              <button @click="passwordOpen" class="flex items-center gap-2 text-black/70 hover:text-black">
                <PencilSquareIcon class="w-6 h-6 ml-4" />
              </button>
            </div>

            <div class="flex items-center">
              <label for="no_telp" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                Nomor Telepon
              </label>
              <input type="number" id="no_telp" class="flex-1 h-10 px-3 rounded-lg border border-slate-300"
                v-model="auth.user.no_telp" readonly disabled>
              <button @click="telpOpen" class="flex items-center gap-2 text-black/70 hover:text-black">
                <PencilSquareIcon class="w-6 h-6 ml-4" />
              </button>
            </div>
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold mb-4">School Personal Information</h1>
            <button @click="studentOpen" class="flex items-center gap-2 text-black/70 hover:text-black">
              <PencilSquareIcon class="w-6 h-6 ml-4" />
            </button>
          </div>
          <div class="space-y-4">
            <div class="flex items-center">
              <label for="display_name" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                Display Name
              </label>
              <input type="text" id="display_name" class="flex-1 h-10 px-3 rounded-lg border border-slate-300"
                v-model="auth.user.display_name" readonly disabled>
              <button class="flex items-center gap-2 text-black/70 hover:text-black">
                <p class="w-6 h-6 ml-4"></p>
              </button>
            </div>

            <div class="flex items-center">
              <label for="NIK" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                NIK
              </label>
              <input type="number" id="NIK" class="flex-1 h-10 px-3 rounded-lg border border-slate-300"
                v-model="auth.user.NIK" readonly disabled>
              <button class="flex items-center gap-2 text-black/70 hover:text-black">
                <p class="w-6 h-6 ml-4"></p>
              </button>
            </div>

            <div class="flex items-center">
              <label for="NISN" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                NISN
              </label>
              <input type="number" id="NISN" class="flex-1 h-10 px-3 rounded-lg border border-slate-300"
                v-model="auth.user.NISN" readonly disabled>
              <button class="flex items-center gap-2 text-black/70 hover:text-black">
                <p class="w-6 h-6 ml-4"></p>
              </button>
            </div>

            <div class="flex items-center">
              <label for="kelas" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                Kelas
              </label>
              <select id="kelas" v-model="auth.user.kelas" name="kelas"
                class="flex-1 h-10 px-3 rounded-lg border border-slate-300" required disabled>
                <option value="">-- Pilih Kelas --</option>
                <optgroup label="Kelas X">
                  <option value="X RPL 1">X RPL 1</option>
                  <option value="X RPL 2">X RPL 2</option>
                  <option value="X AK 1">X AK 1</option>
                  <option value="X AK 2">X AK 2</option>
                  <option value="X AK 3">X AK 3</option>
                  <option value="X AK 4">X AK 4</option>
                  <option value="X AK 5">X AK 5</option>
                  <option value="X AK 6">X AK 6</option>
                  <option value="X TKJ 1">X TKJ 1</option>
                  <option value="X TKJ 2">X TKJ 2</option>
                  <option value="X TKJ 3">X TKJ 3</option>
                </optgroup>
                <optgroup label="Kelas XI">
                  <option value="XI RPL 1">XI RPL 1</option>
                  <option value="XI RPL 2">XI RPL 2</option>
                  <option value="XI AK 1">XI AK 1</option>
                  <option value="XI AK 2">XI AK 2</option>
                  <option value="XI AK 3">XI AK 3</option>
                  <option value="XI AK 4">XI AK 4</option>
                  <option value="XI AK 5">XI AK 5</option>
                  <option value="XI AK 6">XI AK 6</option>
                  <option value="XI TKJ 1">XI TKJ 1</option>
                  <option value="XI TKJ 2">XI TKJ 2</option>
                  <option value="XI TKJ 3">XI TKJ 3</option>
                </optgroup>
                <optgroup label="Kelas XII">
                  <option value="XII RPL 1">XII RPL 1</option>
                  <option value="XII RPL 2">XII RPL 2</option>
                  <option value="XII AK 1">XII AK 1</option>
                  <option value="XII AK 2">XII AK 2</option>
                  <option value="XII AK 3">XII AK 3</option>
                  <option value="XII AK 4">XII AK 4</option>
                  <option value="XII AK 5">XII AK 5</option>
                  <option value="XII AK 6">XII AK 6</option>
                  <option value="XII TKJ 1">XII TKJ 1</option>
                  <option value="XII TKJ 2">XII TKJ 2</option>
                  <option value="XII TKJ 3">XII TKJ 3</option>
                </optgroup>
                <option value="Tamu">Tamu</option>
              </select>
              <button class="flex items-center gap-2 text-black/70 hover:text-black">
                <p class="w-6 h-6 ml-4"></p>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="editPassword" @click.self="passwordClose"
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
          <button @click="passwordClose" type="button" class="absolute top-4 right-4 text-gray-500 hover:text-black">
            <XMarkIcon class="w-6 h-6" />
          </button>

          <form @submit.prevent="changePassword" method="post" class="space-y-4">
            <h1 class="text-xl font-semibold">Change Password</h1>
            <div class="flex items-center">
              <label for="old-password" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                Old Password
              </label>
              <input type="password" id="old-password" name="old-password" v-model="oldPassword"
                class="flex-1 h-10 px-3 rounded-lg border border-slate-300" placeholder="Old Password" />
            </div>

            <div class="flex items-center">
              <label for="new-password" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                New Password
              </label>
              <input type="password" id="new-password" name="new-password" v-model="newPassword"
                class="flex-1 h-10 px-3 rounded-lg border border-slate-300" placeholder="New Password" />
            </div>

            <div class="flex items-center">
              <label for="confirm-password" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                Confirm Password
              </label>
              <input type="password" id="confirm-password" name="confirm-password" v-model="confirmPassword"
                class="flex-1 h-10 px-3 rounded-lg border border-slate-300" placeholder="Confirm Password" />
            </div>

            <div class="flex justify-end">
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Confirm
              </button>
            </div>
          </form>
        </div>
      </div>

      <div v-if="editTelp" @click.self="telpClose"
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
          <button @click="telpClose" type="button" class="absolute top-4 right-4 text-gray-500 hover:text-black">
            <XMarkIcon class="w-6 h-6" />
          </button>

          <form @submit.prevent="changeTelp" method="post" class="space-y-4">
            <h1 class="text-xl font-semibold">Change Phone Number</h1>
            <div class="flex items-center">
              <input type="text" @input="phone = phone.replace(/[^0-9]/g, '')" id="no_telp" name="no_telp"
                v-model="newTelp" class="flex-1 h-10 px-3 rounded-lg border border-slate-300"
                placeholder="Your new phone number" />
            </div>

            <div class="flex justify-end">
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Confirm
              </button>
            </div>
          </form>
        </div>
      </div>

      <div v-if="editStudent" @click.self="studentClose"
        class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
          <button @click="studentClose" type="button" class="absolute top-4 right-4 text-gray-500 hover:text-black">
            <XMarkIcon class="w-6 h-6" />
          </button>

          <form @submit.prevent="updateUser" method="post" class="space-y-4">
            <h1 class="text-xl font-semibold">Change School Student Information</h1>
            <div class="flex items-center">
              <label for="display_name" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                Display Name
              </label>
              <input type="text" id="display_name" class="flex-1 h-10 px-3 rounded-lg border border-slate-300"
                v-model="auth.user.display_name">
            </div>

            <div class="flex items-center">
              <label for="NIK" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                NIK
              </label>
              <input type="text" @input="NIK = NIK.replace(/[^0-9]/g, '')" id="NIK"
                class="flex-1 h-10 px-3 rounded-lg border border-slate-300" v-model="auth.user.NIK">
            </div>

            <div class="flex items-center">
              <label for="NISN" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                NISN
              </label>
              <input type="text" @input="NISN = NISN.replace(/[^0-9]/g, '')" id="NISN"
                class="flex-1 h-10 px-3 rounded-lg border border-slate-300" v-model="auth.user.NISN">
            </div>

            <div class="flex items-center">
              <label for="kelas" class="w-40 text-sm font-medium text-gray-700 text-left pr-3">
                Kelas
              </label>
              <select id="kelas" v-model="auth.user.kelas" name="kelas"
                class="flex-1 h-10 px-3 rounded-lg border border-slate-300" required>
                <option value="">-- Pilih Kelas --</option>
                <optgroup label="Kelas X">
                  <option value="X RPL 1">X RPL 1</option>
                  <option value="X RPL 2">X RPL 2</option>
                  <option value="X AK 1">X AK 1</option>
                  <option value="X AK 2">X AK 2</option>
                  <option value="X AK 3">X AK 3</option>
                  <option value="X AK 4">X AK 4</option>
                  <option value="X AK 5">X AK 5</option>
                  <option value="X AK 6">X AK 6</option>
                  <option value="X TKJ 1">X TKJ 1</option>
                  <option value="X TKJ 2">X TKJ 2</option>
                  <option value="X TKJ 3">X TKJ 3</option>
                </optgroup>
                <optgroup label="Kelas XI">
                  <option value="XI RPL 1">XI RPL 1</option>
                  <option value="XI RPL 2">XI RPL 2</option>
                  <option value="XI AK 1">XI AK 1</option>
                  <option value="XI AK 2">XI AK 2</option>
                  <option value="XI AK 3">XI AK 3</option>
                  <option value="XI AK 4">XI AK 4</option>
                  <option value="XI AK 5">XI AK 5</option>
                  <option value="XI AK 6">XI AK 6</option>
                  <option value="XI TKJ 1">XI TKJ 1</option>
                  <option value="XI TKJ 2">XI TKJ 2</option>
                  <option value="XI TKJ 3">XI TKJ 3</option>
                </optgroup>
                <optgroup label="Kelas XII">
                  <option value="XII RPL 1">XII RPL 1</option>
                  <option value="XII RPL 2">XII RPL 2</option>
                  <option value="XII AK 1">XII AK 1</option>
                  <option value="XII AK 2">XII AK 2</option>
                  <option value="XII AK 3">XII AK 3</option>
                  <option value="XII AK 4">XII AK 4</option>
                  <option value="XII AK 5">XII AK 5</option>
                  <option value="XII AK 6">XII AK 6</option>
                  <option value="XII TKJ 1">XII TKJ 1</option>
                  <option value="XII TKJ 2">XII TKJ 2</option>
                  <option value="XII TKJ 3">XII TKJ 3</option>
                </optgroup>
                <option value="Tamu">Tamu</option>
              </select>
            </div>

            <div class="flex justify-end">
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Confirm
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { XMarkIcon, PencilSquareIcon } from '@heroicons/vue/24/solid'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const config = useRuntimeConfig()

// --- Start: New code for Mobile Sidebar ---
const isMobileSidebarOpen = ref(false)

const openMobileSidebar = () => {
  isMobileSidebarOpen.value = true
}

const closeMobileSidebar = () => {
  isMobileSidebarOpen.value = false
}
// --- End: New code for Mobile Sidebar ---


const editPassword = ref(false)

const passwordOpen = () => {
  editPassword.value = true
}

const passwordClose = () => {
  editPassword.value = false
}

const editTelp = ref(false)

const telpOpen = () => {
  editTelp.value = true
}

const telpClose = () => {
  editTelp.value = false
}

const editStudent = ref(false)

const studentOpen = () => {
  editStudent.value = true
}

const studentClose = () => {
  editStudent.value = false
}

const createdAt = computed(() => {
  if (!auth.user?.created_at) return ''
  const date = new Date(auth.user.created_at)
  const day = String(date.getDate()).padStart(2, '0')
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const year = date.getFullYear()
  return `${day}-${month}-${year}`
})

definePageMeta({
  middleware: 'auth'
})

// Change Password
const oldPassword = ref('')
const newPassword = ref('')
const confirmPassword = ref('')

const changePassword = async () => {
  try {
    const res = await $fetch(`${config.public.apiBase}/change-password`, {
      method: 'POST',
      headers: {
        Authorization: `Bearer ${auth.token}`
      },
      body: {
        old_password: oldPassword.value,
        new_password: newPassword.value,
        new_password_confirmation: confirmPassword.value,
      }
    })

    alert(res.message)
    passwordClose()

    oldPassword.value = ''
    newPassword.value = ''
    confirmPassword.value = ''
  } catch (err) {
    alert(err.data?.message || 'Terjadi kesalahan')
  }
}

//Change phoneNumber
const newTelp = ref("")

const changeTelp = async () => {
  try {
    const res = await $fetch(`${config.public.apiBase}/update-phone`, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${auth.token}`,
        Accept: "application/json",
      },
      body: {
        no_telp: newTelp.value,
      },
    })

    auth.user = res.user
    localStorage.setItem("user", JSON.stringify(res.user))

    alert(res.message)
    telpClose()
    auth.user.no_telp = newTelp.value
    newTelp.value = ""
  } catch (err) {
    alert(err.data?.message || "Terjadi kesalahan")
  }
}

// Update User School Info
const updateUser = async () => {
  try {
    const res = await $fetch(`${config.public.apiBase}/user/${auth.user.id}`, {
      method: "PUT",
      headers: {
        Authorization: `Bearer ${auth.token}`,
        Accept: "application/json",
      },
      body: {
        display_name: auth.user.display_name,
        NIK: auth.user.NIK,
        NISN: auth.user.NISN,
        kelas: auth.user.kelas,
      },
    })

    auth.user = res.user
    localStorage.setItem("user", JSON.stringify(res.user))

    alert(res.message || "Data berhasil diperbarui")
    studentClose()
  } catch (error) {
    console.error(error)
    alert(error.data?.message || "Gagal memperbarui data")
  }
}
</script>