<script setup>
import { RouterLink, RouterView } from 'vue-router'

import Dashboard from './pages/master/dashboard.vue'

</script>

<template>
  <div>
    <Dashboard>
      <template #body>
        <RouterView/>
      </template>
    </Dashboard>
    
  </div>
</template>

<style scoped>

</style>
