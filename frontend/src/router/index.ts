import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import AboutView from '@/views/AboutView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import AccountInformation from '../components/AccountInformation.vue'
import MainHome from '@/components/MainHome.vue'
import TasksCategories from '@/components/TasksCategories.vue'
import NotFound from '@/views/NoFoundView.vue'
import Tasks from '@/components/MyTasks.vue'
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      children: [
        { path: '/profile', component: AccountInformation },
        { path: '/daskboard', component: MainHome },
        { path: '/categories', component: TasksCategories },
        {
          path: '/tasks',
          component: Tasks,
        },
        {
          path: '/:pathMatch(.*)*',
          name: 'not-found',
          component: NotFound,
        },
      ],
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: '/about',
      name: 'about',
      component: AboutView,
    },

    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: NotFound,
    },
  ],
})
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !localStorage.getItem('token')) {
    next('/login')
  } else {
    next()
  }
})

export default router
