<template>
  <div class="p-5">
    <h1 class="text-3xl font-semibold">Buku Favorit</h1>

    <div class="p-5">
      <div v-if="paginatedBooks.length > 0" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
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


      <!-- Kalau kosong -->
      <p v-else class="text-gray-500 text-center mt-10">
        Belum ada buku favorit.
      </p>

      <!-- Pagination -->
      <div class="flex justify-center gap-4 mt-6" v-if="totalPages > 1">
        <button @click="prevPage" :disabled="currentPage === 1"
          class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50">
          Prev
        </button>
        <span class="text-sm">Page {{ currentPage }} / {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages"
          class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50">
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();
const config = useRuntimeConfig();

definePageMeta({
  middleware: "auth",
});

const userId = ref(null);
const books = ref([]);

// Pagination state
const currentPage = ref(1);
const itemsPerPage = ref(10);

// Ambil buku favorit
onMounted(async () => {
  if (!process.client) return;

  userId.value = localStorage.getItem("user_id");
  if (!userId.value) return;

  try {
    const favorites = await $fetch(
      `${config.public.apiBase}/favorit/${userId.value}`
    );

    if (!Array.isArray(favorites) || favorites.length === 0) {
      books.value = [];
      return;
    }

    // Ambil langsung relasi buku
    books.value = favorites
      .filter(fav => fav.buku) // pastikan ada relasi buku
      .map(fav => fav.buku);
  } catch (err) {
    console.error("Gagal ambil buku favorit:", err);
    books.value = [];
  }
});

// Pagination computed
const totalPages = computed(() =>
  Math.ceil(books.value.length / itemsPerPage.value) || 1
);

const paginatedBooks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return books.value.slice(start, start + itemsPerPage.value);
});

// Pagination actions
const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};
</script>
