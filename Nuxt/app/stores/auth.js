  import { defineStore } from 'pinia'
  import { ref, onMounted } from 'vue'

  export const useAuthStore = defineStore('auth', () => {
    const token = ref('')
    const user = ref(null)

    const initAuth = () => {
      if (process.client) {
        token.value = localStorage.getItem('token') || ''
        user.value = JSON.parse(localStorage.getItem('user') || 'null')
      }
    }

    const isLoggedIn = () => !!token.value

    const login = (newToken, newUser) => {
      token.value = newToken
      user.value = newUser
      if (process.client) {
        localStorage.setItem('token', newToken)
        localStorage.setItem('user', JSON.stringify(newUser))
      }
    }

    const logout = () => {
      token.value = ''
      user.value = null
      if (process.client) {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        localStorage.removeItem('user_id')
      }
    }

    const fetchUser = async () => {
      if (!token.value) return
      try {
        const res = await axios.get(`${config.public.apiBase}/user`, {
          headers: {
            Authorization: `Bearer ${token.value}`,
          },
        })
        user.value = res.data
        if (process.client) {
          localStorage.setItem('user', JSON.stringify(res.data))
        }
      } catch (err) {
        console.error('Gagal fetch user:', err)
      }
    }

    onMounted(initAuth)

    return { token, user, isLoggedIn, login, logout, initAuth }
  })
