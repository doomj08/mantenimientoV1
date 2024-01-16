<script setup>
import { Modal } from 'flowbite-vue'
import { ref } from 'vue'
import axios from 'axios'
import { Input, Button, Select, Textarea  } from 'flowbite-vue'
import { useAuthStore } from '../../stores/auth';
import {show_alerta, show_toast } from '../../functions';
import CreateForm from '../Articulos/Create.vue';

const props = defineProps({
  id: Number,
  ticket_id: Number,
  servicio_id:Number,
  cliente_id: Number,  
})
const authStore = useAuthStore();
const emit = defineEmits('update');

const isShowModal = ref(false)
const form = ref({articulos_seleccionados:[],servicio_id:props.servicio_id,ticket_id:props.ticket_id});
const articulos=ref([]);
const tipo_articulos=ref([]);

function closeModal() {
  isShowModal.value = false
}
function showModal() {
    getTicket()
  isShowModal.value = true

}

async function sendRequestWithFiles(method, params, url, redirect=''){
    const authStore = useAuthStore();
    let res;
    const config = {
        headers: {
            'Authorization': 'Bearer '+authStore.authToken,
        }
    };
    //await axios.post('/api/get_coordenadas',form,config)
    await axios(
        {
            method:method, url:url, data:params,headers:config.headers
        }
    )
    .then(
        (response) => {
            console.log(response)
            res= response.data.status,
            show_toast(response.data.message,'success','')
            emit('update')
            setTimeout(
                 ()=>(redirect!=='')?window.location.href=redirect:'',2000
             )
        }
    )
    .catch((e)=>{
        let desc='';
        res = e.data;
        console.log('errores')
        console.log(e.response)
        form.value.errors=e.response.data.errors
        show_alerta(e.response.data.message,'error','')
    });
    return res;
}


const save=()=>{
    sendRequestWithFiles('POST',form.value,'api/add_articulo/'+props.servicio_id);

    closeModal();
    
}

const getTicket=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/articulos_cliente/'+props.cliente_id+'/'+props.servicio_id, data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                articulos.value=response.data.data.articulos
                tipo_articulos.value=response.data.data.tipo_articulos
                form.value.articulos_seleccionados=response.data.data.articulos_select
                console.log(response)
                res= response.data.status
            }
        )
        .catch((e)=>{
        let desc='';
        res = e.data;
        console.log('errores')
        console.log(e)

    });
        return res;
    }

</script>
<template>
    <button @click="showModal" type="button"  class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Agregar artículos
            </button>
    <Modal :size="size" v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-lg">
          Selección de artículos
          <CreateForm :cliente_id="cliente_id" :tipo_articulos="tipo_articulos" @update="getTicket()"/>
        </div>
      </template>
      <template #body>
        
<ul class="grid grid-cols-4 gap-4 space-x-4">
    <li class="w-full border-b border-gray-200 sm:border-b-0 dark:border-gray-600" v-for="(articulo,index) in articulos" :key="index">
        <div class="flex items-center space-x-1">
            <input :id="index+'id'"  v-model="form.articulos_seleccionados" :true-value="[]" :value="articulo.id" type="checkbox"  class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
            <label :for="index+'id'" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ articulo.nombre_interno }}</label>
        </div>
    </li>


 
        
    </ul>


        
      </template>
      <template #footer>
        <div class="flex justify-between">
          <button @click="closeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
            Salir
          </button>
          <button @click="save()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Guardar
          </button>
        </div>
      </template>
    </Modal>
</template>