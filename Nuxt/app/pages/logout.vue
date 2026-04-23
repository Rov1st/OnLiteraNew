<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

// begitu halaman ini diload, langsung logout
auth.logout()
router.push('/login')
</script>