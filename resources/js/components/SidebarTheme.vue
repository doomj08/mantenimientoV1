<template>
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <router-link to="/" class="text-nowrap logo-img">
            <img src="/theme/assets/images/logos/dark-logo.svg" width="180" alt="" />
          </router-link>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <router-link class="sidebar-link" to="/home" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </router-link>
            </li>
            <li class="nav-small-cap" v-if="!authStore.user">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">AUTH</span>
            </li>
            <li class="sidebar-item" v-if="!authStore.user">
              <router-link to="/login" class="sidebar-link" aria-expanded="false">
                <span>
                  <i class="ti ti-login"></i>
                </span>
                <span class="hide-menu">Login</span>
              </router-link>
            </li>
            <li class="sidebar-item" v-if="!authStore.user">
              <router-link to="/register" class="sidebar-link"  aria-expanded="false">
                <span>
                  <i class="ti ti-user-plus"></i>
                </span>
                <span class="hide-menu">Register</span>
              </router-link>
            </li>
            <li class="nav-small-cap" v-if="authStore.user">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">TICKETS</span>
            </li>
            <li class="sidebar-item" v-if="authStore.user">
              <router-link to="/ticket" class="sidebar-link"  aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Tickets</span>
              </router-link>
            </li>
            <li class="nav-small-cap" v-if="authStore.user">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">ARTÍCULOS</span>
            </li>
            <li class="sidebar-item" v-if="authStore.user">
              <router-link to="/articulos" class="sidebar-link" aria-expanded="false">
                <span>
                  <i class="ti ti-alert-circle"></i>
                </span>
                <span class="hide-menu">Artículos</span>
              </router-link>
            </li>
            <li class="sidebar-item" v-if="authStore.user">
              <router-link to="/tipo_articulos" class="sidebar-link"  aria-expanded="false">
                <span>
                  <i class="ti ti-cards"></i>
                </span>
                <span class="hide-menu">Categorías</span>
              </router-link>
            </li>
            <li class="nav-small-cap" v-if="authStore.user">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">ROLES</span>
            </li>
            <li class="sidebar-item" v-if="authStore.user">
              <router-link to="/clientes" class="sidebar-link"  aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Usuarios</span>
              </router-link>
            </li>
            <li class="sidebar-item" v-if="authStore.user">
              <router-link to="/clientes" class="sidebar-link"  aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Clientes</span>
              </router-link>
            </li>
            <li class="nav-small-cap" v-if="authStore.user">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">CONFIGURACIÓN DOCUMENTOS</span>
            </li>
            <li class="sidebar-item" v-if="authStore.user">
              <router-link to="/formatos" class="sidebar-link" aria-expanded="false">
                <span>
                  <i class="ti ti-typography"></i>
                </span>
                <span class="hide-menu">Formatos</span>
              </router-link>
            </li>
            <li class="sidebar-item" v-if="authStore.user">
              <router-link to="/informes" class="sidebar-link" aria-expanded="false">
                <span>
                  <i class="ti ti-typography"></i>
                </span>
                <span class="hide-menu">Informes</span>
              </router-link>
            </li>

           
          </ul>
 
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
</template>
<script setup>

  import {useAuthStore} from '../stores/auth'
  import Logout from '../views/User/Logout.vue';
  import FirmaManoAlzada from '../views/User/FirmaManoAlzada.vue';
  import { ref } from 'vue'
  const authStore = useAuthStore();
  const isShowSideBar = ref(false)

  function openSideBar() {
    isShowSideBar.value = true
  }
  function closeSideBar() {
    isShowSideBar.value = false
  }

  function updateFirma() {
    console.log('actualizando firma')
    authStore.refreshFirma();
  }
</script>