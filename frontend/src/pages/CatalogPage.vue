<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { animeApi } from '../api/anime'

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

const router = useRouter()
const animeList = ref<Anime[]>([])
const search = ref('')
const genreFilter = ref('')
const statusFilter = ref('')
const loading = ref(true)
const error = ref('')
const page = ref(1)

onMounted(async () => {
  await fetch()
})

async function fetch() {
  loading.value = true
  error.value = ''
  try {
    const data = await animeApi.list({
      search: search.value || undefined,
      genre: genreFilter.value || undefined,
      status: statusFilter.value || undefined,
      page: page.value,
    })
    animeList.value = Array.isArray(data.data) ? data.data : []
  } catch (e) {
    error.value = 'Failed to load anime.'
  } finally {
    loading.value = false
  }
}

function goDetail(id: number) {
  router.push(`/anime/${id}`)
}
</script>

<template>
  <q-page class="bg-dark text-white q-pa-md">
    <div class="text-h4 q-mb-md text-weight-bold">Anime Catalog</div>

    <div class="row q-gutter-md q-mb-lg">
      <div class="col-12 col-sm-4">
        <q-input v-model="search" dense outlined dark label="Search title" @update:model-value="fetch">
          <template #prepend><q-icon name="search" /></template>
        </q-input>
      </div>
      <div class="col-6 col-sm-3">
        <q-select v-model="genreFilter" :options="['Action', 'Adventure', 'Drama', 'Fantasy', 'Sci-Fi', 'Slice of Life', 'Mecha']" dense outlined dark label="Genre" emit-value map-options clearable @update:model-value="fetch" />
      </div>
      <div class="col-6 col-sm-3">
        <q-select v-model="statusFilter" :options="['ongoing', 'completed', 'upcoming']" dense outlined dark label="Status" emit-value map-options clearable @update:model-value="fetch" />
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
          <q-img :src="item.poster_url" :ratio="2/3" fit="cover">
            <div class="absolute-bottom text-subtitle2 text-center bg-dark text-white">
              {{ item.title }}
            </div>
          </q-img>
        </q-card>
      </div>
    </div>
  </q-page>
</template>
