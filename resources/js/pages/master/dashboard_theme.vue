<script setup>
    import Sidebar from '../../components/SidebarTheme.vue'
    import {useAuthStore} from '../../stores/auth'
  const authStore = useAuthStore();
    //import EncabezadoVue from '../../pages/master/encabezado.vue'
    
</script>
<template>

  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <Sidebar v-if="authStore.user"/>
    <slot name="body" v-if="!authStore.user"/>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper" v-if="authStore.user">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>

          </ul>
  
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        <slot name="body" v-if="authStore.user"/>
        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">AdminMart.com</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a></p>
        </div>
      </div>
    </div>
  </div>
 

</template>