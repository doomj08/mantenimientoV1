/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import 'flowbite';
import { createApp, markRaw } from 'vue'
import { createPinia } from 'pinia'
import createPersistedState from 'pinia-plugin-persistedstate'
import router from './router/index'
import axios from 'axios'

import money from 'v-money3'



window.axios = axios
//window.axios.defaults.baseURL='http://127.0.0.1:8000'
window.axios.defaults.baseURL='https://api21.itcomn.com/'
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import AppComponent from './App.vue';
app.component('app-component', AppComponent);

const pinia =createPinia()
pinia.use(({store})=>{
    store.router = markRaw(router)
})
pinia.use(createPersistedState)



app.use(pinia)
app.use(router)
app.use(money)

app.mount('#app')
