<script setup>
import { Modal } from 'flowbite-vue'
import { ref } from 'vue'
import axios from 'axios'
import { Input, Button, Select, Textarea  } from 'flowbite-vue'
import { useAuthStore } from '../../stores/auth';
import {show_alerta, show_toast } from '../../functions';
import CreateForm from '../Articulos/Create.vue';

const props = defineProps({
  id_pago: Number,
  ticket_id: Number,
  servicio_id:Number,
})
const authStore = useAuthStore();
const emit = defineEmits('update');

const isShowModal = ref(false)
const form = ref({servicio_id:props.servicio_id,fecha:null,tipo_pago:null,entidad_bancaria:null,num_cuenta:null,referencia:null, concepto:null, valor:null ,ticket_id:props.ticket_id,errors:[]});

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
    getSelects()
    getPagos()
  isShowModal.value = true

}

const options_tipo_pagos=ref([]);

const save=()=>{
    sendRequestWithFiles('PUT',form.value,'api/tickets/'+props.ticket_id+'/servicio/'+props.servicio_id+'/pago/'+props.id_pago);

    closeModal();
    
}

const getSelects=async () =>{
    let res;
        const config = {
        headers: {
            'Authorization': 'Bearer '+authStore.authToken,
        }
    };
        await axios(
        {
            method:'GET', url:'api/tipo_pagos_select', data:null,headers:config.headers
        }
    )
    .then(
        (response) => {
            options_tipo_pagos.value=response.data.data.select_tipo_pagos          
                
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
const getPagos=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/tickets/'+props.ticket_id+'/servicio/'+props.servicio_id+'/pago/'+props.id_pago, data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                
                form.value.fecha=response.data.data.servicio_pago.fecha
                form.value.tipo_pago=response.data.data.servicio_pago.tipo_pago
                form.value.entidad_bancaria =response.data.data.servicio_pago.banco
                form.value.num_cuenta =response.data.data.servicio_pago.num_cuenta
                form.value.referencia =response.data.data.servicio_pago.referencia
                form.value.concepto =response.data.data.servicio_pago.concepto
                form.value.valor =response.data.data.servicio_pago.valor                
                
                
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
    <button @click="showModal" type="button"  class="flex flex-col py-1 px-2  items-center bg-green-200 border border-gray-200 rounded-lg shadow md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">  
        <slot></slot>
    </button>
    <Modal :size="size" v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-lg">
          Registro de pagos
        </div>
      </template>
      <template #body>
        <Input type="date" size="sm" v-model="form.fecha" label="Fecha del pago" :validationStatus="(form.errors.fecha?'error':'')">
            <template #validationMessage v-if="form.errors.fecha">
                <ul>
                    <li v-for="(error,index) in form.errors.fecha" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        
        <Select size="sm" v-model="form.tipo_pago" :options="options_tipo_pagos" label="Tipo de pago" :validationStatus="(form.errors.tipo_pago?'error':'')">
            <template #validationMessage v-if="form.errors.tipo_pago">
                  <ul>
                      <li v-for="(error,index) in form.errors.tipo_pago" :key="index">{{ error }}</li>
                  </ul>
              </template>
          </Select>
        <Input size="sm" v-model="form.entidad_bancaria" label="Entidad Bancaria" :validationStatus="(form.errors.entidad_bancaria?'error':'')">
            <template #validationMessage v-if="form.errors.entidad_bancaria">
                <ul>
                    <li v-for="(error,index) in form.errors.entidad_bancaria" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        <Input size="sm" v-model="form.num_cuenta" label="Cuenta" :validationStatus="(form.errors.num_cuenta?'error':'')">
            <template #validationMessage v-if="form.errors.num_cuenta">
                <ul>
                    <li v-for="(error,index) in form.errors.num_cuenta" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>

        <Input size="sm" v-model="form.referencia" label="Referencia" :validationStatus="(form.errors.referencia?'error':'')">
            <template #validationMessage v-if="form.errors.referencia">
                <ul>
                    <li v-for="(error,index) in form.errors.referencia" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        <Input size="sm" v-model="form.concepto" label="Concepto" :validationStatus="(form.errors.concepto?'error':'')">
            <template #validationMessage v-if="form.errors.concepto">
                <ul>
                    <li v-for="(error,index) in form.errors.concepto" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        <br>
        <label for="" class="text-black">Valor</label>
        <money3 class="w-full" v-model="form.valor" v-bind="config"></money3>
        <br>
        


        
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