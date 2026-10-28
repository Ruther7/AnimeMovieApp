<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

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

const animeList = ref<Anime[]>([])
const search = ref('')
const genreFilter = ref('')
const statusFilter = ref('')
const loading = ref(false)
const error = ref('')
const fetchId = ref(0)

async function safeFetch() {
  const currentId = ++fetchId.value
  loading.value = true
  error.value = ''
  try {
    const controller = new AbortController()
    const timeoutId = setTimeout(() => controller.abort(), 10000)
    const res = await fetch('/api/anime', { signal: controller.signal })
    clearTimeout(timeoutId)
    const data = await res.json()
    if (currentId === fetchId.value) {
      animeList.value = Array.isArray(data.data) ? data.data : []
    }
  } catch (e: any) {
    if (currentId === fetchId.value) {
      if (e.name === 'AbortError') {
        error.value = 'Request timed out.'
      } else {
        error.value = 'Failed to load anime.'
      }
    }
  } finally {
    if (currentId === fetchId.value) {
      loading.value = false
    }
  }
}

onMounted(() => {
  safeFetch()
})

function goDetail(id: number) {
  router.push(`/anime/${id}`)
}
</script>

<template>
  <q-page class="bg-dark text-white q-pa-md">
    <div class="text-h4 q-mb-md text-weight-bold">Anime Catalog</div>

    <div class="row q-gutter-md q-mb-lg">
      <div class="col-12 col-sm-4">
        <q-input v-model="search" dense outlined dark label="Search title" @update:model-value="safeFetch">
          <template #prepend><q-icon name="search" /></template>
        </q-input>
      </div>
      <div class="col-6 col-sm-3">
        <q-select v-model="genreFilter" :options="['Action', 'Adventure', 'Drama', 'Fantasy', 'Sci-Fi', 'Slice of Life', 'Mecha']" dense outlined dark label="Genre" emit-value map-options clearable @update:model-value="safeFetch" />
      </div>
      <div class="col-6 col-sm-3">
        <q-select v-model="statusFilter" :options="['ongoing', 'completed', 'upcoming']" dense outlined dark label="Status" emit-value map-options clearable @update:model-value="safeFetch" />
      </div>
    </div>

    <div v-if="loading" class="flex flex-center q-py-xl">
      <q-spinner color="primary" size="3rem" />
    </div>

    <div v-else-if="error" class="text-center text-negative q-pa-md">
      {{ error }}
    </div>

    <div v-else-if="animeList.length === 0" class="text-center text-grey q-pa-xl">
      No anime found.
    </div>

    <div v-else class="row q-gutter-md">
      <div v-for="item in animeList" :key="item.id" class="col-6 col-sm-4 col-md-3 col-lg-2">
        <q-card class="bg-dark-card cursor-pointer" @click="goDetail(item.id)">
          <div class="poster-wrapper">
            <img :src="item.poster_url" :alt="item.title" class="poster-img" />
            <div class="absolute-bottom text-subtitle2 text-center bg-dark text-white poster-title">
              {{ item.title }}
            </div>
          </div>
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
