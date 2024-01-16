<script setup>
import Swal from 'sweetalert2';
import { Modal } from 'flowbite-vue'
import { ref } from 'vue'
import axios from 'axios'
import { useAuthStore } from '../../stores/auth';
import {show_alerta } from '../../functions';
import { confirmation } from '../../functions';

const props = defineProps({
    name:String,
    url:String,
    redirect:String,
    id:Number
})

const emit = defineEmits('update');
const authStore = useAuthStore();

async function deleteRequest(method, params, url, redirect=''){
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
            show_alerta(response.data.message,'success','')
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
        console.log(e)
        show_alerta(e.response.data.message,'error','')
    });
    return res;
}

const eliminar=(name)=>{
    
    const alert= Swal.mixin({buttonsStyling:true});
    alert.fire({
        title:'Desea eliminar '+name+'?',
        icon:'question',showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i>Yes, delete.',
        cancelButtonText:'<i class="fa-solid fa-ban"></i>Cancel',
    }).then( (result)=>{
        if(result.isConfirmed){
            deleteRequest('DELETE',null,'api/'+props.url+'/'+props.id);
        }        
    })
    

        
    
}

</script>
<template>
    <button @click="eliminar(name)" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
        Eliminar
    </button>
</template>