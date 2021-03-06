import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import TelaInicial from '../components/TelaInicial'
import Entrada from '../views/Entrada'
import Saida from '../views/Saida'
import Products from '../views/Products'
import Fornecedores from '../views/Fornecedores'
import Transportadoras from '../views/Transportadoras'
import Filiais from '../views/Filiais'
import Login from '../views/Login'
import Erro from '../views/Erro'
import Categorias from '../views/Categorias'
import ContatoFornecedores from '../views/ContatoFornecedores'
import ContatoTransportadoras from '../views/ContatoTransportadoras'
import ContatoFiliais from '../views/ContatoFiliais'

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
      },
      {
        path: '/Fornecedores',
        component: Fornecedores,
      },
      {
        path: '/ContatoFornecedores/:id',
        component: ContatoFornecedores,
        params: true
      },
      {
        path: '/Transportadoras',
        component: Transportadoras
      },
      {
        path: '/ContatoTransportadoras/:id',
        component: ContatoTransportadoras,
        params: true
      },
      {
        path: '/Filiais',
        component: Filiais
      },
      {
        path: '/ContatoFiliais/:id',
        component: ContatoFiliais,
        params: true
      },
      {
        path: '/Categorias',
        component: Categorias
      },
    ]
  },
  {
    path: '/Login',
    name: 'Login',
    component: Login
  },
  {
    path: '/erro',
    name: 'Erro',
    component: Erro
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
