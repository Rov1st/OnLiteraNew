<template>
  <div class="min-h-screen w-full overflow-x-hidden">
    <!-- HEADER -->
    <header class="flex items-center justify-between w-full h-16 border-b border-gray-200 px-4 sm:px-6 bg-white">
      <!-- Left icons -->
      <div class="flex items-center space-x-4">
        <NuxtLink to="/search">
          <button
            class="flex items-center gap-1 px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm cursor-pointer">
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
        </NuxtLink>
      </div>

      <!-- Search -->
      <div class="flex-1 max-w-xs sm:max-w-md mx-2">
        <input
          type="text"
          placeholder="Search books..."
          v-model="search"
          @keyup.enter="goToSearch"
          class="w-full border border-gray-400 rounded-lg h-10 px-3
                 focus:border-gray-600 focus:ring focus:ring-blue-200 
                 outline-none transition"
        />
      </div>

      <!-- Right icons -->
      <div class="flex items-center space-x-4">
        <NuxtLink to="/favorited" class="w-8 h-8">
          <HeartIcon v-if="auth.user" class="w-8 text-red-500" />
        </NuxtLink>
        <NuxtLink to="/keranjang" class="w-8 h-8">
          <ShoppingCartIcon v-if="auth.user" class="w-8 text-black" />
        </NuxtLink>
      </div>
    </header>

    <!-- HERO SLIDER -->
    <section class="relative w-full h-[250px] sm:h-[400px] flex items-center justify-center">
      <div v-for="(slide, index) in slides" :key="index"
        class="absolute inset-0 transition-opacity duration-700 flex items-center justify-center pt-4 pb-2" :class="{
          'opacity-100': currentSlide === index + 1,
          'opacity-0': currentSlide !== index + 1,
        }">
        <div class="w-[90%] sm:w-[80%] h-full rounded-xl overflow-hidden">
          <img :src="slide" alt="" class="w-full h-full object-cover" />
        </div>
      </div>

      <button @click="prevSlide"
        class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 text-white text-2xl sm:text-3xl font-bold z-10">
        ‹
      </button>
      <button @click="nextSlide"
        class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 text-white text-2xl sm:text-3xl font-bold z-10">
        ›
      </button>
    </section>

    <!-- TOP 5 by Category -->
    <section class="px-4 mt-8">
      <h1 class="text-2xl sm:text-3xl font-bold mb-4">Top 5</h1>
      <div
        class="flex gap-4 overflow-x-auto scrollbar-hide sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 sm:gap-6">
        <div v-for="(category, cIndex) in categories" :key="cIndex" class="flex-shrink-0 w-56 sm:w-auto flex flex-col">
          <label class="text-lg sm:text-xl font-semibold mb-2">
            {{ category.name }}
          </label>

          <div v-for="(book, bIndex) in category.books" :key="book.id_buku" class="flex items-start pb-3">
            <NuxtLink :to="`/vbook?id=${book.id_buku}`" class="flex items-start">
              <img :src="`${config.public.laravelBase}/bukuofflineimg/${book.img}`" alt="logo"
                class="w-16 h-24 rounded object-cover" />
              <div class="flex flex-col pl-2">
                <p class="text-base sm:text-lg font-medium truncate">
                  {{ book.judul }}
                </p>
                <p class="text-sm text-gray-600 truncate">
                  {{ book.penulis }}
                </p>
              </div>
            </NuxtLink>
          </div>
        </div>
      </div>
    </section>

    <!-- RECOMMENDATION GRID -->
    <section class="px-4 py-8 bg-gray-50">
      <h1 class="text-2xl sm:text-3xl font-bold mb-6">Recommendation</h1>

      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
        <NuxtLink :to="`/vbook?id=${book.id_buku}`" v-for="(book, index) in paginatedBooks" :key="book.id_buku"
          class="bg-white rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-1 active:scale-95 overflow-hidden">
          <div class="aspect-[3/4] bg-gray-200">
            <img v-if="book.img" :src="`${config.public.laravelBase}/bukuofflineimg/${book.img}`" :alt="book.judul"
              class="w-full h-full object-cover" />
          </div>
          <div class="p-3">
            <h2 class="text-sm font-semibold truncate">{{ book.judul }}</h2>
            <p class="text-xs text-gray-500 truncate">{{ book.penulis }}</p>
          </div>
        </NuxtLink>
      </div>
      <!-- Pagination Controls -->
      <div class="flex justify-center gap-4 mt-6">
        <button @click="prevPage" :disabled="currentPage === 1"
          class="px-3 sm:px-4 py-2 bg-gray-200 rounded disabled:opacity-50">
          Prev
        </button>
        <span class="text-sm sm:text-base">Page {{ currentPage }} / {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages"
          class="px-3 sm:px-4 py-2 bg-gray-200 rounded disabled:opacity-50">
          Next
        </button>
      </div>
    </section>
  </div>
</template>

<script setup>
import { HeartIcon, ShoppingCartIcon } from "@heroicons/vue/24/solid";
import { useAuthStore } from "@/stores/auth";
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import { useRouter } from "vue-router";

const auth = useAuthStore();
const config = useRuntimeConfig();
const search = ref("");
const router = useRouter();

// fungsi redirect ke search page
const goToSearch = () => {
  if (!search.value.trim()) return;
  router.push({ path: "/search", query: { bookname: search.value } });
};

// HERO SLIDER
const currentSlide = ref(1);
const timer = ref(null);
const slides = ref([
  "/images/waguri2.png",
  "/images/waguri1.png",
  "/images/waguri3.png",
]);

// Fetch Buku
const { data: books } = await useFetch(`${config.public.apiBase}/book`);

// Kategori (Top 5)
const categoryNames = ["Novel", "Komik", "Pelajaran", "Sejarah", "Filsafat"];
const categories = computed(() => {
  if (!books.value) return [];
  return categoryNames.map((name) => {
    const filtered = books.value.filter(
      (book) => book.kategori?.toLowerCase() === name.toLowerCase()
    );
    const sorted = [...filtered].sort((a, b) => b.counter - a.counter);
    return { name, books: sorted.slice(0, 5) };
  });
});

// Recommendation Pagination
const currentPage = ref(1);
const itemsPerPage = ref(10);
const books2 = computed(() => books.value || []);
const totalPages = computed(
  () => Math.ceil(books2.value.length / itemsPerPage.value) || 1
);
const paginatedBooks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return books2.value.slice(start, start + itemsPerPage.value);
});

// Slider methods
const totalSlides = computed(() => slides.value.length);
const nextSlide = () => {
  currentSlide.value =
    currentSlide.value === totalSlides.value ? 1 : currentSlide.value + 1;
};
const prevSlide = () => {
  currentSlide.value =
    currentSlide.value === 1 ? totalSlides.value : currentSlide.value - 1;
};
const startAutoSlide = () => {
  timer.value = setInterval(nextSlide, 5000);
};

// Pagination methods
const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};
const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

// Update items per page
const updateItemsPerPage = () => {
  if (typeof window === "undefined") return;
  const w = window.innerWidth;
  if (w >= 1024) itemsPerPage.value = 10;
  else if (w >= 768) itemsPerPage.value = 8;
  else if (w >= 640) itemsPerPage.value = 6;
  else itemsPerPage.value = 4;

  if (currentPage.value > totalPages.value) {
    currentPage.value = totalPages.value;
  }
};

// Lifecycle
onMounted(() => {
  startAutoSlide();
  updateItemsPerPage();
  if (typeof window !== "undefined") {
    window.addEventListener("resize", updateItemsPerPage);
  }
});
onBeforeUnmount(() => {
  if (timer.value) clearInterval(timer.value);
  if (typeof window !== "undefined") {
    window.removeEventListener("resize", updateItemsPerPage);
  }
});
</script>

<style scoped>
.opacity-100 {
  opacity: 1;
}

.opacity-0 {
  opacity: 0;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
