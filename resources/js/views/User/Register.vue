<script setup>
    import { ref } from 'vue';
    import { useAuthStore } from '../../stores/auth';
    import { Input, Button  } from 'flowbite-vue'
    const authStore = useAuthStore();
    const form = ref({name:'',email:'',password:''});
</script>
<template>
    <div>
        <Input size="sm" placeholder="enter your first name" v-model="form.name" label="Nombre" />
        <Input size="sm" placeholder="enter your first name" v-model="form.email" label="Email" />
        <Input size="sm" type="password" placeholder="enter your first name" v-model="form.password" label="Password" />
        <br>
        <Button size="sm" type="submit" @click="authStore.register(form)">Register</Button>
    </div>
</template>