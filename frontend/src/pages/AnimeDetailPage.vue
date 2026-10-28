<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { animeApi, watchlistApi } from '../api/anime'

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

onMounted(async () => {
  const id = Number(route.params.id)
  if (!id) {
    error.value = 'Invalid anime ID.'
    loading.value = false
    return
  }
  try {
    anime.value = await animeApi.get(id)
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
      }
    } else {
      const item = await watchlistApi.add(anime.value.id)
      watchlistItems.value.push(item)
      inWatchlist.value = true
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
      <div class="banner" :style="`background-image: url('${anime.banner_url || anime.poster_url}')`">
        <div class="overlay">
          <div class="content">
            <div class="row items-start q-gutter-lg">
              <q-img :src="anime.poster_url" :ratio="2/3" width="220px" fit="cover" class="rounded-borders" />
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
      </div>
    </div>
  </q-page>
</template>

<style scoped>
.banner {
  width: 100%;
  min-height: 60vh;
  background-size: cover;
  background-position: center;
  position: relative;
}
.overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.9), rgba(0,0,0,0.4));
  display: flex;
  align-items: flex-end;
}
.content {
  padding: 2rem;
  width: 100%;
}
.info {
  max-width: 700px;
}
</style>
