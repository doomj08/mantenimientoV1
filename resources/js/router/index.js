import { createRouter, createWebHistory, createMemoryHistory } from 'vue-router'
import { useAuthStore} from '../stores/auth'
import HomeView from '../views/HomeView.vue'

import TipoArticulo from '../views/TipoArticulo/Index.vue'
import Articulos from '../views/Articulos/Index.vue'
import CampoPropiedades from '../views/CampoPropiedades/Index.vue'
import Clientes from '../views/Clientes/Index.vue'
import Formatos from '../views/Formatos/Index.vue'
import Informes from '../views/Informes/Index.vue'
import Propiedades from '../views/Propiedades/Index.vue'
import SeccionFormatos from '../views/SeccionFormatos/Index.vue'
import TicketVue from '../views/Ticket/Index.vue'
import PDFVue from '../views/Ticket/PDF.vue'
import TicketServicioVue from '../views/TicketServicio/Index.vue'
import PropiedadVue from '../views/Propiedad/Index.vue'

import Home from '../views/HomeView.vue'

import Login from '../views/User/Login.vue'
import Register from '../views/User/Register.vue'

const router = createRouter({
  history: createMemoryHistory(import.meta.env.BASE_URL),
  mode: 'abstract',
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: HomeView
    },
    {
      path: '/home',
      name: 'dashboard',
      component: HomeView
    },
    {
      path: '/ticket',
      name: 'ticket',
      component: TicketVue
    },
    {
      path: '/ticket_pdf:ticket_id',
      name: 'ticket_pdf',
      component: PDFVue,
      props: true,
    },
    {
      path: '/ticket_servicios/:ticket_id:ticket_num',
      name: 'ticket_servicios',
      component: TicketServicioVue,      
      props: true,
      
    },
    {
      path: '/propiedad:articulo_id/:nombre_interno/:tipo_articulo_id',
      name: 'propiedad',
      component: PropiedadVue,
      props: true,
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/register',
      name: 'register',
      component: Register
    },
    {
      path: '/home',
      name: 'home',
      component: HomeView
    },
    {
      path: '/tipo_articulos',
      name: 'tipo_articulos',
      component: TipoArticulo
    },
    {
      path: '/articulos',
      name: 'articulos',
      component: Articulos
    },
    {
      path: '/campo_propiedades',
      name: 'campo_propiedades',
      component: CampoPropiedades
    },
    {
      path: '/clientes',
      name: 'clientes',
      component: Clientes
    },
    {
      path: '/formatos',
      name: 'formatos',
      component: Formatos
    },
    {
      path: '/informes',
      name: 'informes',
      component: Informes
    },
    {
      path: '/propiedades',
      name: 'propiedades',
      component: Propiedades
    },
    {
      path: '/seccion_formatos',
      name: 'seccion_formatos',
      component: SeccionFormatos
    },
  ]
})

router.beforeEach(async (to)=>{
  const publicPages = ['/login','/register']
  const authRequired = !publicPages.includes(to.path)
  const auth = useAuthStore()
  if(authRequired && !auth.authUser){
    auth.returnUrl = to.fullPath
    return '/login'
  }
})

export default router
