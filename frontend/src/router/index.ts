import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../pages/HomePage.vue'
import CatalogPage from '../pages/CatalogPage.vue'
import AnimeDetailPage from '../pages/AnimeDetailPage.vue'
import WatchlistPage from '../pages/WatchlistPage.vue'

const routes = [
  { path: '/', name: 'home', component: HomePage },
  { path: '/catalog', name: 'catalog', component: CatalogPage },
  { path: '/anime/:id', name: 'anime-detail', component: AnimeDetailPage },
  { path: '/watchlist', name: 'watchlist', component: WatchlistPage },
]

export const router = createRouter({
  history: createWebHistory(),
  routes,
})
