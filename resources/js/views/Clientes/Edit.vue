<script setup>
import { Modal } from 'flowbite-vue'
import { ref } from 'vue'
import axios from 'axios'
import { Input, Button, Select  } from 'flowbite-vue'
import { useAuthStore } from '../../stores/auth';
import {show_alerta, show_toast } from '../../functions';

const props = defineProps({
  id: Number,
  size:String
})

const emit = defineEmits('update');
const authStore = useAuthStore();
const tipo_articulos =ref([
    {value:'CC',name:'Cédula de ciudadanía'},
    {value:'NIT',name:'NIT'}
])

const isShowModal = ref(false)
const form = ref({nombre:'',tipo_documento:null,num_documento:null,direccion:null,ciudad:null,contacto:'',correo:'',telefono:'',errors:[]});

function closeModal() {
  isShowModal.value = false
}
function showModal() {
    getCliente()
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
        form.value.errors=e.response.data.errors
        console.log(e)
        
    });
    return res;
}

const save=()=>{
    
    sendRequestWithFiles('PUT',form.value,'/api/clientes/'+props.id);
    
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
                method:'GET', url:'api/clientes/'+props.id, data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                form.value.nombre=response.data.data.cliente.nombre
                form.value.tipo_documento=response.data.data.cliente.tipo_documento
                form.value.num_documento=response.data.data.cliente.num_documento
                form.value.contacto=response.data.data.cliente.contacto
                form.value.correo=response.data.data.cliente.correo
                form.value.telefono=response.data.data.cliente.telefono
                form.value.ciudad=response.data.data.cliente.ciudad
                form.value.direccion=response.data.data.cliente.direccion
                
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
        <div class="flex items-center text-lg">
          Editando Cliente {{ form.errors }}
        </div>
      </template>
      <template #body>
        <Input size="sm" v-model="form.nombre" label="Nombre" :validationStatus="(form.errors.nombre?'error':'')">
            <template #validationMessage v-if="form.errors.nombre">
                <ul>
                    <li v-for="(error,index) in form.errors.nombre" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        <div class="flex ">
            
                <Select class="w-1/2 pr-2" size="sm" v-model="form.tipo_documento" :options="tipo_articulos" label="Tipo de documento" :validationStatus="(form.errors.tipo_documento?'error':'')">
                    <template #validationMessage >
                        <ul>
                            <li v-for="(error,index) in form.errors.tipo_documento" :key="index">{{ error }}</li>
                        </ul>
                    </template>
                </Select>
            
                <Input class="w-1/2 pl-2" size="sm" v-model="form.num_documento" label="N° Documento" :validationStatus="(form.errors.num_documento?'error':'')">
                    <template #validationMessage >
                        <ul>
                            <li v-for="(error,index) in form.errors.num_documento" :key="index">{{ error }}</li>
                        </ul>
                    </template>
                </Input>
            
        </div>
        <div class="flex ">
            <Input size="sm" class="w-1/2 mr-1" v-model="form.contacto" label="Contacto" :validationStatus="(form.errors.contacto?'error':'')">
                <template #validationMessage >
                    <ul>
                        <li v-for="(error,index) in form.errors.contacto" :key="index">{{ error }}</li>
                    </ul>
                </template>
                </Input>
                <Input size="sm" class="w-1/2 ml-1" v-model="form.telefono" label="Teléfono" :validationStatus="(form.errors.telefono?'error':'')">
                    <template #validationMessage >
                    <ul>
                        <li v-for="(error,index) in form.errors.telefono" :key="index">{{ error }}</li>
                    </ul>
                </template>
            </Input>
        </div>
        <Input size="sm" type="email" v-model="form.correo" label="Correo" :validationStatus="(form.errors.correo?'error':'')">
            <template #validationMessage >
                <ul>
                    <li v-for="(error,index) in form.errors.correo" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        <Input size="sm" v-model="form.direccion" label="Dirección" :validationStatus="(form.errors.direccion?'error':'')">
            <template #validationMessage>
                <ul>
                    <li v-for="(error,index) in form.errors.direccion" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>
        <Input size="sm"  v-model="form.ciudad" label="Ciudad" :validationStatus="(form.errors.ciudad?'error':'')">
            <template #validationMessage >
                <ul>
                    <li v-for="(error,index) in form.errors.ciudad" :key="index">{{ error }}</li>
                </ul>
            </template>
        </Input>


        
      </template>
      <template #footer>
        <div class="flex justify-between">
          <button @click="closeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
            Cancelar
          </button>
          <button @click="save()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Actualizar
          </button>
        </div>
      </template>
    </Modal>
</template>