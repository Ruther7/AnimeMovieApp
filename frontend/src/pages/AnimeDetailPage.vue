<script setup lang="ts">
import { ref, onMounted, inject } from 'vue'
import { useRoute } from 'vue-router'
import { watchlistApi } from '../api/anime'

export interface Anime {
  id: number
  title: string
  synopsis?: string
  genres?: string[]
  release_year?: number
  status: string
  rating?: string
  poster_url?: string
  banner_url?: string
  created_at?: string
  updated_at?: string
  deleted_at?: string | null
}

const route = useRoute()
const anime = ref<Anime | null>(null)
const watchlistItems = ref<any[]>([])
const inWatchlist = ref(false)
const loading = ref(true)
const error = ref('')
const refreshWatchlistCount = inject<(fn?: any) => void>('refreshWatchlistCount', () => {})

onMounted(async () => {
  const id = Number(route.params.id)
  if (!id) {
    error.value = 'Invalid anime ID.'
    loading.value = false
    return
  }
  try {
    const res = await fetch('/api/anime/' + id)
    const data = await res.json()
    anime.value = data
    const items = await watchlistApi.list()
    watchlistItems.value = Array.isArray(items) ? items : []
    inWatchlist.value = watchlistItems.value.some((w: any) => w.anime?.id === id)
  } catch (e) {
    error.value = 'Failed to load anime details.'
  } finally {
    loading.value = false
  }
})

async function toggleWatchlist() {
  if (!anime.value) return
  try {
    if (inWatchlist.value) {
      const item = watchlistItems.value.find((w: any) => w.anime?.id === anime.value!.id)
      if (item) {
        await watchlistApi.remove(item.id)
        watchlistItems.value = watchlistItems.value.filter((w: any) => w.id !== item.id)
        inWatchlist.value = false
        refreshWatchlistCount()
      }
    } else {
      const item = await watchlistApi.add(anime.value.id)
      watchlistItems.value.push(item)
      inWatchlist.value = true
      refreshWatchlistCount()
    }
  } catch {
    // ignore watchlist toggle error in UI
  }
}
</script>

<template>
  <q-page class="bg-dark text-white">
    <div v-if="loading" class="flex flex-center q-py-xl">
      <q-spinner color="primary" size="3rem" />
    </div>

    <div v-else-if="error" class="q-pa-md text-center text-negative">
      {{ error }}
    </div>

    <div v-else-if="anime" class="anime-detail">
      <div class="banner" :style="`background-image: url('${anime.banner_url || anime.poster_url}')`"></div>
      <div class="overlay"></div>
      <div class="content">
        <div class="row items-start q-gutter-lg">
          <div class="poster-wrapper" style="width: 220px; padding-top: 150%;">
            <img :src="anime.poster_url" :alt="anime.title" class="poster-img" />
          </div>
          <div class="info">
            <div class="text-h3 text-weight-bold">{{ anime.title }}</div>
            <div class="q-mt-sm">
              <q-chip v-for="g in anime.genres" :key="g" dense color="primary" text-color="white" :label="g" />
            </div>
            <div class="q-mt-md text-subtitle1">
              <div><strong>Year:</strong> {{ anime.release_year }}</div>
              <div><strong>Status:</strong> {{ anime.status }}</div>
              <div><strong>Rating:</strong> {{ anime.rating }}/10</div>
            </div>
            <p class="q-mt-md text-body1">{{ anime.synopsis }}</p>
            <q-btn :label="inWatchlist ? 'Remove from Watchlist' : 'Add to Watchlist'" :color="inWatchlist ? 'negative' : 'primary'" class="q-mt-md" @click="toggleWatchlist" />
            <q-btn flat label="Back to Catalog" class="q-mt-md q-ml-sm" to="/catalog" />
          </div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<style scoped>
.banner {
  width: 100%;
  height: 50vh;
  min-height: 320px;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
.overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 50vh;
  min-height: 320px;
  background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0.9));
  pointer-events: none;
}
.content {
  position: relative;
  margin-top: -30vh;
  padding: 0 2rem 2rem;
  z-index: 2;
}
.info {
  max-width: 700px;
}
.poster-wrapper {
  position: relative;
  width: 100%;
  padding-top: 150%;
  overflow: hidden;
  background: #1e1e1e;
}
.poster-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
