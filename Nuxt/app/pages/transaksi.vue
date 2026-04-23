<template>
  <div class="w-full p-4 md:p-8">
    <!-- Loading state -->
    <div v-if="loading" class="text-center py-12">
      <div class="text-gray-400 text-xl mb-2">📚</div>
      <p class="text-gray-500">Memuat data transaksi...</p>
    </div>

    <!-- Error state -->
    <div v-else-if="error" class="text-center py-12">
      <div class="text-red-400 text-xl mb-2">❌</div>
      <h3 class="text-lg font-medium text-red-700 mb-1">Error</h3>
      <p class="text-red-500">{{ error }}</p>
      <button @click="fetchLoans" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Coba Lagi
      </button>
    </div>

    <!-- Loop through loan data -->
    <div v-else-if="loans.length > 0">
      <div v-for="loan in loans" :key="loan.id" class="mb-6">
        <div class="border border-gray-300 shadow-lg p-4 md:p-6 rounded-lg bg-white">
          <!-- Header section -->
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 mb-4 border-b-2 border-blue-200 gap-2 md:gap-0">
            <div class="flex-1">
              <h1 class="text-base md:text-xl lg:text-2xl font-semibold text-gray-800 break-words mb-2">
                Peminjaman IN-{{ loan.id }}
              </h1>
              
              <!-- Tanggal Pinjam -->
              <div class="text-sm md:text-base text-gray-700 mb-1">
                <span class="font-medium">Dipinjam:</span>
                <span class="text-blue-600 font-medium ml-1">{{ formatDate(loan.tanggal_pinjam) }}</span>
              </div>
              
              <!-- Tanggal Harus Kembali -->
              <div class="text-sm md:text-base text-gray-700 mb-1">
                <span class="font-medium">Harus dikembalikan:</span>
                <span class="text-orange-600 font-medium ml-1">{{ formatDate(loan.tanggal_harus_kembali) }}</span>
              </div>
              
              <!-- Tanggal Kembali Aktual (jika sudah dikembalikan) -->
              <div v-if="loan.tanggal_kembali_aktual" class="text-sm md:text-base text-gray-700 mb-1">
                <span class="font-medium">Dikembalikan pada:</span>
                <span class="text-green-600 font-medium ml-1">{{ formatDate(loan.tanggal_kembali_aktual) }}</span>
                <span v-if="isLate(loan.tanggal_harus_kembali, loan.tanggal_kembali_aktual)" 
                      class="text-red-500 text-xs ml-2 font-medium">
                  (Terlambat {{ getDaysLate(loan.tanggal_harus_kembali, loan.tanggal_kembali_aktual) }} hari)
                </span>
              </div>
              
              <!-- Denda jika ada -->
              <div v-if="loan.denda > 0" class="text-sm md:text-base text-red-600 font-medium">
                Denda: Rp {{ formatCurrency(loan.denda) }}
              </div>
            </div>
            
            <div class="flex flex-col items-end gap-2">
              <div class="flex items-center">
                <span class="text-sm md:text-lg lg:text-xl font-semibold text-gray-700">Status:</span>
                <span class="ml-2 px-3 py-1 rounded-full text-xs md:text-sm font-medium"
                      :class="getStatusClass(getActualStatus(loan))">
                  {{ getActualStatus(loan) }}
                </span>
              </div>
              
              <!-- Tombol Batalkan (hanya muncul jika status Menunggu Konfirmasi) -->
              <button 
                v-if="loan.status === 'Menunggu Konfirmasi'"
                @click="confirmCancelLoan(loan.id)"
                :disabled="cancelingLoanId === loan.id"
                class="px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors">
                {{ cancelingLoanId === loan.id ? 'Membatalkan...' : 'Batalkan Peminjaman' }}
              </button>
            </div>
          </div>

          <!-- Books section -->
          <div class="space-y-3">
            <h2 class="text-lg md:text-xl font-semibold text-gray-700 mb-3">Buku yang Dipinjam:</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
              <div v-for="book in loan.books" :key="book.id" 
                   class="border border-gray-200 rounded-lg p-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                <div class="flex justify-between items-start">
                  <div class="flex-1 pr-2">
                    <p class="font-semibold text-gray-800 text-sm md:text-base break-words leading-tight">
                      {{ book.judul }}
                    </p>
                    <p class="text-gray-600 text-xs md:text-sm mt-1 break-words">
                      {{ book.penulis }}
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                      ISBN: {{ book.isbn }}
                    </p>
                  </div>
                  <div class="flex flex-col items-end shrink-0">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                      {{ book.qty }}x
                    </span>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Total books -->
            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
              <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-700">Total Buku:</span>
                <span class="font-bold text-blue-600 text-lg">
                  {{ getTotalBooks(loan.books) }} buku
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty state -->
    <div v-else class="text-center py-12">
      <div class="text-gray-400 text-xl mb-2">📚</div>
      <h3 class="text-lg font-medium text-gray-700 mb-1">Tidak ada peminjaman</h3>
      <p class="text-gray-500">Belum ada riwayat peminjaman buku</p>
    </div>

    <!-- Modal Konfirmasi -->
    <div v-if="showConfirmModal" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4"
      @click.self="showConfirmModal = false">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
        <button @click="showConfirmModal = false" type="button" 
          class="absolute top-4 right-4 text-gray-500 hover:text-black">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <h1 class="font-semibold text-base md:text-lg text-center p-2 mb-4">
          Apakah Anda yakin ingin membatalkan peminjaman <span class="text-blue-400">IN-{{ selectedLoanId }}</span>?
        </h1>
        <p class="text-gray-600 text-center text-sm mb-6">
          Tindakan ini tidak dapat dibatalkan dan stok buku akan dikembalikan.
        </p>
        <div class="flex flex-col space-y-2">
          <button @click="cancelLoan"
            class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm md:text-base">
            Ya, Batalkan Peminjaman
          </button>
          <button @click="showConfirmModal = false"
            class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm md:text-base">
            Tidak
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Success -->
    <div v-if="toast.show" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4"
      @click.self="toast.show = false">
      <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
        <button @click="toast.show = false" type="button" 
          class="absolute top-4 right-4 text-gray-500 hover:text-black">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <h1 class="font-semibold text-base md:text-lg text-center p-2">
          <span v-if="toast.type === 'success'" class="text-green-600">{{ toast.message }}</span>
          <span v-else class="text-red-600">{{ toast.message }}</span>
        </h1>
        <div class="p-1 flex mt-4">
          <button @click="toast.show = false"
            class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm md:text-base">
            OK
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const config = useRuntimeConfig()
const loans = ref([])
const loading = ref(true)
const error = ref(null)
const cancelingLoanId = ref(null)
const showConfirmModal = ref(false)
const selectedLoanId = ref(null)
const toast = ref({
  show: false,
  message: '',
  type: 'success'
})

// Ambil user_id dari localStorage (hasil login)
const userId = process.client ? localStorage.getItem('user_id') : null

// Fetch data peminjaman
const fetchLoans = async () => {
  try {
    loading.value = true
    error.value = null
    
    if (!userId) {
      throw new Error('User ID tidak ditemukan. Silakan login kembali.')
    }

    const response = await $fetch(
      `${config.public.apiBase}/transaksi/${userId}`, 
      { 
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        timeout: 30000,
        retry: 2,
        onResponseError({ request, response, options }) {
          console.log('Response error:', response.status, response.statusText)
        },
        onRequestError({ request, options, error }) {
          console.log('Request error:', error)
        }
      }
    )

    if (response) {
      if (response.hasOwnProperty('success')) {
        if (response.success) {
          loans.value = response.data || []
        } else {
          loans.value = []
          console.warn('API returned success: false', response.message)
        }
      } else {
        loans.value = Array.isArray(response) ? response : []
      }
    } else {
      loans.value = []
    }
    
  } catch (err) {
    console.error('Error fetching loans:', err)
    
    if (err.message.includes('timeout') || err.message.includes('network')) {
      error.value = 'Koneksi lambat atau bermasalah. Silakan coba lagi.'
    } else if (err.message.includes('User ID tidak ditemukan')) {
      error.value = err.message
    } else {
      error.value = 'Server sedang lambat. Silakan tunggu atau coba lagi.'
    }
    
    loans.value = []
  } finally {
    loading.value = false
  }
}

// Konfirmasi pembatalan
const confirmCancelLoan = (loanId) => {
  selectedLoanId.value = loanId
  showConfirmModal.value = true
}

// Batalkan peminjaman
const cancelLoan = async () => {
  try {
    cancelingLoanId.value = selectedLoanId.value
    showConfirmModal.value = false
    
    const response = await $fetch(
      `${config.public.apiBase}/transaksi/${selectedLoanId.value}/batalkan`,
      {
        method: 'PUT',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        }
      }
    )
    
    if (response.success) {
      // Update status di list loans
      const loanIndex = loans.value.findIndex(loan => loan.id === selectedLoanId.value)
      if (loanIndex !== -1) {
        loans.value[loanIndex].status = 'Dibatalkan'
      }
      
      // Tampilkan toast sukses
      showToast('Peminjaman berhasil dibatalkan', 'success')
    } else {
      throw new Error(response.message || 'Gagal membatalkan peminjaman')
    }
    
  } catch (err) {
    console.error('Error canceling loan:', err)
    showToast(err.data?.message || err.message || 'Terjadi kesalahan saat membatalkan peminjaman', 'error')
  } finally {
    cancelingLoanId.value = null
    selectedLoanId.value = null
  }
}

// Show toast notification (now as modal)
const showToast = (message, type = 'success') => {
  toast.value = {
    show: true,
    message,
    type
  }
  
  // Auto close after 3 seconds
  setTimeout(() => {
    toast.value.show = false
  }, 3000)
}

// Jalankan fetch saat mounted
onMounted(() => {
  if (userId) {
    fetchLoans()
  } else {
    loading.value = false
    error.value = 'User ID tidak ditemukan. Silakan login kembali.'
  }
})

// Format tanggal
const formatDate = (dateString) => {
  if (!dateString) return '-'
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  })
}

// Format currency
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

// Check if return is late
const isLate = (dueDate, returnDate) => {
  if (!dueDate || !returnDate) return false
  return new Date(returnDate) > new Date(dueDate)
}

// Calculate days late
const getDaysLate = (dueDate, returnDate) => {
  if (!dueDate || !returnDate) return 0
  const due = new Date(dueDate)
  const returned = new Date(returnDate)
  const diffTime = returned - due
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24))
}

// Get total books
const getTotalBooks = (books) => {
  return books.reduce((total, book) => total + book.qty, 0)
}

// Get actual status (override if late)
const getActualStatus = (loan) => {
  // Jika ada tanggal kembali aktual dan terlambat, status = Terlambat
  if (loan.tanggal_kembali_aktual && isLate(loan.tanggal_harus_kembali, loan.tanggal_kembali_aktual)) {
    return 'Terlambat'
  }
  // Jika tidak, gunakan status asli
  return loan.status
}

// Get status styling
const getStatusClass = (status) => {
  switch (status) {
    case 'Dipinjam':
      return 'bg-blue-100 text-blue-800'
    case 'Dikembalikan':
      return 'bg-green-100 text-green-800'
    case 'Ditolak':
    case 'Dibatalkan':
      return 'bg-red-100 text-red-800'
    case 'Menunggu Konfirmasi':
      return 'bg-yellow-100 text-yellow-800'
    case 'Dikonfirmasi':
      return 'bg-blue-100 text-blue-800'
    case 'Terlambat':
      return 'bg-orange-100 text-orange-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

definePageMeta({
  middleware: 'auth'
})
</script>