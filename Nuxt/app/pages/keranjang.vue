<template>
  <div class="grid grid-cols-1 md:grid-cols-3 p-2 md:p-8 items-start gap-4">
    <!-- Bagian kiri: Daftar buku di keranjang -->
    <div class="md:col-span-2 border-2 border-gray-300 mx-2 md:m-10 rounded-md shadow-lg h-auto">

      <div v-for="(book, index) in books" :key="index"
           class="flex flex-col sm:flex-row m-2 md:m-4 border-2 border-gray-100 rounded-lg overflow-hidden shadow-md"
           :class="book.stok === 0 ? 'opacity-40 bg-gray-200' : ''">

        <img :src="`${config.public.laravelBase}/bukuofflineimg/${book.img}`" alt="cover"
             class="h-32 sm:h-40 w-full sm:w-24 md:w-30 object-cover"/>

        <div class="flex flex-col p-2 sm:ml-2 md:ml-4 flex-1">
          <div class="flex justify-between items-start">
            <h1 class="text-lg sm:text-xl md:text-2xl font-bold break-words flex-1 pr-2">{{ book.judul }}</h1>
            <button class="w-6 h-6 sm:w-7 sm:h-7 p-1 cursor-pointer shrink-0"
                    @click="confirmDelete(index)" :disabled="isSubmitting">
              <TrashIcon class="w-full h-full text-red-500"/>
            </button>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 mt-2 gap-2 md:gap-4 w-full">
            <div class="flex space-x-2 text-sm sm:text-base md:text-lg font-semibold">
              <div class="space-y-1">
                <p>Penulis</p>
                <p>Penerbit</p>
              </div>
              <div class="space-y-1">
                <p>:</p>
                <p>:</p>
              </div>
              <div class="space-y-1 break-words">
                <p>{{ book.penulis }}</p>
                <p>{{ book.penerbit }}</p>
              </div>
            </div>

            <div class="flex space-x-2 text-sm sm:text-base md:text-lg font-semibold">
              <div class="space-y-1">
                <p>Tahun rilis</p>
                <p>Tahun terbit</p>
              </div>
              <div class="space-y-1">
                <p>:</p>
                <p>:</p>
              </div>
              <div class="space-y-1">
                <p>{{ book.tahun_rilis }}</p>
                <p>{{ book.tahun_terbit }}</p>
              </div>
            </div>
          </div>

          <div v-if="book.stok > 0" class="flex flex-col sm:flex-row w-full justify-between items-start sm:items-center mt-2 gap-2">
            <div class="text-sm sm:text-base md:text-lg font-semibold">Stok: {{ book.stok }}</div>
            <div class="flex">
              <button class="bg-gray-100 w-7 h-7 sm:w-8 sm:h-8 rounded-l-lg font-semibold text-sm"
                      @click="decrease(index)" :disabled="isSubmitting">-</button>
              <div class="w-10 sm:w-12 h-7 sm:h-8 border border-gray-200 flex items-center justify-center">
                <input type="number" v-model="book.stock" min="1" @input="cekStock(index)"
                       :disabled="isSubmitting"
                       class="w-full h-full text-center text-xs sm:text-sm focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"/>
              </div>
              <button class="bg-gray-100 w-7 h-7 sm:w-8 sm:h-8 rounded-r-lg font-semibold text-sm"
                      @click="increase(index)" :disabled="isSubmitting">+</button>
            </div>
          </div>

          <div v-else class="text-red-600 font-bold mt-2 text-sm sm:text-base">
            Buku sedang habis
          </div>
        </div>
      </div>
    </div>

    <!-- Bagian kanan -->
    <div class="md:col-span-1 border-2 border-gray-300 mx-2 md:mx-0 rounded-md shadow-lg h-auto">
      <div v-for="(book) in books.filter(b => b.stok > 0)" :key="book.id_buku"
           class="flex flex-col m-2 border-2 border-gray-100 rounded-sm overflow-hidden shadow-sm p-2">
        <div class="flex flex-row w-full justify-between overflow-hidden">
          <h1 class="text-sm sm:text-base font-medium break-words flex-1 pr-2">{{ book.judul }}</h1>
          <p class="text-gray-500 text-sm sm:text-base shrink-0">{{ book.stock }}x</p>
        </div>
        <p class="text-gray-600 text-xs sm:text-sm break-words">{{ book.penulis }}</p>
      </div>

      <h1 class="mx-2 md:mx-4 font-semibold text-sm sm:text-base">Tanggal pinjam</h1>

      <div class="p-2 md:px-5 w-full">
        <form @submit.prevent="handleSubmit" class="w-full">
          <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-2">
            <div class="flex items-center w-full sm:w-auto">
              <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" v-model="tanggal_pinjam"
                     :min="today"
                     :disabled="isSubmitting"
                     class="h-8 sm:h-10 px-2 sm:px-3 rounded-lg border border-slate-300 text-xs sm:text-sm w-full sm:w-auto" required/>
            </div>
            <div class="hidden sm:block">-</div>
            <div class="flex items-center w-full sm:w-auto">
              <input type="text" id="tanggal_hrs" name="tanggal_hrs_kembali" v-model="tanggal_hrs_kembali"
                     class="h-8 sm:h-10 px-2 sm:px-3 rounded-lg border border-slate-300 text-xs sm:text-sm w-full sm:w-32 md:w-40 bg-gray-50" placeholder="dd/mm/yyyy" disabled/>
            </div>
          </div>
          <h1 class="my-2 font-semibold text-sm sm:text-base">Konfirmasi</h1>
          <div class="flex items-center">
            <input type="password" id="password" name="password" v-model="password"
                   :disabled="isSubmitting"
                   class="h-8 sm:h-10 px-2 sm:px-3 rounded-lg border border-slate-300 text-xs sm:text-sm w-full" placeholder="Password" required/>
          </div>

          <div class="w-full my-3 sm:my-4">
            <button type="submit"
                    :disabled="isSubmitting"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition w-full text-sm sm:text-base disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center min-h-[40px]">
              <span v-if="!isSubmitting">Confirm</span>
              <span v-else class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
              </span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Popup Konfirmasi Hapus -->
    <div v-if="tampilHapus" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4"
         @click.self="tutupHapus">
      <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg w-full max-w-sm sm:max-w-md relative">
        <button @click="tutupHapus" type="button"
                class="absolute top-3 right-3 sm:top-4 sm:right-4 text-gray-500 hover:text-black">
          <XMarkIcon class="w-5 h-5 sm:w-6 sm:h-6"/>
        </button>
        <h1 class="font-semibold text-base sm:text-lg text-center p-2 break-words">
          Hapus buku "{{ bookToDelete.judul }}" dari keranjang?
        </h1>
        <div class="p-1 flex">
          <button @click="hapusKeranjang" type="button"
                  class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition cursor-pointer text-sm sm:text-base">
            Hapus
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Success -->
    <div v-if="tampilSuccess" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4"
      @click.self="tutupSuccess">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
        <button @click="tutupSuccess" type="button" 
          class="absolute top-4 right-4 text-gray-500 hover:text-black">
          <XMarkIcon class="w-6 h-6" />
        </button>
        <h1 class="font-semibold text-base md:text-lg text-center p-2">
          Peminjaman berhasil, Mohon ditunggu <span class="text-blue-400">konfirmasinya</span>!
        </h1>
        <div class="p-1 flex mt-4">
          <button @click="tutupSuccess"
            class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm md:text-base">
            OK
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { TrashIcon, XMarkIcon } from "@heroicons/vue/24/solid";

const config = useRuntimeConfig();
const books = ref([]);
const userId = ref(null);

// Stock & tanggal
const tanggal_pinjam = ref("");
const tanggal_hrs_kembali = ref("");
const password = ref("");

// Loading state
const isSubmitting = ref(false);

// Popup hapus
const tampilHapus = ref(false);
const bookToDelete = ref({ index: null, judul: "" });
const confirmDelete = (index) => {
  if (isSubmitting.value) return;
  bookToDelete.value = { index, judul: books.value[index].judul };
  tampilHapus.value = true;
};
const tutupHapus = () => { tampilHapus.value = false; };

// Popup success
const tampilSuccess = ref(false);
const tutupSuccess = () => { 
  tampilSuccess.value = false;
  // Reset form
  tanggal_pinjam.value = "";
  tanggal_hrs_kembali.value = "";
  password.value = "";
};

// Fungsi hapus buku
const hapusKeranjang = async () => {
  if (bookToDelete.value.index === null) return;
  const book = books.value[bookToDelete.value.index];
  try {
    await $fetch(`${config.public.apiBase}/keranjang/${userId.value}/${book.id_buku}`, { method: "GET" });
    books.value.splice(bookToDelete.value.index, 1);
    tutupHapus();
  } catch (err) {
    console.error("Gagal hapus buku:", err);
  }
  bookToDelete.value = { index: null, judul: "" };
};

// Ambil data user dan keranjang
onMounted(async () => {
  if (!process.client) return;
  userId.value = localStorage.getItem("user_id");
  if (!userId.value) return;

  try {
    const keranjang = await $fetch(`${config.public.apiBase}/keranjang/${userId.value}`);
    const detailPromises = keranjang.map(async (item) => {
      const buku = await $fetch(`${config.public.apiBase}/book/${item.id_buku}`);
      return { ...buku, stock: item.stok || 1, id_keranjang: item.id_keranjang };
    });
    books.value = await Promise.all(detailPromises);
  } catch (err) {
    console.error("Gagal ambil keranjang:", err);
  }
});

// ==== Stock functions ====
function increase(index) { 
  if (isSubmitting.value) return;
  books.value[index].stock++; 
}
function decrease(index) { 
  if (isSubmitting.value) return;
  if (books.value[index].stock > 1) books.value[index].stock--; 
}
function cekStock(index) { 
  if (!books.value[index].stock || books.value[index].stock < 1) books.value[index].stock = 1; 
}

// ==== Tanggal pinjam ====
function formatTanggal(tgl) {
  const dd = String(tgl.getDate()).padStart(2, "0");
  const mm = String(tgl.getMonth() + 1).padStart(2, "0");
  const yyyy = tgl.getFullYear();
  return `${dd}/${mm}/${yyyy}`;
}
watch(tanggal_pinjam, (newVal) => {
  if (newVal) {
    let tgl = new Date(newVal);
    tgl.setDate(tgl.getDate() + 5);
    tanggal_hrs_kembali.value = formatTanggal(tgl);
  } else {
    tanggal_hrs_kembali.value = "";
  }
});

// ==== Submit peminjaman dengan loading ====
const handleSubmit = async () => {
  if (isSubmitting.value) return;

  const bukuTersedia = books.value.filter(b => b.stok > 0);
  if (!bukuTersedia.length) return alert("Keranjang kosong atau semua buku habis!");
  if (!tanggal_pinjam.value || !password.value) return alert("Tanggal pinjam dan password harus diisi!");

  isSubmitting.value = true;

  const payload = {
    id_user: userId.value,
    tanggal_pinjam: tanggal_pinjam.value,
    password: password.value,
    books: bukuTersedia.map(b => ({ id_buku: b.id_buku, stock: Number(b.stock) }))
  };

  try {
    const res = await $fetch(`${config.public.apiBase}/peminjaman/keranjang`, {
      method: "POST",
      body: payload
    });

    if (res.success) {
      // Kosongkan keranjang
      books.value = [];
      // Tampilkan modal success
      tampilSuccess.value = true;
    } else {
      alert("Gagal meminjam: " + (res.message || "Unknown error"));
    }
  } catch (err) {
    console.error("Error meminjam:", err);
    const message = err?.response?._data?.message || err?.data?.message || "Terjadi kesalahan!";
    alert(message);
  } finally {
    isSubmitting.value = false;
  }
};

const today = new Date().toISOString().split('T')[0]

definePageMeta({
  middleware: 'auth'
})
</script>