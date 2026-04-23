<template>
  <section class="p-4 md:p-8 overflow-hidden">
    <div v-if="!book">
      <div class="justify-center text-center flex align-items-center">
        <h1 class="text-black text-3xl md:text-5xl font-bold">
          Book Not <span class="text-red-600">Found</span>
        </h1>
      </div>
    </div>
    <div v-else class="flex flex-col lg:grid lg:grid-cols-3 gap-6">
      <!-- Main content section -->
      <div class="lg:col-span-2 order-2 lg:order-1">
        <div class="w-full">
          <!-- Title and stock -->
          <div class="flex flex-col sm:flex-row w-full justify-between mb-4 gap-2">
            <h1 class="text-2xl md:text-4xl font-bold break-words">{{ book.judul }}</h1>
            <div class="flex items-center gap-2">
              <p class="text-lg md:text-xl font-semibold border-b-2 text-gray-600 self-start">
                Stok : {{ realtimeStock }}
              </p>
            </div>
          </div>

          <!-- Book details -->
          <div class="flex flex-col md:flex-row justify-between gap-4 md:gap-0">
            <div class="flex text-base md:text-xl space-x-2">
              <div class="min-w-fit">
                Penerbit<br />Penulis
              </div>
              <div class="text-base md:text-xl">:<br />:</div>
              <div>
                <p class="text-base md:text-xl break-words">{{ book.penerbit }}</p>
                <p class="text-base md:text-xl break-words">{{ book.penulis }}</p>
              </div>
            </div>
            <div class="flex text-base md:text-xl space-x-2">
              <div class="min-w-fit">
                Tahun Terbit<br />Tahun Rilis
              </div>
              <div class="text-base md:text-xl">:<br />:</div>
              <div>
                <p class="text-base md:text-xl">{{ book.tahun_terbit }}</p>
                <p class="text-base md:text-xl">{{ book.tahun_rilis }}</p>
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="space-y-4 mt-4">
            <p v-for="(para, index) in formatParagraf(book.penjelasan)" :key="index"
              class="text-justify mt-2 text-base md:text-lg font-semibold">
              {{ para }}
            </p>
          </div>
        </div>
      </div>

      <!-- Image and actions section -->
      <div class="lg:col-span-1 flex flex-col justify-center items-center order-1 lg:order-2 w-full">
        <!-- Book image -->
        <div id="image" class="w-48 h-64 md:w-60 md:h-80 lg:w-72 lg:h-96 overflow-hidden rounded-md shadow-lg">
          <img class="w-full h-full object-cover" :src="`${config.public.laravelBase}/bukuofflineimg/${book.img}`"
            alt="Book cover" />
        </div>

        <!-- Genre tags -->
        <div class="flex flex-wrap mt-4 max-w-xs lg:max-w-sm gap-2 justify-center">
          <p v-for="genre in book.genres" :key="genre.id_buku"
            :class="getGenreClass(genre.genre)"
            class="px-2 py-1 rounded-xl font-semibold text-sm">{{ genre.genre }}</p>
        </div>

        <!-- Action buttons -->
        <div class="mt-4 space-y-3 flex flex-col text-white font-semibold w-full max-w-xs lg:max-w-sm">
          <button v-if="realtimeStock > 0" class="bg-blue-400 w-full hover:bg-blue-500 p-3 rounded-md transition-colors"
            @click="popOpen">
            Pinjam
          </button>
          <button v-else class="bg-gray-400 w-full p-3 rounded-md transition-colors" disabled>
            Stock Habis
          </button>
          <div class="flex flex-row space-x-2">
            <button v-if="realtimeStock > 0"
              class="bg-blue-400 flex-1 hover:bg-blue-500 p-3 rounded-md transition-colors" @click="tambahKeranjang">
              Keranjang
            </button>
            <button v-else class="bg-gray-400 flex-1 p-3 rounded-md transition-colors" disabled>
              Stok Habis
            </button>
            <button
              class="bg-red-500 w-12 hover:bg-red-600 p-3 rounded-md flex justify-center items-center transition-colors hover:cursor-pointer"
              @click="toggleFavorite">
              <HeartIcon class="w-5 h-5 text-white transition-opacity duration-300"
                :class="{ 'opacity-50': !isFavorited }" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Reservation Modal -->
    <div v-if="tampilReservasi" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4"
      @click.self="!isSubmitting && popClose()">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
        <button @click="popClose" type="button" class="absolute top-4 right-4 text-gray-500 hover:text-black"
          :disabled="isSubmitting">
          <XMarkIcon class="w-6 h-6" />
        </button>
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <h1 class="text-lg md:text-xl font-semibold">Reservasi Peminjaman</h1>
          <div class="flex items-center min-h-10 px-3 rounded-lg border border-slate-300 bg-gray-50">
            <label class="flex-1 break-words text-sm md:text-base">{{ book.judul }}</label>
          </div>
          <div class="flex items-center min-h-10 px-3 rounded-lg border border-slate-300 bg-gray-50">
            <label class="flex-1 break-words text-sm md:text-base">{{ book.penulis }}</label>
          </div>
          <div class="flex items-center">
            <input type="date" v-model="tanggal_pinjam"
              class="flex-1 h-10 px-3 rounded-lg border border-slate-300 text-sm md:text-base" required :min="today"
              :disabled="isSubmitting" />
          </div>
          <h1 class="text-base md:text-lg">Tanggal Harus Kembali :</h1>
          <div class="flex items-center">
            <input type="text" v-model="tanggal_hrs_kembali"
              class="flex-1 h-10 px-3 rounded-lg border border-slate-300 text-sm md:text-base bg-gray-50"
              placeholder="dd/mm/yyyy" disabled />
          </div>
          <h1 class="text-base md:text-lg">Konfirmasi Peminjaman :</h1>
          <div class="flex items-center">
            <input type="password" v-model="password"
              class="flex-1 h-10 px-3 rounded-lg border border-slate-300 text-sm md:text-base" placeholder="Password"
              required :disabled="isSubmitting" />
          </div>
          <div class="flex justify-end">
            <button type="submit" :disabled="isSubmitting"
              class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition text-sm md:text-base disabled:bg-gray-400 disabled:cursor-not-allowed min-w-[120px] flex items-center justify-center">
              <span v-if="!isSubmitting">Confirm</span>
              <span v-else class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                Loading...
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Success notification modal -->
    <div v-if="tampilPemberitahuan" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4"
      @click.self="tampilClose">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
        <button @click="tampilClose" type="button" class="absolute top-4 right-4 text-gray-500 hover:text-black">
          <XMarkIcon class="w-6 h-6" />
        </button>
        <h1 class="font-semibold text-base md:text-lg text-center p-2">
          Buku berhasil dipinjam, Mohon ditunggu <span class="text-blue-400">konfirmasinya</span>!
        </h1>
        <div class="p-1 flex">
          <button @click="tampilClose"
            class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm md:text-base">
            Confirm
          </button>
        </div>
      </div>
    </div>

    <!-- Cart notification modal -->
    <div v-if="tampilKeranjang" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4"
      @click.self="tampilKClose">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
        <button @click="tampilKClose" type="button" class="absolute top-4 right-4 text-gray-500 hover:text-black">
          <XMarkIcon class="w-6 h-6" />
        </button>
        <h1 class="font-semibold text-base md:text-lg text-center p-2">Buku berhasil Masuk ke Keranjang!</h1>
        <div class="flex flex-col space-y-2">
          <div class="flex">
            <a href="/keranjang"
              class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-center text-sm md:text-base">
              Buka Keranjang
            </a>
          </div>
          <div class="flex">
            <button @click="tampilKClose"
              class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm md:text-base">
              Confirm
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { XMarkIcon, HeartIcon } from '@heroicons/vue/24/solid'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const idBuku = route.query.id
const config = useRuntimeConfig()
const { data: book } = await useFetch(`${config.public.apiBase}/book/${idBuku}`)

// Realtime stock variables
const realtimeStock = ref(book.value?.stok || 0)
const isLoadingStock = ref(false)
let stockInterval = null

// Fungsi untuk fetch stock terbaru
const fetchRealtimeStock = async () => {
  if (!idBuku) return

  isLoadingStock.value = true
  try {
    const response = await $fetch(`${config.public.apiBase}/book/${idBuku}`)
    if (response && response.stok !== undefined) {
      realtimeStock.value = response.stok
    }
  } catch (error) {
    console.error('Error fetching stock:', error)
  } finally {
    isLoadingStock.value = false
  }
}

// Setup polling untuk realtime stock
onMounted(async () => {
  userId.value = localStorage.getItem('user_id')
  if (userId.value) checkFavorit()
  await $fetch(`${config.public.apiBase}/counter/${idBuku}`, {
    method: "POST"
  })

  // Set initial stock
  realtimeStock.value = book.value?.stok || 0

  // Start polling every 3 seconds
  stockInterval = setInterval(() => {
    fetchRealtimeStock()
  }, 3000)
})

// Cleanup interval saat component di-unmount
onUnmounted(() => {
  if (stockInterval) {
    clearInterval(stockInterval)
  }
})

const tampilReservasi = ref(false)
const isSubmitting = ref(false)

const popOpen = () => {
  if (!userId.value) return router.push('/login')
  tampilReservasi.value = true
}

const popClose = () => {
  if (isSubmitting.value) return
  if (!userId.value) return router.push('/login')
  tampilReservasi.value = false
  tanggal_pinjam.value = ''
  tanggal_hrs_kembali.value = ''
  password.value = ''
}

const tanggal_pinjam = ref('')
const tanggal_hrs_kembali = ref('')
const password = ref('')
const today = new Date().toISOString().split('T')[0]

watch(tanggal_pinjam, (newVal) => {
  if (newVal) {
    let tgl = new Date(newVal)
    tgl.setDate(tgl.getDate() + 5)
    const dd = String(tgl.getDate()).padStart(2, '0')
    const mm = String(tgl.getMonth() + 1).padStart(2, '0')
    const yyyy = tgl.getFullYear()
    tanggal_hrs_kembali.value = `${dd}/${mm}/${yyyy}`
  } else {
    tanggal_hrs_kembali.value = ''
  }
})

const auth = useAuthStore()
const userId = ref(null)

const tampilKeranjang = ref(false)
const tampilKClose = () => (tampilKeranjang.value = false)

const tampilPemberitahuan = ref(false)
const tampilClose = () => {
  tampilPemberitahuan.value = false
  tanggal_pinjam.value = ''
  tanggal_hrs_kembali.value = ''
  password.value = ''
}

const isFavorited = ref(false)
const checkFavorit = async () => {
  try {
    const res = await $fetch(`${config.public.apiBase}/favorite/check/${userId.value}/${idBuku}`)
    isFavorited.value = res.favorited
  } catch { }
}

const toggleFavorite = async () => {
  if (!userId.value) return router.push('/login')
  try {
    const res = await $fetch(`${config.public.apiBase}/favorit/toggle`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: { id_user: Number(userId.value), id_buku: Number(idBuku) }
    })
    isFavorited.value = res.status === 'favorited'
  } catch { }
}

const tambahKeranjang = async () => {
  if (!userId.value) return router.push('/login')
  try {
    const res = await $fetch(`${config.public.apiBase}/keranjang`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: { id_user: Number(userId.value), id_buku: Number(idBuku) }
    })
    if (res.success) tampilKeranjang.value = true
    else alert(res.message || 'Gagal menambahkan ke keranjang')
  } catch {
    alert('Buku mungkin sudah ada di keranjang!')
  }
}

const handleSubmit = async () => {
  if (isSubmitting.value) return
  if (!userId.value) return router.push('/login')
  if (!password.value) return alert('Masukkan password untuk konfirmasi!')

  isSubmitting.value = true

  try {
    const res = await $fetch(`${config.public.apiBase}/peminjaman/full`, {
      method: 'POST',
      body: {
        id_user: Number(userId.value),
        tanggal_pinjam: tanggal_pinjam.value,
        id_buku: book.value.id_buku,
        stok: 1,
        password: password.value
      }
    })

    if (res.success) {
      tampilReservasi.value = false
      tampilPemberitahuan.value = true
      tanggal_pinjam.value = ''
      tanggal_hrs_kembali.value = ''
      password.value = ''

      // Refresh stock immediately after successful booking
      await fetchRealtimeStock()
    } else {
      alert(res.message || 'Gagal meminjam buku.')
    }
  } catch (err) {
    console.error(err)
    alert(err?.data?.message || 'Gagal meminjam buku. Silakan coba lagi.')
  } finally {
    isSubmitting.value = false
  }
}

function formatParagraf(teks) {
  if (!teks) return []

  if (teks.includes('\n')) {
    return teks.split('\n').filter(p => p.trim() !== '')
  }

  if (teks.includes('.')) {
    const kalimat = teks.split('.').filter(k => k.trim() !== '')
    const hasil = []
    const kalimatPerParagraf = 4

    for (let i = 0; i < kalimat.length; i += kalimatPerParagraf) {
      const paragraf = kalimat
        .slice(i, i + kalimatPerParagraf)
        .map(k => k.trim() + '.')
        .join(' ')

      if (paragraf.trim()) {
        hasil.push(paragraf)
      }
    }

    return hasil
  }

  const potong = 300
  const hasil = []
  let start = 0

  while (start < teks.length) {
    let end = start + potong

    if (end >= teks.length) {
      hasil.push(teks.slice(start).trim())
      break
    }

    let lastSpace = teks.lastIndexOf(' ', end)

    if (lastSpace <= start) {
      lastSpace = end
    }

    hasil.push(teks.slice(start, lastSpace).trim())
    start = lastSpace + 1
  }

  return hasil.filter(p => p !== '')
}

const getGenreClass = (genre) => {
  switch (genre) {
    // Umum
    case 'Fiksi':
      return 'bg-purple-100 text-purple-800'
    case 'Non-Fiksi':
      return 'bg-teal-100 text-teal-800'

    // Fiksi / Cerita
    case 'Romansa':
      return 'bg-pink-100 text-pink-800'
    case 'Misteri':
      return 'bg-indigo-100 text-indigo-800'
    case 'Thriller':
      return 'bg-red-100 text-red-800'
    case 'Kriminal / Detektif':
      return 'bg-gray-200 text-gray-800'
    case 'Petualangan':
      return 'bg-blue-100 text-blue-800'
    case 'Fantasi':
      return 'bg-violet-100 text-violet-800'
    case 'Fiksi Ilmiah':
      return 'bg-cyan-100 text-cyan-800'
    case 'Distopia':
      return 'bg-slate-200 text-slate-800'
    case 'Horor':
      return 'bg-black text-white'
    case 'Gotik':
      return 'bg-zinc-800 text-zinc-100'
    case 'Drama':
      return 'bg-yellow-100 text-yellow-800'
    case 'Komedi / Humor':
      return 'bg-green-100 text-green-800'
    case 'Satire / Parodi':
      return 'bg-orange-100 text-orange-800'
    case 'Fiksi Sejarah':
      return 'bg-amber-100 text-amber-800'
    case 'Realistis / Slice of Life':
      return 'bg-lime-100 text-lime-800'
    case 'Remaja (Young Adult)':
      return 'bg-fuchsia-100 text-fuchsia-800'
    case 'Fiksi Anak':
      return 'bg-rose-100 text-rose-800'
    case 'Kumpulan Cerpen':
      return 'bg-emerald-100 text-emerald-800'
    case 'Puisi':
      return 'bg-sky-100 text-sky-800'
    case 'Sastra Klasik':
      return 'bg-stone-200 text-stone-800'
    case 'Sastra Kontemporer':
      return 'bg-neutral-100 text-neutral-800'
    case 'Epik / Saga / Mitologi':
      return 'bg-indigo-200 text-indigo-900'
    case 'Cerita Rakyat / Dongeng':
      return 'bg-cyan-200 text-cyan-900'

    // Non-Fiksi
    case 'Biografi':
      return 'bg-blue-200 text-blue-900'
    case 'Autobiografi':
      return 'bg-blue-300 text-blue-900'
    case 'Memoar':
      return 'bg-blue-100 text-blue-800'
    case 'Sejarah':
      return 'bg-amber-200 text-amber-900'
    case 'Pengembangan Diri':
      return 'bg-green-200 text-green-900'
    case 'Pendidikan':
      return 'bg-teal-200 text-teal-900'
    case 'Agama':
      return 'bg-yellow-200 text-yellow-900'
    case 'Filsafat':
      return 'bg-gray-300 text-gray-900'
    case 'Psikologi':
      return 'bg-pink-200 text-pink-900'
    case 'Sosiologi':
      return 'bg-lime-200 text-lime-900'
    case 'Politik':
      return 'bg-red-200 text-red-900'
    case 'Ekonomi':
      return 'bg-green-300 text-green-900'
    case 'Bisnis & Manajemen':
      return 'bg-emerald-200 text-emerald-900'
    case 'Ilmu Pengetahuan':
      return 'bg-sky-200 text-sky-900'
    case 'Teknologi':
      return 'bg-indigo-300 text-indigo-900'
    case 'Kesehatan & Kedokteran':
      return 'bg-rose-200 text-rose-900'
    case 'Memasak / Kuliner':
      return 'bg-orange-200 text-orange-900'
    case 'Perjalanan / Wisata':
      return 'bg-cyan-300 text-cyan-900'
    case 'Seni':
      return 'bg-purple-200 text-purple-900'
    case 'Desain':
      return 'bg-violet-200 text-violet-900'
    case 'Fotografi':
      return 'bg-zinc-200 text-zinc-900'
    case 'Musik':
      return 'bg-fuchsia-200 text-fuchsia-900'
    case 'Olahraga':
      return 'bg-lime-300 text-lime-900'
    case 'Lingkungan':
      return 'bg-green-400 text-green-900'
    case 'Parenting / Keluarga':
      return 'bg-pink-300 text-pink-900'
    case 'Budaya & Antropologi':
      return 'bg-stone-300 text-stone-900'

    default:
      return 'bg-gray-100 text-gray-800'
  }
}

</script>