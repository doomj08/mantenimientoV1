<script setup>
import { Modal } from 'flowbite-vue'
import { ref, onMounted, computed  } from 'vue';
import axios from 'axios'
import { Input, Button, Select, Textarea  } from 'flowbite-vue'
import { useAuthStore } from '../../stores/auth';
import {show_alerta, show_toast } from '../../functions';
import money from 'v-money3'

const props = defineProps({
        ticket_id: Number,
    })

const f = new Intl.NumberFormat('es-CO',{
    style:'currency',
    currency:'COP',
    minimumFractionDigits:2
});

const formatoMoneda = computed(() => {
  return f.format(form.value.precio)
})

const emit = defineEmits('update');

const authStore = useAuthStore();
onMounted(()=>{getCliente()})

const isShowModal = ref(false)
const form = ref({ticket_id:null,descripcion:'',fecha_programada:null,fecha_inicio:null,fecha_fin:null,tiene_iva:false,precio:null,errors:[]});

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

const options_clientes=ref([]);

function closeModal() {
  isShowModal.value = false
}
function showModal() {
    form.ticket_id=props.ticket_id
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
    form.value.ticket_id=props.ticket_id
    sendRequestWithFiles('POST',form.value,'api/tickets/'+props.ticket_id+'/servicio');
    
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
                method:'GET', url:'api/tickets/'+props.ticket_id+'/servicio/create', data:null,headers:config.headers
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
                Agregar Servicio
            </button>
    <Modal :size="size" v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-md">
          Nuevo Servicio
        </div>
      </template>
      <template #body class="text-left">
        
        <Textarea size="" class="w-full" v-model="form.descripcion" label="Descripcion" :validationStatus="(form.errors.descripcion?'error':'')">
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
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">IVA</label>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox"  v-model="form.tiene_iva"  class="sr-only peer">
          <div class="w-11 h-6 bg-red-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-red-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
          <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ (form.tiene_iva)?'Más IVA':'Sin IVA'}}</span>
        </label>


        <br>
        

        
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