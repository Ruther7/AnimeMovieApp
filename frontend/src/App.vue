<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { watchlistApi } from './api/anime'

const watchlistCount = ref(0)

async function loadCount() {
  try {
    const data = await watchlistApi.list()
    watchlistCount.value = Array.isArray(data) ? data.length : 0
  } catch {
    watchlistCount.value = 0
  }
}

onMounted(() => {
  loadCount()
})
</script>

<template>
  <q-layout view="lHh lpr lFf">
    <q-header elevated class="bg-dark text-white">
      <q-toolbar class="q-gutter-md">
        <q-btn flat round dense icon="movie" aria-label="Menu" />
        <q-toolbar-title class="text-weight-bold">
          Anime Movie App
        </q-toolbar-title>
        <q-btn flat label="Home" to="/" class="q-ml-md" />
        <q-btn flat label="Catalog" to="/catalog" />
        <q-btn flat :label="`Watchlist (${watchlistCount})`" to="/watchlist" />
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>
