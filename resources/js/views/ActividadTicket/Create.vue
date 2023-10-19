<script setup>
import { Modal } from 'flowbite-vue'
import { ref, onMounted } from 'vue';
import axios from 'axios'
import { Input, Button, Select, Textarea  } from 'flowbite-vue'
import { useAuthStore } from '../../stores/auth';
import {show_alerta, show_toast } from '../../functions';

const props = defineProps({
        ticket_id: Number,
    })

const emit = defineEmits('update');

const authStore = useAuthStore();
onMounted(()=>{getCliente()})

const isShowModal = ref(false)
const form = ref({descripcion:'',fecha_hora:null,estado_ticket:false, errors:[]});

const options_clientes=ref([]);

function closeModal() {
  isShowModal.value = false
}
function showModal() {
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
    
    sendRequestWithFiles('POST',form.value,'api/tickets/'+props.ticket_id+'/actividad_ticket/');
    
}

const getCliente=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/tickets/create', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
              options_clientes.value=response.data.data.clientes             
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
                Registrar Nueva Actividad
            </button>
    <Modal :size="size" v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-lg">
          Nuevo Ticket
        </div>
      </template>
      <template #body>
        <Textarea size="sm" v-model="form.descripcion" label="Descripcion / Falla" :validationStatus="(form.errors.descripcion?'error':'')">
            <template #validationMessage v-if="form.errors.descripcion">
                <ul>
                    <li v-for="(error,index) in form.errors.descripcion" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Textarea>
        
        <Input type="datetime-local" size="sm" v-model="form.fecha_hora" label="Fecha / Hora" :validationStatus="(form.errors.fecha_hora?'error':'')">
            <template #validationMessage v-if="form.errors.fecha_hora">
                <ul>
                    <li v-for="(error,index) in form.errors.fecha_hora" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>

        <br>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</label>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox"  v-model="form.estado_ticket"  class="sr-only peer">
          <div class="w-11 h-6 bg-red-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-red-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
          <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ (form.estado_ticket)?'Cerrado':'Abierto'}}</span>
        </label>

        
      </template>
      <template #footer>
        <div class="flex justify-between">
          <button @click="closeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
            Cancelar
          </button>
          <button @click="save()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Registrar
          </button>
        </div>
      </template>
    </Modal>
</template>