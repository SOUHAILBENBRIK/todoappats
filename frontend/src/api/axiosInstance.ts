import axios from 'axios'
import vueCookies from 'vue-cookies'

const publicAxiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/',
  headers: {
    'Content-Type': 'application/json',
  },
})

const privateAxiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/',
  headers: {
    'Content-Type': 'application/json',
  },
})

export const setAuthToken = () => {
  const token = localStorage.getItem('token')
  if (token) {
    privateAxiosInstance.defaults.headers['Authorization'] = `Bearer ${token}`
  } else {
    delete privateAxiosInstance.defaults.headers['Authorization']
  }
}

export { publicAxiosInstance, privateAxiosInstance }
