<script setup>
import { Modal } from 'flowbite-vue'
import { ref } from 'vue'
import axios from 'axios'
import { Input, Button, Select  } from 'flowbite-vue'
import { useAuthStore } from '../../stores/auth';
import {show_alerta, show_toast } from '../../functions';

const props = defineProps({
  id: Number,
  tipo_articulo_id: Number,
})
const emit = defineEmits('update');
const authStore = useAuthStore();


const isShowModal = ref(false)
const form = ref({campo_propiedad:null,propiedad:null,errors:[],visible:0});

function closeModal() {
  isShowModal.value = false
}
function showModal() {
    getCampo()
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
    
    sendRequestWithFiles('PUT',form.value,'/api/propiedad/'+props.id);
    
}

const getCampo=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/propiedad/'+props.id, data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                form.value.propiedad=response.data.data.propiedad.propiedad
                form.value.campo_propiedad=response.data.data.propiedad.campo_propiedad
                if(response.data.data.propiedad.visible==1){
                    form.value.visible=true
                }
                else{
                    form.value.visible=false
                }
                
                
                console.log(response)
                
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
    <button  @click="showModal" type="button"  class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
        Editar
    </button>
    <Modal :size="size" v-if="isShowModal" @close="closeModal">
      <template #header>
        <div class="flex items-center text-lg">
          Propiedad {{ form.visible }}
        </div>
      </template>
      <template #body>
        <Input size="sm" class="text-left" v-model="form.propiedad" :label="form.campo_propiedad.nombre_propiedad" :validationStatus="(form.errors.nombre_interno?'error':'')">
            <template #validationMessage v-if="form.errors.nombre_interno">
                <ul>
                    <li v-for="(error,index) in form.errors.nombre_interno" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300 mt-4">¿Visible en Informe?</label>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox"  v-model="form.visible"  class="sr-only peer">
          <div class="w-11 h-6 bg-red-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-red-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
          <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ (form.visible)?'Visible':'Oculto'}}</span>
        </label>
        
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