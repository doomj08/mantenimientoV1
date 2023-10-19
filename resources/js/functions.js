import Swal from 'sweetalert2';
import { nextTick } from '@vue/runtime-core';

export function show_alerta(msj, icon, focus){
    if(focus!==''){
        nextTick(()=> focus.value.focus());
    }
    Swal.fire({
        title:msj,icon:icon,buttonsStyling:true
    });
}

export function show_toast(msj, icon, focus){
    if(focus!==''){
        nextTick(()=> focus.value.focus());
    }
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        timer: 3000,
        timerProgressBar: true
      })
      Toast.fire(msj, '', icon)
      return false

}

export function confirmation(name){

    const alert= Swal.mixin({buttonsStyling:true});
    
    alert.fire({
        title:'Desea eliminar '+name+'?',
        icon:'question',showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"></i>Yes, delete.',
        cancelButtonText:'<i class="fa-solid fa-ban"></i>Cancel',
    }).then( (result)=>{
        return true
        console.log('true')
    })
    return false
}

export async function sendRequest(method,params,url,redirect=''){

}