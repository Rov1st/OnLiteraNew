    <template>
        <div class="w-full h-[300px] md:h-[400px] relative shadow-lg">
            <!-- Slides -->
            <div class="absolute inset-0 transition-opacity duration-700"
                :class="{ 'opacity-100': currentSlide === 1, 'opacity-0': currentSlide !== 1 }">
                <img src="/images/img1.jpg" alt="Slide 1" class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 transition-opacity duration-700"
                :class="{ 'opacity-100': currentSlide === 2, 'opacity-0': currentSlide !== 2 }">
                <img src="/images/img2.jpg" alt="Slide 2" class="w-full h-full object-cover">
            </div>

            <!-- Navigation Buttons -->
            <button @click="prevSlide"
                class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 text-white text-2xl md:text-3xl font-bold z-10"></button>
            <button @click="nextSlide"
                class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 text-white text-2xl md:text-3xl font-bold z-10"></button>
        </div>

        <div class="w-full font-mono">
            <div class="mx-4 md:mx-16 mt-5 mb-10 bg-white" id="popular-book">
                <h1 class="text-4xl md:text-6xl mb-5">
                    Popular
                </h1>
                <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6" id="card">
                    <div
                        class="w-full md:max-w-sm min-h-[500px] md:min-h-[600px] max-h-[600px] rounded shadow-lg bg-[#deedfa]">
                        <img class="w-full h-100 object-cover" src="/images/sample.jpg" alt="Gambar">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">Judul Card</div>
                            <p class="text-gray-700 text-base">
                                Ini adalah deskripsi singkat dari konten dalam card. Kamu bisa menyesuaikannya sesuai
                                kebutuhan.
                            </p>
                        </div>
                        <div class="px-6 pt-4 pb-2">
                            <span
                                class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2">#Tag1</span>
                            <span
                                class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2">#Tag2</span>
                        </div>
                    </div>

                    <div
                        class="w-full md:max-w-sm min-h-[500px] md:min-h-[600px] max-h-[600px] rounded  shadow-lg bg-[#deedfa]">
                        <img class="w-full h-100 object-cover" src="/images/sample1.jpg" alt="Gambar">
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">Judul Card</div>
                            <p class="text-gray-700 text-base">
                                Ini adalah deskripsi singkat dari konten dalam card. Kamu bisa menyesuaikannya sesuai
                                kebutuhan.
                            </p>
                        </div>
                        <div class="px-6 pt-4 pb-2">
                            <span
                                class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2">#Tag1</span>
                            <span
                                class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2">#Tag2</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -top-4 left-0 w-full h-4 bg-gradient-to-b from-black/15 to-transparent z-10"></div>
                <div class="absolute -top-1 left-0 w-full h-1 bg-gradient-to-t from-black/10 to-transparent z-10"></div>

                <!-- About Us Section -->
                <section class="bg-slate-400 pt-3 text-white relative z-0" id="aboutus">
                    <div class="mx-4 md:mx-16 pt-15">
                        <h1 class="text-4xl md:text-6xl">About Us</h1>
                        <div class="flex flex-col md:flex-row gap-x-8 my-10 md:my-27 p-4 md:p-10 items-center">
                            <!-- Vision -->
                            <div class="w-full md:w-2/3">
                                <h2 class="text-center text-3xl md:text-5xl mb-2">Visi</h2>
                                <p class="text-justify text-xl md:text-3xl pr-0 md:pr-10">
                                    Menjadi platform perpustakaan digital terdepan yang membuka akses literasi bagi
                                    semua
                                    orang, di mana saja dan kapan saja,
                                    serta membangun ekosistem membaca yang inklusif, inovatif, dan berkelanjutan.
                                    Kami berkomitmen untuk menjadikan teknologi sebagai jembatan bagi masyarakat dalam
                                    memperoleh pengetahuan,
                                    mendukung pertumbuhan intelektual generasi masa depan, dan memperkuat budaya
                                    literasi di
                                    era digital.
                                </p>
                            </div>

                            <!-- Image -->
                            <div class="w-full md:w-1/3 mt-6 md:mt-0">
                                <img class="h-60 md:h-80 w-full object-cover rounded-lg" src="/images/sample.jpg"
                                    alt="">
                            </div>
                        </div>

                        <div class="my-10 md:my-15 px-4 md:px-10 py-6 md:py-10 text-white">
                            <h2 class="text-center text-3xl md:text-5xl font-bold mb-6 md:mb-10">Misi</h2>

                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 md:gap-6 pb-6 pr-0 md:pr-6 justify-center">

                                <!-- Card 1 -->
                                <div class="w-full h-[300px] hover:z-50 md:w-[320px] md:h-[340px] text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 
                    transform transition duration-300 origin-center will-change-transform 
                    hover:scale-[1.03] hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 1"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Menyediakan akses mudah dan cepat ke ribuan buku digital dari berbagai genre.
                                    </p>
                                </div>

                                <!-- Card 2 -->
                                <div class="w-full h-[300px] hover:z-50 md:w-[320px] md:h-[340px] text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 
                    transform transition duration-300 origin-center will-change-transform 
                    hover:scale-[1.03] hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 2"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Mendorong budaya membaca dengan pendekatan yang modern, inklusif, dan ramah
                                        usia.
                                    </p>
                                </div>

                                <!-- Card 3 -->
                                <div class="w-full h-[300px] hover:z-50 md:w-[320px] md:h-[340px] text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 
                    transform transition duration-300 origin-center will-change-transform 
                    hover:scale-[1.03] hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 3"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Menghadirkan pengalaman membaca yang seru, nyaman, dan fleksibel untuk segala
                                        perangkat.
                                    </p>
                                </div>

                                <!-- Card 4 -->
                                <div class="w-full h-[300px] hover:z-50 md:w-[320px] md:h-[340px] text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 
                    transform transition duration-300 origin-center will-change-transform 
                    hover:scale-[1.03] hover:shadow-xl hover:ring-2 hover:ring-black/90">
                                    <img src="https://via.placeholder.com/300x180" alt="Misi 4"
                                        class="w-full h-32 md:h-40 object-cover rounded-lg mb-4">
                                    <p class="text-base md:text-lg font-medium">
                                        Menghubungkan pembaca dengan literatur berkualitas dari penulis lokal hingga
                                        internasional.
                                    </p>
                                </div>

                                <!-- Card 5 -->
                                <div class="w-full h-[300px] hover:z-50 md:w-[320px] md:h-[340px] text-center ring-2 ring-black/15 bg-white text-gray-800 rounded-xl shadow-md p-4 md:p-6 
                    transform transition duration-300 origin-center will-change-transform 
                    hover:scale-[1.03] hover:shadow-xl hover:ring-2 hover:ring-black/90">
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

                <!-- Developer Section -->
                <section class="mx-4 md:mx-16 mt-10 md:mt-25 mb-10" id="developer">
                    <h1 class="text-4xl md:text-6xl mb-5">
                        Developer
                    </h1>
                    <div class="mt-6 md:mt-10 mx-2 md:mx-10" id="cardofdeveloper">
                        <div class="flex flex-col md:flex-row text-lg md:text-2xl text-justify mb-10 md:mb-30">
                            <div class="w-full md:w-2/3 pr-0 md:pr-20 order-2 md:order-1">
                                <h1 class="text-2xl md:text-4xl mb-2">FA'IQ HALUL DANENDRA</h1>
                                <p>
                                    Pengembang yang berfokus pada pengembangan logika aplikasi dan pengelolaan basis
                                    data (database) yang aman, terstruktur, dan efisien. Membangun API dan layanan
                                    server yang andal, mengoptimalkan performa sistem, serta memastikan keamanan data
                                    pengguna. Berkomitmen menghadirkan solusi digital yang skalabel, mendukung integrasi
                                    antar sistem, dan membangun fondasi teknologi yang kuat serta berkelanjutan di era
                                    modern.
                                </p>
                            </div>
                            <div
                                class="w-full md:w-1/3 flex items-center justify-center mb-6 md:mb-0 order-1 md:order-2">
                                <img class="w-40 h-40 md:w-60 md:h-60 object-cover rounded-full" src="/images/iq.jpg"
                                    alt="Foto Developer">
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row text-lg md:text-2xl text-justify mb-10 md:mb-30">
                            <div class="w-full md:w-2/3 pr-0 md:pr-20 order-2 md:order-1">
                                <h1 class="text-2xl md:text-4xl mb-2">Muhamad Firdaus Al Ghajali</h1>
                                <p>
                                    Seorang Database Administrator sekaligus pengembang front-end bagian pengguna, yang
                                    berpengalaman dalam mengelola, mengoptimalkan, dan menjaga keamanan sistem basis
                                    data. Terampil membangun antarmuka pengguna yang intuitif dan ramah, memastikan data
                                    terintegrasi dengan baik antara tampilan dan sistem penyimpanan. Berkomitmen
                                    menghadirkan pengalaman pengguna yang lancar, serta menjaga keandalan dan kinerja
                                    basis data di setiap proyek.
                                </p>
                            </div>
                            <div
                                class="w-full md:w-1/3 flex items-center justify-center mb-6 md:mb-0 order-1 md:order-2">
                                <img class="w-40 h-40 md:w-60 md:h-60 object-cover rounded-full" src="/images/us.jpg"
                                    alt="Foto Developer">
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row text-lg md:text-2xl text-justify">
                            <div class="w-full md:w-2/3 pr-0 md:pr-20 order-2 md:order-1">
                                <h1 class="text-2xl md:text-4xl mb-2">Muhammad Billal Nurfildan</h1>
                                <p>
                                    Seorang pengembang front-end admin yang berfokus pada pembuatan dan optimalisasi
                                    dashboard administrasi. Ahli dalam merancang tampilan yang responsif dan interaktif,
                                    serta mengintegrasikan data untuk menampilkan grafik peminjaman buku secara
                                    real-time. Memastikan setiap fitur admin berjalan fungsional, informatif, dan
                                    memudahkan pengelolaan data perpustakaan digital.
                                </p>
                            </div>
                            <div
                                class="w-full md:w-1/3 flex items-center justify-center mb-6 md:mb-0 order-1 md:order-2">
                                <img class="w-40 h-40 md:w-60 md:h-60 object-cover rounded-full" src="/images/lal.jpg"
                                    alt="Foto Developer">
                            </div>
                        </div>
                    </div>
                </section>
                <section class="mx-4 md:mx-16 mt-10 md:mt-25 mb-10" id="contactus">
                    <h1 class="text-4xl md:text-6xl mb-5">
                        Contact Us
                    </h1>
                    <div class="flex flex-col justify-between mx-8 md:flex-row">
                        <form action="proses-kontak.php" method="POST"
                            class="bg-white text-black mb-10 rounded-lg shadow-md p-6 md:p-10 space-y-4 md:space-y-6 w-full max-w-3xl">
                            <div>
                                <label for="name" class="block font-semibold text-lg mb-1">Nama</label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
                            </div>

                            <div>
                                <label for="email" class="block font-semibold text-lg mb-1">Email</label>
                                <input type="email" id="email" name="email" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
                            </div>

                            <div>
                                <label for="subject" class="block font-semibold text-lg mb-1">Subjek</label>
                                <input type="text" id="subject" name="subject" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
                            </div>

                            <div>
                                <label for="message" class="block font-semibold text-lg mb-1">Pesan</label>
                                <textarea id="message" name="message" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                            </div>

                            <div class="text-right">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded transition-colors duration-300">
                                    Kirim Pesan
                                </button>
                            </div>
                        </form>
                        <div
                            class="bg-white text-black rounded-lg mb-10 shadow-md p-6 md:p-10 space-y-4 md:space-y-6 w-full max-w-3xl text-xl">
                            <p>
                                Bagian <span class="font-bold">Contact Us</span> pada halaman ini disediakan khusus bagi
                                Anda,
                                <span class="font-bold">pengguna perpustakaan digital</span>, yang ingin menyampaikan
                                <span class="font-bold">pertanyaan</span>, <span class="font-bold">saran</span>, atau
                                <span class="font-bold">kendala</span> selama menggunakan layanan kami. Untuk
                                menghubungi kami,
                                silakan <span class="font-bold">isi formulir yang tersedia dengan lengkap</span>.
                            </p>

                            <p>
                                Pertama, masukkan <span class="font-bold">nama lengkap</span> Anda agar kami mengetahui
                                siapa yang mengirim pesan.
                                Selanjutnya, tuliskan <span class="font-bold">alamat email yang masih aktif</span>,
                                karena semua
                                <span class="font-bold">balasan dari kami akan dikirimkan ke email tersebut</span>. Pada
                                kolom
                                <span class="font-bold">Subjek</span>, tuliskan <span class="font-bold">inti dari pesan
                                    Anda</span>, misalnya:
                                <span class="italic font-semibold">“Permintaan akses buku”</span>,
                                <span class="italic font-semibold">“Lupa password akun”</span>, atau
                                <span class="italic font-semibold">“Masukan fitur baru”</span>.
                            </p>

                            <p>
                                Kemudian, di bagian <span class="font-bold">Pesan</span>, jelaskan secara
                                <span class="font-bold">detail permasalahan atau pertanyaan</span> Anda. Setelah semua
                                kolom terisi dengan benar,
                                klik tombol <span class="font-bold">Kirim Pesan</span> untuk mengirimkan formulir.
                            </p>

                            <p>
                                <span class="font-bold">Tim kami akan segera meninjau dan merespons pesan Anda melalui
                                    email.</span>
                                Harap pastikan <span class="font-bold">data yang Anda masukkan benar</span>, agar kami
                                bisa memberikan bantuan dengan
                                <span class="font-bold">cepat dan tepat</span>.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </template>

<script>
export default {
    data() {
        return {
            currentSlide: 1,
            totalSlides: 3,
        };
    },
    mounted() {
        this.autoSlide();
    },
    methods: {
        showSlide(n) {
            this.currentSlide = n;
        },
        nextSlide() {
            this.currentSlide = this.currentSlide === this.totalSlides ? 1 : this.currentSlide + 1;
        },
        prevSlide() {
            this.currentSlide = this.currentSlide === 1 ? this.totalSlides : this.currentSlide - 1;
        },
        autoSlide() {
            setInterval(() => {
                this.nextSlide();
            }, 5000); // Change every 5 seconds
        },
    },
};
</script>

<style scoped>
.opacity-100 {
    opacity: 1;
}

.opacity-0 {
    opacity: 0;
}
</style>