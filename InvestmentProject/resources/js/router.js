import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Investments from './components/Index.vue';
import Create from './components/Create.vue';
import InvestmentDetails from './components/InvestmentDetails.vue';

const routes = [
    { path: '/', redirect: '/investments' }, // Redirect root to /investments
    { path: '/login', name: 'Login', component: Login, meta: { guest: true } },
    { path: '/register', name: 'Register', component: Register, meta: { guest: true } },
    { path: '/investments', name: 'Investments', component: Investments, meta: { requiresAuth: true } },
    { path: '/investments/create', name: 'Create', component: Create, meta: { requiresAuth: true } },
    { path: '/investments/:id', name: 'InvestmentDetails', component: InvestmentDetails, props: true, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = localStorage.getItem('token');
    if (token) {
      next();
    } else {
      next('/login');
    }
  } else {
    next();
  }
});


export default router;
