import axios, {AxiosError} from 'axios'
import {useAuthStore} from "@/stores/useAuthStore.ts";


const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    "Content-Type": "application/json",
    "Accept": "application/json",
  }
})

export const fetchData = async (endpoint: string) => {
  try {
    const response = await api.get(endpoint)
    return response.data
  } catch (error) {
    if (error instanceof AxiosError) {
      throw error
    }
  }
}
export const postData = async (endpoint: string, data: object) => {
  try {
    const response = await api.post(endpoint, data)
    return response.data
  } catch (error) {
    if (error instanceof AxiosError) {
      throw error
    }
  }
}

export const postMultiPartData = async (endpoint: string, data: object) => {
  try {
    const response = await api.post(endpoint, data, {headers: {"Content-Type": "multipart/form-data"}})
    return response.data
  } catch (error) {
    if (error instanceof AxiosError) {
      throw error
    }
  }
}

export const deleteData = async (endpoint: string, data: object) => {
  try {
    const response = await api.delete(endpoint, data)
    return response.data
  } catch (error) {
    if (error instanceof AxiosError) {
      throw error
    }
  }
}

api.interceptors.request.use(
    (config) => {
      const authStore = useAuthStore();
      const token = authStore.token || localStorage.getItem("token")
      if (token) {
        config.headers.Authorization = `Bearer ${token}`
      }
      return config
    },
    (error) => {
      return Promise.reject(error)
    }
)