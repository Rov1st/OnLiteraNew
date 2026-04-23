<template>
    <div>
        <div class="w-full h-[300px] md:h-[400px] relative shadow-lg">
            <div class="absolute inset-0 transition-opacity duration-700"
                :class="{ 'opacity-100': currentSlide === 1, 'opacity-0': currentSlide !== 1 }">
                <img src="/images/img1.jpg" alt="Slide 1" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 transition-opacity duration-700"
                :class="{ 'opacity-100': currentSlide === 2, 'opacity-0': currentSlide !== 2 }">
                <img src="/images/img2.jpg" alt="Slide 2" class="w-full h-full object-cover">
            </div>

            <button @click="prevSlide"
                class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white text-xl md:text-2xl font-bold w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center z-10 transition-all">
                ←
            </button>
            <button @click="nextSlide"
                class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white text-xl md:text-2xl font-bold w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center z-10 transition-all">
                →
            </button>
        </div>

        <div class="w-full font-mono">
            <div class="mx-4 md:mx-16 mt-5 mb-10 bg-white" id="popular-book">
                <h1 class="text-4xl md:text-6xl mb-5">Popular</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="card">
                    <a :href="`/vbook?id=${book.id_buku}`" v-for="book, index in books.slice(0, 5)" :key="book.id_buku"
                        class="group w-full rounded shadow-lg bg-[#deedfa] overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="w-full h-64 overflow-hidden">
                            <img class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                :src="`${config.public.laravelBase}/bukuofflineimg/${book.img}`" alt="Gambar">
                        </div>
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ book.judul }}</div>
                            <p class="text-gray-700 text-base">
                                {{ book.penjelasan.slice(0, 100) }}{{ book.penjelasan.length > 100 ? '...' : '' }}
                            </p>
                        </div>
                        <div class="px-6 pt-4 pb-2">
                            <div class="flex flex-wrap gap-2">
                                <span v-for="genre in book.genres" :key="genre.id_buku"
                                    :class="getGenreClass(genre.genre)"
                                    class="rounded-full px-3 py-1 text-sm font-semibold">
                                    {{ genre.genre }}
                                </span>
                                <span class="bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700">
                                    #{{ index + 1 }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -top-4 left-0 w-full h-4 bg-gradient-to-b from-black/15 to-transparent z-10"></div>
                <div class="absolute -top-1 left-0 w-full h-1 bg-gradient-to-t from-black/10 to-transparent z-10"></div>

                <section class="bg-slate-400 pt-3 text-white relative z-0" id="aboutus">
                    <div class="mx-4 md:mx-16 pt-8 md:pt-15">
                        <h1 class="text-4xl md:text-6xl mb-8">About Us</h1>
                        <div class="flex flex-col md:flex-row gap-6 md:gap-8 my-10 md:my-20 p-4 md:p-10 items-center">
                            <div class="w-full md:w-2/3">
                                <h2 class="text-center text-3xl md:text-5xl mb-4">Visi</h2>
                                <p class="text-justify text-lg md:text-2xl lg:text-3xl pr-0 md:pr-10 leading-relaxed">
                                    Menjadi platform perpustakaan digital terdepan yang membuka akses literasi bagi semua
                                    orang, di mana saja dan kapan saja, serta membangun ekosistem membaca yang inklusif,
                                    inovatif, dan berkelanjutan. Kami berkomitmen untuk menjadikan teknologi sebagai
                                    jembatan bagi masyarakat dalam memperoleh pengetahuan, mendukung pertumbuhan
                                    intelektual generasi masa depan, dan memperkuat budaya literasi di era digital.
                                </p>
                            </div>
                            <div class="w-full md:w-1/3 mt-6 md:mt-0">
                                <img class="h-60 md:h-80 w-full object-cover rounded-lg" src="/images/sample.jpg" alt="">
                            </div>
                        </div>

                        <div class="my-10 md:my-15 px-4 md:px-10 py-6 md:py-10 text-white">
                            <h2 class="text-center text-3xl md:text-5xl font-bold mb-6 md:mb-10">Misi</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 md:gap-6 pb-6">
                                <div class="w-full text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 1"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Menyediakan akses mudah dan cepat ke ribuan buku dari berbagai genre.
                                    </p>
                                </div>

                                <div class="w-full text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 2"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Mendorong budaya membaca dengan pendekatan yang modern, inklusif, dan ramah usia.
                                    </p>
                                </div>

                                <div class="w-full text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 3"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Menghadirkan pengalaman membaca yang seru, nyaman, dan fleksibel untuk segala perangkat.
                                    </p>
                                </div>

                                <div class="w-full text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 4"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Menghubungkan pembaca dengan literatur berkualitas.
                                    </p>
                                </div>

                                <div class="w-full text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 5"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Menjadi ruang aman dan menyenangkan untuk tumbuh bersama melalui literasi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mx-4 md:mx-16 mt-10 md:mt-20 mb-10" id="developer">
                    <h1 class="text-4xl md:text-6xl mb-5">Developer</h1>
                    <div class="mt-6 md:mt-10 mx-2 md:mx-10 space-y-10 md:space-y-20" id="cardofdeveloper">
                        <div class="flex flex-col md:flex-row text-base md:text-lg lg:text-2xl text-justify">
                            <div class="w-full md:w-2/3 pr-0 md:pr-20 order-2 md:order-1">
                                <h2 class="text-2xl md:text-4xl mb-2 font-bold">FA'IQ HALUL DANENDRA</h2>
                                <p class="leading-relaxed">
                                    Pengembang yang berfokus pada pengembangan logika aplikasi dan pengelolaan basis
                                    data (database) yang aman, terstruktur, dan efisien. Membangun API dan layanan
                                    server yang andal, mengoptimalkan performa sistem, serta memastikan keamanan data
                                    pengguna. Berkomitmen menghadirkan solusi digital yang skalabel, mendukung integrasi
                                    antar sistem, dan membangun fondasi teknologi yang kuat serta berkelanjutan di era
                                    modern.
                                </p>
                            </div>
                            <div class="w-full md:w-1/3 flex items-center justify-center mb-6 md:mb-0 order-1 md:order-2">
                                <img class="w-40 h-40 md:w-60 md:h-60 object-cover rounded-full shadow-lg" src="/images/iq.jpg"
                                    alt="Foto Developer">
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row text-base md:text-lg lg:text-2xl text-justify">
                            <div class="w-full md:w-2/3 pr-0 md:pr-20 order-2 md:order-1">
                                <h2 class="text-2xl md:text-4xl mb-2 font-bold">Muhamad Firdaus Al Ghajali</h2>
                                <p class="leading-relaxed">
                                    Seorang Database Administrator sekaligus pengembang front-end bagian pengguna, yang
                                    berpengalaman dalam mengelola, mengoptimalkan, dan menjaga keamanan sistem basis
                                    data. Terampil membangun antarmuka pengguna yang intuitif dan ramah, memastikan data
                                    terintegrasi dengan baik antara tampilan dan sistem penyimpanan. Berkomitmen
                                    menghadirkan pengalaman pengguna yang lancar, serta menjaga keandalan dan kinerja
                                    basis data di setiap proyek.
                                </p>
                            </div>
                            <div class="w-full md:w-1/3 flex items-center justify-center mb-6 md:mb-0 order-1 md:order-2">
                                <img class="w-40 h-40 md:w-60 md:h-60 object-cover rounded-full shadow-lg" src="/images/us.jpg"
                                    alt="Foto Developer">
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row text-base md:text-lg lg:text-2xl text-justify">
                            <div class="w-full md:w-2/3 pr-0 md:pr-20 order-2 md:order-1">
                                <h2 class="text-2xl md:text-4xl mb-2 font-bold">Muhammad Billal Nurfildan</h2>
                                <p class="leading-relaxed">
                                    Seorang pengembang front-end admin yang berfokus pada pembuatan dan optimalisasi
                                    dashboard administrasi. Ahli dalam merancang tampilan yang responsif dan interaktif,
                                    serta mengintegrasikan data untuk menampilkan grafik peminjaman buku secara
                                    real-time. Memastikan setiap fitur admin berjalan fungsional, informatif, dan
                                    memudahkan pengelolaan data perpustakaan digital.
                                </p>
                            </div>
                            <div class="w-full md:w-1/3 flex items-center justify-center mb-6 md:mb-0 order-1 md:order-2">
                                <img class="w-40 h-40 md:w-60 md:h-60 object-cover rounded-full shadow-lg" src="/images/lal.jpg"
                                    alt="Foto Developer">
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mx-4 md:mx-16 mt-10 md:mt-20 mb-10" id="contactus">
                    <h1 class="text-4xl md:text-6xl mb-5">Contact Us</h1>
                    <div class="flex flex-col md:flex-row gap-6 md:gap-8 mx-0 md:mx-8">
                        <form @submit.prevent="submitForm"
                            class="bg-white text-black rounded-lg shadow-md p-6 md:p-10 space-y-4 md:space-y-6 w-full md:max-w-3xl">
                            <div>
                                <label for="name" class="block font-semibold text-lg mb-2">Nama</label>
                                <input type="text" id="name" v-model="form.name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                                    placeholder="Masukkan nama lengkap" />
                            </div>

                            <div>
                                <label for="email" class="block font-semibold text-lg mb-2">Email</label>
                                <input type="email" id="email" v-model="form.email" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                                    placeholder="contoh@email.com" />
                            </div>

                            <div>
                                <label for="subject" class="block font-semibold text-lg mb-2">Subjek</label>
                                <input type="text" id="subject" v-model="form.subject" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                                    placeholder="Topik pesan" />
                            </div>

                            <div>
                                <label for="message" class="block font-semibold text-lg mb-2">Pesan</label>
                                <textarea id="message" v-model="form.message" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
                                    placeholder="Tulis pesan Anda..."></textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded transition-colors duration-300"
                                    :disabled="loading">
                                    {{ loading ? 'Mengirim...' : 'Kirim Pesan' }}
                                </button>
                            </div>

                            <p v-if="successMessage" class="text-green-600 font-semibold">{{ successMessage }}</p>
                            <p v-if="errorMessage" class="text-red-600 font-semibold">{{ errorMessage }}</p>
                        </form>

                        <div class="bg-white text-black rounded-lg shadow-md p-6 md:p-10 space-y-4 md:space-y-6 w-full md:max-w-3xl text-base md:text-lg lg:text-xl">
                            <p>
                                Bagian <span class="font-bold">Contact Us</span> pada halaman ini disediakan khusus bagi Anda,
                                <span class="font-bold">pengguna perpustakaan digital</span>, yang ingin menyampaikan
                                <span class="font-bold">pertanyaan</span>, <span class="font-bold">saran</span>, atau
                                <span class="font-bold">kendala</span> selama menggunakan layanan kami. Untuk menghubungi kami,
                                silakan <span class="font-bold">isi formulir yang tersedia dengan lengkap</span>.
                            </p>

                            <p>
                                Pertama, masukkan <span class="font-bold">nama lengkap</span> Anda agar kami mengetahui
                                siapa yang mengirim pesan. Selanjutnya, tuliskan <span class="font-bold">alamat email yang masih aktif</span>,
                                karena semua <span class="font-bold">balasan dari kami akan dikirimkan ke email tersebut</span>. Pada kolom
                                <span class="font-bold">Subjek</span>, tuliskan <span class="font-bold">inti dari pesan Anda</span>, misalnya:
                                <span class="italic font-semibold">"Permintaan akses buku"</span>,
                                <span class="italic font-semibold">"Lupa password akun"</span>, atau
                                <span class="italic font-semibold">"Masukan fitur baru"</span>.
                            </p>

                            <p>
                                Kemudian, di bagian <span class="font-bold">Pesan</span>, jelaskan secara
                                <span class="font-bold">detail permasalahan atau pertanyaan</span> Anda. Setelah semua
                                kolom terisi dengan benar, klik tombol <span class="font-bold">Kirim Pesan</span> untuk mengirimkan formulir.
                            </p>

                            <p>
                                <span class="font-bold">Tim kami akan segera meninjau dan merespons pesan Anda melalui email.</span>
                                Harap pastikan <span class="font-bold">data yang Anda masukkan benar</span>, agar kami
                                bisa memberikan bantuan dengan <span class="font-bold">cepat dan tepat</span>.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const config = useRuntimeConfig();

const form = ref({
  name: "",
  email: "",
  subject: "",
  message: "",
});

const loading = ref(false);
const successMessage = ref("");
const errorMessage = ref("");

const submitForm = async () => {
  loading.value = true;
  successMessage.value = "";
  errorMessage.value = "";

  try {
    const { data, error } = await useFetch(`${config.public.apiBase}/contact`, {
      method: "POST",
      body: form.value,
    });

    if (error.value) {
      throw new Error(error.value.message);
    }

    successMessage.value = "Pesan berhasil dikirim!";
    form.value = { name: "", email: "", subject: "", message: "" };
  } catch (err) {
    errorMessage.value = "Gagal mengirim pesan. Coba lagi.";
  } finally {
    loading.value = false;
  }
};

const currentSlide = ref(1);
const totalSlides = 3;

const nextSlide = () => {
  currentSlide.value = currentSlide.value === totalSlides ? 1 : currentSlide.value + 1;
};

const prevSlide = () => {
  currentSlide.value = currentSlide.value === 1 ? totalSlides : currentSlide.value - 1;
};

const autoSlide = () => {
  setInterval(() => {
    nextSlide();
  }, 5000);
};

onMounted(() => {
  autoSlide();
});

const { data: books } = await useFetch(`${config.public.apiBase}/book`);

watchEffect(() => {
  if (books.value) {
    books.value.sort((a, b) => b.counter - a.counter);
  }
});

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

<style scoped>
.opacity-100 {
    opacity: 1;
}

.opacity-0 {
    opacity: 0;
}
</style>