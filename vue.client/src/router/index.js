import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import TelaInicial from '../components/TelaInicial'
import Entrada from '../views/Entrada'
import Saida from '../views/Saida'
import Products from '../views/Products'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    children: [
      {
        path: '/',
        component: TelaInicial
      },
      {
        path: '/Entrada',
        component: Entrada
      },
      {
        path: '/Saida',
        component: Saida
      },
      {
        path: '/Products',
        component: Products
      }
    ]
  },
  // {
  //   path: '/About',
  //   name: 'About',
  //   // route level code-splitting
  //   // this generates a separate chunk (about.[hash].js) for this route
  //   // which is lazy-loaded when the route is visited.
  //   component: About
  // }
]

const router = new VueRouter({
  routes
})

export default router
