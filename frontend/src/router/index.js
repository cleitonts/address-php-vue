import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'listAddress',
      component: () => import('../views/ListAddress.vue')
    },
    {
      path: '/address/:id',
      name: 'editAddress',
      component: () => import('../views/createAddress.vue')
    },
    {
      path: '/address',
      name: 'createAddress',
      component: () => import('../views/createAddress.vue')
    },
  ]
})

export default router
