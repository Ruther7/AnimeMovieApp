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
const featured = ref<Anime | null>(null)
const popular = ref<Anime[]>([])
const recent = ref<Anime[]>([])
const loading = ref(true)
const error = ref('')

onMounted(async () => {
  try {
    const data = await animeApi.list()
    const items = Array.isArray(data.data) ? data.data : []
    featured.value = items[0] || null
    popular.value = items.slice(0, 5)
    recent.value = items.slice(0, 8)
  } catch (e) {
    error.value = 'Failed to load featured content.'
  } finally {
    loading.value = false
  }
})

function goDetail(id: number) {
  router.push(`/anime/${id}`)
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

    <template v-else>
      <div v-if="featured" class="banner-section">
        <div class="banner-image" :style="`background-image: url('${featured.banner_url || featured.poster_url}')`">
          <div class="banner-overlay">
            <div class="banner-content">
              <div class="text-h3 text-weight-bold">{{ featured.title }}</div>
              <p class="text-subtitle1 q-mt-sm">{{ featured.synopsis }}</p>
              <q-btn color="primary" label="View Details" class="q-mt-md" @click="goDetail(featured.id)" />
            </div>
          </div>
        </div>
      </div>

      <div class="q-pa-md">
        <div class="text-h5 q-mb-md text-weight-bold">Popular Titles</div>
        <div class="row q-gutter-md">
          <div v-for="item in popular" :key="item.id" class="col-6 col-sm-4 col-md-2">
            <q-card class="bg-dark-card cursor-pointer" @click="goDetail(item.id)">
              <q-img :src="item.poster_url" :ratio="2/3" fit="cover">
                <div class="absolute-bottom text-subtitle2 text-center bg-dark text-white">
                  {{ item.title }}
                </div>
              </q-img>
            </q-card>
          </div>
        </div>

        <div class="text-h5 q-mb-md q-mt-xl text-weight-bold">Recently Added</div>
        <div class="row q-gutter-md">
          <div v-for="item in recent" :key="item.id" class="col-6 col-sm-4 col-md-2">
            <q-card class="bg-dark-card cursor-pointer" @click="goDetail(item.id)">
              <q-img :src="item.poster_url" :ratio="2/3" fit="cover">
                <div class="absolute-bottom text-subtitle2 text-center bg-dark text-white">
                  {{ item.title }}
                </div>
              </q-img>
            </q-card>
          </div>
        </div>
      </div>
    </template>
  </q-page>
</template>

<style scoped>
.banner-section {
  width: 100%;
  height: 50vh;
  min-height: 320px;
}
.banner-image {
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  position: relative;
}
.banner-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.9), rgba(0,0,0,0.3));
  display: flex;
  align-items: flex-end;
}
.banner-content {
  padding: 2rem;
  max-width: 800px;
}
</style>
