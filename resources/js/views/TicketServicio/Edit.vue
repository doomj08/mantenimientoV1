<script setup>
import { Modal } from 'flowbite-vue'
import { ref } from 'vue'
import axios from 'axios'
import { Input, Button, Select, Textarea  } from 'flowbite-vue'
import { useAuthStore } from '../../stores/auth';
import {show_alerta, show_toast } from '../../functions';

const props = defineProps({
  id: Number,
  ticket_id: Number,
  servicio_id:Number,
  size:String
})
const authStore = useAuthStore();
const emit = defineEmits('update');

const isShowModal = ref(false)
const form = ref({ticket_id:null,descripcion:'',fecha_programada:null,fecha_inicio:null,fecha_fin:null,precio:null,tiene_iva:false,errors:[]});
const options_clientes=ref([]);

const config= {
          masked: false,
          prefix: '$',
          suffix: '',
          thousands: '.',
          decimal: ',',
          precision: 2,
          disableNegative: false,
          disabled: false,
          min: null,
          max: null,
          allowBlank: false,
          minimumNumberOfCharacters: 0,
          shouldRound: false,
          focusOnRight: false,
        }

function closeModal() {
  isShowModal.value = false
}
function showModal() {
    getServicio()
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
             closeModal();
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

const save=()=>{
    
    //sendRequestWithFiles('PUT',form.value,'api/edit_actividad/'+props.ticket_id+'/'+props.id);
    sendRequestWithFiles('PUT',form.value,'api/tickets/'+props.ticket_id+'/servicio/'+props.servicio_id);
    
}

const getServicio=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/tickets/'+props.ticket_id+'/servicio/'+props.servicio_id+'/edit', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                form.value.descripcion=response.data.data.servicio.descripcion
                form.value.fecha_programada =response.data.data.servicio.fecha_programada
                form.value.fecha_inicio=response.data.data.servicio.fecha_inicio
                form.value.fecha_fin=response.data.data.servicio.fecha_fin
                form.value.precio=response.data.data.servicio.precio
                form.value.tiene_iva=(response.data.data.servicio.tiene_iva==1)?true:false,
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
    <button  @click="showModal" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
        Editar
    </button>
    <Modal :size="size" v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-md">
          Editando Servicio
        </div>
      </template>
      <template #body>
        <Textarea size="sm" class="w-full" v-model="form.descripcion" label="Descripcion" :validationStatus="(form.errors.descripcion?'error':'')">
            <template #validationMessage v-if="form.errors.descripcion">
                <ul>
                    <li v-for="(error,index) in form.errors.descripcion" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Textarea>
        <Input type="datetime-local" size="sm" v-model="form.fecha_programada" label="Fecha/Hora Programada" :validationStatus="(form.errors.fecha_programada?'error':'')">
            <template #validationMessage v-if="form.errors.fecha_programada">
                <ul>
                    <li v-for="(error,index) in form.errors.fecha_hora" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        <br>
        <div class="flex">
            <Input type="datetime-local" size="sm" v-model="form.fecha_inicio" label="Fecha / Hora Inicio" :validationStatus="(form.errors.fecha_inicio?'error':'')">
                <template #validationMessage v-if="form.errors.fecha_inicio">
                    <ul>
                        <li v-for="(error,index) in form.errors.fecha_hora" :key="index">{{ error }}</li>
                    </ul>
                </template>
            </Input>
            <Input type="datetime-local" size="sm" v-model="form.fecha_fin" label="Fecha / Hora Final" :validationStatus="(form.errors.fecha_fin?'error':'')">
                <template #validationMessage v-if="form.errors.fecha_fin">
                    <ul>
                        <li v-for="(error,index) in form.errors.fecha_fin" :key="index">{{ error }}</li>
                    </ul>
                </template>
            </Input>
        </div>
        <br>
        <label for="" class="text-black">Precio</label>
        <money3 class="w-full" v-model="form.precio" v-bind="config"></money3>
        <br>
        
            <br>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</label>
            <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox"  v-model="form.tiene_iva"  class="sr-only peer">
            <div class="w-11 h-6 bg-red-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-red-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ (form.tiene_iva==1)?'Más IVA':'Sin IVA'}}</span>
            </label>
            <br>
        <div v-if="false">
        <br>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</label>
            <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox"  v-model="form.estado_ticket"  class="sr-only peer">
            <div class="w-11 h-6 bg-red-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-red-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ (form.estado_ticket)?'Cerrado':'Abierto'}}</span>
            </label>
        </div>
        
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