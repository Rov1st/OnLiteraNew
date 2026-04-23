<template>
  <div class="min-h-screen w-full overflow-x-hidden bg-gray-50">
    <!-- HEADER -->
    <header class="flex items-center justify-between w-full h-16 border-b border-gray-200 px-4 sm:px-6 bg-white">
      <!-- Left icons -->
      <div class="flex items-center space-x-4">
        <button @click="toggleFilter"
          class="flex items-center gap-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
              clip-rule="evenodd" />
          </svg>
          <span class="hidden sm:inline">Filter</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform"
            :class="{ 'rotate-180': isFilterOpen }" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
        </button>
      </div>

      <!-- Search -->
      <div class="flex-1 max-w-xs sm:max-w-md mx-2">
        <input type="text" placeholder="Search"
          class="w-full border border-gray-400 rounded-lg h-10 px-3 focus:border-gray-600 focus:ring focus:ring-blue-200 outline-none transition"
          v-model="search" @input="updateQuery" />
      </div>

      <!-- Right icons -->
      <div class="flex items-center space-x-4">
        <a href="favorited" class="w-8 h-8">
          <HeartIcon v-if="auth.user" class="w-8 text-red-500" />
        </a>
        <a href="keranjang" class="w-8 h-8">
          <ShoppingCartIcon v-if="auth.user" class="w-8 text-black" />
        </a>
      </div>
    </header>

    <!-- FILTER SLIDE DOWN MENU -->
    <transition name="slide-fade">
      <div v-if="isFilterOpen" class="bg-white border-b border-gray-200 shadow-md">
        <div class="px-4 sm:px-6 py-4 max-w-6xl mx-auto">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- GENRE FILTER (Multi-select) -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Genre</label>
              <input type="text" v-model="searchGenre" placeholder="Cari genre..."
                class="w-full border border-gray-300 rounded-lg h-9 px-3 mb-2 text-sm focus:border-blue-600 focus:ring focus:ring-blue-200 outline-none transition" />
              <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-2 bg-gray-50">
                <div v-if="uniqueGenres.length === 0" class="text-sm text-gray-500 text-center py-2">
                  Tidak ada genre ditemukan
                </div>
                <div v-for="genre in uniqueGenres" :key="genre" class="flex items-center mb-2">
                  <input type="checkbox" :id="`genre-${genre}`" :value="genre" v-model="selectedGenres"
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                  <label :for="`genre-${genre}`" class="ml-2 text-sm text-gray-700 cursor-pointer">
                    {{ genre }}
                  </label>
                </div>
              </div>
            </div>

            <!-- KATEGORI FILTER -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
              <input type="text" v-model="searchKategori" placeholder="Cari kategori..."
                class="w-full border border-gray-300 rounded-lg h-9 px-3 mb-2 text-sm focus:border-blue-600 focus:ring focus:ring-blue-200 outline-none transition" />
              <select v-model="selectedKategori" size="6"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-600 focus:ring focus:ring-blue-200 outline-none transition bg-white">
                <option value="">Semua Kategori</option>
                <option v-for="kategori in uniqueKategoris" :key="kategori" :value="kategori"
                  class="py-1">
                  {{ kategori }}
                </option>
              </select>
              <div v-if="uniqueKategoris.length === 0 && searchKategori" class="text-sm text-gray-500 text-center py-2 border border-gray-300 rounded-lg mt-2">
                Tidak ada kategori ditemukan
              </div>
            </div>

            <!-- PENULIS FILTER -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Penulis</label>
              <input type="text" v-model="searchPenulis" placeholder="Cari penulis..."
                class="w-full border border-gray-300 rounded-lg h-9 px-3 mb-2 text-sm focus:border-blue-600 focus:ring focus:ring-blue-200 outline-none transition" />
              <select v-model="selectedPenulis" size="6"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-blue-600 focus:ring focus:ring-blue-200 outline-none transition bg-white">
                <option value="">Semua Penulis</option>
                <option v-for="penulis in uniquePenulis" :key="penulis" :value="penulis"
                  class="py-1">
                  {{ penulis }}
                </option>
              </select>
              <div v-if="uniquePenulis.length === 0 && searchPenulis" class="text-sm text-gray-500 text-center py-2 border border-gray-300 rounded-lg mt-2">
                Tidak ada penulis ditemukan
              </div>
            </div>

          </div>

          <!-- RESET BUTTON -->
          <div class="mt-4 flex justify-end">
            <button @click="resetFilters"
              class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
              Reset Filter
            </button>
          </div>
        </div>
      </div>
    </transition>

    <!-- LOADING / ERROR -->
    <div v-if="pending" class="flex justify-center items-center h-40">
      <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
      </svg>
    </div>
    <div v-if="error" class="text-center mt-10 text-red-500">
      Gagal mengambil data buku
    </div>

    <!-- BOOKS GRID -->
    <main class="p-5" v-if="!pending && !error">
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
        <a :href="`/vbook?id=${book.id_buku}`" v-for="(book, index) in paginatedBooks" :key="book.id_buku"
          class="bg-white rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-1 active:scale-95 overflow-hidden">
          <div class="aspect-[3/4] bg-gray-200">
            <img v-if="book.img" :src="`${config.public.laravelBase}/bukuofflineimg/${book.img}`" :alt="book.judul"
              class="w-full h-full object-cover" />
          </div>
          <div class="p-3">
            <h2 class="text-sm font-semibold truncate">{{ book.judul }}</h2>
            <p class="text-xs text-gray-500 truncate">{{ book.penulis }}</p>
          </div>
        </a>
      </div>

      <!-- NO RESULTS -->
      <div v-if="paginatedBooks.length === 0" class="text-center mt-10 text-gray-500">
        Tidak ada buku yang sesuai dengan filter
      </div>

      <!-- PAGINATION -->
      <div v-if="paginatedBooks.length > 0" class="flex justify-center gap-4 mt-6">
        <button @click="prevPage" :disabled="currentPage === 1"
          class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 hover:bg-gray-300 transition">
          Prev
        </button>
        <span class="text-sm">Page {{ currentPage }} / {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages"
          class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50 hover:bg-gray-300 transition">
          Next
        </button>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from "vue"
import { useRoute, useRouter, useRuntimeConfig } from "#app"
import { HeartIcon, ShoppingCartIcon } from "@heroicons/vue/24/solid"
import { useAuthStore } from "@/stores/auth"

const auth = useAuthStore()
const route = useRoute()
const router = useRouter()
const config = useRuntimeConfig()

// STATE
const currentPage = ref(1)
const itemsPerPage = ref(10)
const search = ref(route.query.bookname || "")
const isFilterOpen = ref(false)

// FILTER STATE
const selectedGenres = ref([])
const selectedKategori = ref("")
const selectedPenulis = ref("")

// SEARCH FILTER STATE
const searchGenre = ref("")
const searchKategori = ref("")
const searchPenulis = ref("")

// TOGGLE FILTER
const toggleFilter = () => {
  isFilterOpen.value = !isFilterOpen.value
}

// FETCH DATA
const { data: books, pending, error } = await useFetch(`${config.public.apiBase}/book`)

watchEffect(() => {
  if (books.value) {
    books.value.sort((a, b) => b.counter - a.counter);
  }
});

// EXTRACT UNIQUE VALUES FROM DATABASE
const allGenres = computed(() => {
  if (!books.value) return []
  const genres = new Set()
  
  books.value.forEach(book => {
    if (book.genres && Array.isArray(book.genres)) {
      book.genres.forEach(genreObj => {
        const genreName = genreObj.nama_genre || genreObj.genre || genreObj.name
        if (genreName && genreName.trim()) {
          genres.add(genreName.trim())
        }
      })
    }
  })
  
  return Array.from(genres).sort()
})

const allKategoris = computed(() => {
  if (!books.value) return []
  const kategoris = new Set()
  books.value.forEach(book => {
    if (book.kategori && book.kategori.trim()) {
      kategoris.add(book.kategori.trim())
    }
  })
  return Array.from(kategoris).sort()
})

const allPenulis = computed(() => {
  if (!books.value) return []
  const penulis = new Set()
  books.value.forEach(book => {
    if (book.penulis && book.penulis.trim()) {
      penulis.add(book.penulis.trim())
    }
  })
  return Array.from(penulis).sort()
})

// FILTERED OPTIONS (with search)
const uniqueGenres = computed(() => {
  if (!searchGenre.value) return allGenres.value
  const search = searchGenre.value.toLowerCase()
  return allGenres.value.filter(genre => genre.toLowerCase().includes(search))
})

const uniqueKategoris = computed(() => {
  if (!searchKategori.value) return allKategoris.value
  const search = searchKategori.value.toLowerCase()
  return allKategoris.value.filter(kategori => kategori.toLowerCase().includes(search))
})

const uniquePenulis = computed(() => {
  if (!searchPenulis.value) return allPenulis.value
  const search = searchPenulis.value.toLowerCase()
  return allPenulis.value.filter(penulis => penulis.toLowerCase().includes(search))
})

// SEARCH QUERY
const updateQuery = () => {
  router.replace({ query: { bookname: search.value } })
  currentPage.value = 1
}

watch(
  () => route.query.bookname,
  (newVal) => {
    search.value = newVal || ""
    currentPage.value = 1
  }
)

// FILTERED BOOKS
const filteredBooks = computed(() => {
  if (!books.value) return []
  
  let result = books.value

  // Filter by search
  if (search.value) {
    const q = search.value.toLowerCase()
    result = result.filter(
      (book) =>
        book.judul.toLowerCase().includes(q) ||
        book.penulis.toLowerCase().includes(q)
    )
  }

  // Filter by genre (multi-select)
  if (selectedGenres.value.length > 0) {
    result = result.filter(book => {
      if (!book.genres || !Array.isArray(book.genres)) return false
      
      // Cek apakah ada genre dari book yang cocok dengan selected genres
      return book.genres.some(genreObj => {
        const genreName = genreObj.nama_genre || genreObj.genre || genreObj.name
        return genreName && selectedGenres.value.includes(genreName.trim())
      })
    })
  }

  // Filter by kategori
  if (selectedKategori.value) {
    result = result.filter(book => 
      book.kategori && book.kategori.trim() === selectedKategori.value
    )
  }

  // Filter by penulis
  if (selectedPenulis.value) {
    result = result.filter(book => 
      book.penulis && book.penulis.trim() === selectedPenulis.value
    )
  }

  return result
})

// RESET FILTERS
const resetFilters = () => {
  selectedGenres.value = []
  selectedKategori.value = ""
  selectedPenulis.value = ""
  searchGenre.value = ""
  searchKategori.value = ""
  searchPenulis.value = ""
  currentPage.value = 1
}

// Watch filters to reset pagination
watch([selectedGenres, selectedKategori, selectedPenulis], () => {
  currentPage.value = 1
})

// PAGINATION
const totalPages = computed(
  () => Math.ceil(filteredBooks.value.length / itemsPerPage.value) || 1
)

const paginatedBooks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  return filteredBooks.value.slice(start, start + itemsPerPage.value)
})

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++
}
const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--
}

// RESPONSIVE ITEMS PER PAGE
const updateItemsPerPage = () => {
  if (typeof window === "undefined") return
  const w = window.innerWidth
  if (w >= 1024) itemsPerPage.value = 10
  else if (w >= 768) itemsPerPage.value = 8
  else if (w >= 640) itemsPerPage.value = 6
  else itemsPerPage.value = 4

  if (currentPage.value > totalPages.value) currentPage.value = totalPages.value
}

onMounted(() => {
  updateItemsPerPage()
  window.addEventListener("resize", updateItemsPerPage)
})
onBeforeUnmount(() => {
  window.removeEventListener("resize", updateItemsPerPage)
})
</script>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>