<script setup lang="ts">
import { ref, onMounted, inject } from 'vue'
import { useRouter } from 'vue-router'
import { watchlistApi } from '../api/anime'

const router = useRouter()
const items = ref<any[]>([])
const loading = ref(false)
const error = ref('')
const fetchId = ref(0)
const refreshWatchlistCount = inject<(fn?: any) => void>('refreshWatchlistCount', () => {})

async function safeLoad() {
  const currentId = ++fetchId.value
  loading.value = true
  error.value = ''
  try {
    const controller = new AbortController()
    const timeoutId = setTimeout(() => controller.abort(), 10000)
    const res = await fetch('/api/watchlist', { signal: controller.signal })
    clearTimeout(timeoutId)
    const data = await res.json()
    if (currentId === fetchId.value) {
      items.value = Array.isArray(data) ? data : []
    }
  } catch (e: any) {
    if (currentId === fetchId.value) {
      if (e.name === 'AbortError') {
        error.value = 'Request timed out.'
      } else {
        error.value = 'Failed to load watchlist.'
      }
    }
  } finally {
    if (currentId === fetchId.value) {
      loading.value = false
    }
  }
}

onMounted(() => {
  safeLoad()
})

async function remove(id: number) {
  try {
    await watchlistApi.remove(id)
    items.value = items.value.filter((w) => w.id !== id)
    refreshWatchlistCount()
  } catch {
    // ignore
  }
}

function goDetail(id: number) {
  router.push(`/anime/${id}`)
}
</script>

<template>
  <q-page class="bg-dark text-white q-pa-md">
    <div class="text-h4 q-mb-md text-weight-bold">My Watchlist</div>

    <div v-if="loading" class="flex flex-center q-py-xl">
      <q-spinner color="primary" size="3rem" />
    </div>

    <div v-else-if="error" class="text-center text-negative q-pa-md">
      {{ error }}
    </div>

    <div v-else-if="items.length === 0" class="text-center text-grey q-pa-xl">
      Your watchlist is empty.
    </div>

    <div v-else class="row q-gutter-md">
      <div v-for="item in items" :key="item.id" class="col-6 col-sm-4 col-md-3 col-lg-2">
        <q-card class="bg-dark-card">
          <div class="poster-wrapper" @click="goDetail(item.anime!.id)">
            <img :src="item.anime?.poster_url" :alt="item.anime?.title" class="poster-img" />
            <div class="absolute-bottom text-subtitle2 text-center bg-dark text-white poster-title">
              {{ item.anime?.title }}
            </div>
          </div>
          <q-card-actions align="center">
            <q-btn flat dense icon="delete" color="negative" label="Remove" @click="remove(item.id)" />
          </q-card-actions>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<style scoped>
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
.poster-title {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  padding: 0.5rem;
}
</style>
