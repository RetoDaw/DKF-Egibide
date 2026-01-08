import LoginView from "@/pages/Authentication/LoginView.vue";
import DashboardView from "@/pages/DashboardView.vue";
import { useAuthStore } from "@/stores/auth";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
    path: '/login',
    name: 'login',
    component: LoginView,
    meta: { guest: true },
    },
    {
      path: '/',
      name: 'dashboard',
      component: DashboardView,
      meta: { requiresAuth: true },
    },
  ],
});

router.beforeEach((to) => {
  const auth = useAuthStore();

  if (to.meta.requiresAuth && !auth.token) {
    return { name: 'login' }
  }

  if (to.meta.guest && auth.token) {
    return { name: 'dashboard' }
  }
})


export default router;
