<template>
    <div>
        <!-- HERO SLIDER -->
        <div class="w-full h-[400px] relative flex items-center justify-center">
            <div v-for="(slide, index) in slides" :key="index"
                class="absolute inset-0 transition-opacity duration-700 flex items-center justify-center pt-6 pb-4"
                :class="{ 'opacity-100': currentSlide === index + 1, 'opacity-0': currentSlide !== index + 1 }">
                <div class="w-[80%] h-full rounded-xl overflow-hidden">
                    <img :src="slide" alt="" class="w-full h-full object-cover" />
                </div>
            </div>

            <button @click="prevSlide"
                class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 text-white text-2xl md:text-3xl font-bold z-10">‹</button>
            <button @click="nextSlide"
                class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 text-white text-2xl md:text-3xl font-bold z-10">›</button>
        </div>

        <!-- TOP 5 by Category -->
        <div class="pl-4">
            <h1 class="text-3xl font-bold mb-6 pl-5">Top 5</h1>
            <div
                class="flex flex-nowrap gap-6 overflow-x-auto sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 sm:gap-8 scrollbar-hide">
                <div v-for="(category, cIndex) in categories" :key="cIndex"
                    class="flex-shrink-0 w-64 sm:w-auto flex flex-col">
                    <label class="text-2xl font-semibold rounded-xl mb-4 pl-12">{{ category.name }}</label>

                    <div v-for="(book, bIndex) in category.books" :key="bIndex" class="flex items-start pb-3 pl-12">
                        <img :src="book.image" alt="logo" class="w-20 h-28 rounded object-cover" />
                        <div class="flex flex-col pl-3">
                            <p class="text-xl font-medium">{{ book.title }}</p>
                            <p class="text-lg text-gray-600">{{ book.country }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECOMMENDATION GRID -->
        <div class="px-6 py-10 bg-gray-50">
            <h1 class="text-3xl font-bold mb-6">Recommendation</h1>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                <div v-for="(book, index) in paginatedBooks" :key="index"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">

                    <!-- Cover -->
                    <div class="aspect-[3/4] bg-gray-200">
                        <img v-if="book.image" :src="book.image" :alt="book.title" class="w-full h-full object-cover" />
                    </div>

                    <!-- Info -->
                    <div class="p-3">
                        <h2 class="text-sm font-semibold truncate">{{ book.title }}</h2>
                        <p class="text-xs text-gray-500 truncate">{{ book.author }}</p>
                    </div>
                </div>
            </div>

            <!-- Pagination Controls -->
            <div class="flex justify-center gap-4 mt-6">
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

<script>
export default {
    data() {
        return {
            // Slider
            currentSlide: 1,
            timer: null,
            slides: ['/images/waguri2.png', '/images/waguri1.png', '/images/waguri3.png'],

            // Recommendation pagination
            currentPage: 1,
            itemsPerPage: 10, // default; akan disesuaikan di mounted()
            books2: [
                { image: '/images/sedih.jpg', title: 'Book One', author: 'Author A' },
                { image: '/images/sedih.jpg', title: 'Book Two', author: 'Author B' },
                { image: '/images/sedih.jpg', title: 'Book Three', author: 'Author C' },
                { image: '/images/sedih.jpg', title: 'Book Four', author: 'Author D' },
                { image: '/images/sedih.jpg', title: 'Book Five', author: 'Author E' },
                { image: '/images/sedih.jpg', title: 'Book Six', author: 'Author F' },
                { image: '/images/sedih.jpg', title: 'Book Seven', author: 'Author G' },
                { image: '/images/sedih.jpg', title: 'Book Eight', author: 'Author H' },
                { image: '/images/sedih.jpg', title: 'Book Nine', author: 'Author I' },
                { image: '/images/sedih.jpg', title: 'Book Ten', author: 'Author J' },
                { image: '/images/sedih.jpg', title: 'Book Eleven', author: 'Author K' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
                { image: '/images/sedih.jpg', title: 'Book Twelve', author: 'Author L' },
            ],

            // Categories
            categories: [
                { name: 'Novel', books: Array.from({ length: 5 }, () => ({ image: '/images/sedih.jpg', title: 'Sedih Banget Jirs', country: 'Indonesia' })) },
                { name: 'Buku Pelajaran', books: Array.from({ length: 5 }, () => ({ image: '/images/sedih.jpg', title: 'Sedih Banget Jirs', country: 'Indonesia' })) },
                { name: 'Komik', books: Array.from({ length: 5 }, () => ({ image: '/images/sedih.jpg', title: 'Sedih Banget Jirs', country: 'Indonesia' })) },
                { name: 'Fantasi', books: Array.from({ length: 5 }, () => ({ image: '/images/sedih.jpg', title: 'Sedih Banget Jirs', country: 'Indonesia' })) },
                { name: 'Romansa', books: Array.from({ length: 5 }, () => ({ image: '/images/sedih.jpg', title: 'Sedih Banget Jirs', country: 'Indonesia' })) },
            ],
        };
    },

    computed: {
        totalSlides() {
            return this.slides.length;
        },
        totalPages() {
            const pages = Math.ceil(this.books2.length / this.itemsPerPage);
            return pages || 1;
        },
        paginatedBooks() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.books2.slice(start, start + this.itemsPerPage);
        },
    },

    mounted() {
        this.startAutoSlide();
        this.updateItemsPerPage(); // set awal sesuai viewport
        if (typeof window !== 'undefined') {
            window.addEventListener('resize', this.updateItemsPerPage);
        }
    },

    beforeUnmount() {
        if (this.timer) clearInterval(this.timer);
        if (typeof window !== 'undefined') {
            window.removeEventListener('resize', this.updateItemsPerPage);
        }
    },

    methods: {
        // Slider
        startAutoSlide() {
            this.timer = setInterval(this.nextSlide, 5000);
        },
        nextSlide() {
            this.currentSlide = this.currentSlide === this.totalSlides ? 1 : this.currentSlide + 1;
        },
        prevSlide() {
            this.currentSlide = this.currentSlide === 1 ? this.totalSlides : this.currentSlide - 1;
        },

        // Pagination (2 baris per halaman)
        nextPage() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        },
        updateItemsPerPage() {
            if (typeof window === 'undefined') return;
            const w = window.innerWidth;
            if (w >= 1024) this.itemsPerPage = 10; // lg:grid-cols-5 → 5 x 2 baris
            else if (w >= 768) this.itemsPerPage = 8;  // md:grid-cols-4 → 4 x 2 baris
            else if (w >= 640) this.itemsPerPage = 6;  // sm:grid-cols-3 → 3 x 2 baris
            else this.itemsPerPage = 4;  // grid-cols-2   → 2 x 2 baris

            if (this.currentPage > this.totalPages) this.currentPage = this.totalPages; // jaga agar index tetap valid
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

/* sembunyikan scrollbar horizontal pada list kategori */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>