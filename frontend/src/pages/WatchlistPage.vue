<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { watchlistApi } from '../api/anime'

const router = useRouter()
const items = ref<any[]>([])
const loading = ref(true)
const error = ref('')

onMounted(async () => {
  await load()
})

async function load() {
  loading.value = true
  error.value = ''
  try {
    const data = await watchlistApi.list()
    items.value = Array.isArray(data) ? data : []
  } catch (e) {
    error.value = 'Failed to load watchlist.'
  } finally {
    loading.value = false
  }
}

async function remove(id: number) {
  try {
    await watchlistApi.remove(id)
    items.value = items.value.filter((w) => w.id !== id)
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
          <q-img :src="item.anime?.poster_url" :ratio="2/3" fit="cover" @click="goDetail(item.anime!.id)">
            <div class="absolute-bottom text-subtitle2 text-center bg-dark text-white">
              {{ item.anime?.title }}
            </div>
          </q-img>
          <q-card-actions align="center">
            <q-btn flat dense icon="delete" color="negative" label="Remove" @click="remove(item.id)" />
          </q-card-actions>
        </q-card>
      </div>
    </div>
  </q-page>
</template>
