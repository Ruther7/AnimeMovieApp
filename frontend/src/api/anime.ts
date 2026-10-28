import axios from 'axios'

const api = axios.create({
  baseURL: '/api',
  headers: {
    Accept: 'application/json',
  },
})

export const animeApi = {
  list(params?: Record<string, unknown>) {
    return api.get('/anime', { params }).then((r) => r.data)
  },
  get(id: number) {
    return api.get(`/anime/${id}`).then((r) => r.data)
  },
}

export const watchlistApi = {
  list() {
    return api.get('/watchlist').then((r) => r.data)
  },
  add(animeId: number) {
    return api.post('/watchlist', { anime_id: animeId }).then((r) => r.data)
  },
  remove(id: number) {
    return api.delete(`/watchlist/${id}`).then((r) => r.data)
  },
}

export default api
