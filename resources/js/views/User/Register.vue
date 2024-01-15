<script setup>
    import { ref } from 'vue';
    import { useAuthStore } from '../../stores/auth';
    import { Input, Button  } from 'flowbite-vue'
    const authStore = useAuthStore();
    const form = ref({name:'',email:'',password:''});
</script>
<template>
    <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  
                </a>
                  <div class="mb-3">
                    <label for="exampleInputtext1" class="form-label">Name</label>
                    <input type="text" v-model="form.name" class="form-control" id="exampleInputtext1" aria-describedby="textHelp">
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                    <input type="email" v-model="form.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" v-model="form.password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" @click="authStore.register(form)">Registrarse</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Ya tienes una cuenta?</p>
                    <RouterLink to="/login" class="text-primary fw-bold ms-2">Iniciar sesión</RouterLink>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>