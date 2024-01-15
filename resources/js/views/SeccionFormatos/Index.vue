<template>
    <EncabezadoVue 
        :namePage="'SECCIONES DE FORMATO ['+formato_id+']'"
        v-if="false"
    >
        <template #button_create>
            <CreateForm :formato_id="formato_id" @update="getSecciones()"/>

        </template>
    </EncabezadoVue>
    
    <div class="table-responsive mb-4">

                <table class="table table-responsive border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>

                            <th scope="col" >
                                <h6 class="fs-4 fw-semibold mb-0">Sección</h6>
                            </th>

                            <th scope="col" >
                                <h6 class="fs-4 fw-semibold mb-0">Actions</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr v-for="(seccion_formato,index) in secciones_formato" :key="index">

                            <td>
                                <div class="d-flex align-items-center text-wrap">
                                    {{ seccion_formato.seccion }}
                                </div>
                            </td>
                          
                            <td>
                                <div class="d-flex align-items-center text-wrap">
                                    <EditForm  @update="getSecciones()" class="text-left" :id="seccion_formato.id" :formato_id="formato_id"/>

                                    <DeleteForm @update="getSecciones()" :name="seccion_formato.nombre_interno" :url="'formatos/'+formato_id+'/seccion_formato'" :id="seccion_formato.id"/>
                                </div>
                            </td>
                        </tr>
                        
                        
                        
                        
                    </tbody>
                </table>
           
    </div>
</template>

<script setup>
    import axios from 'axios'
    import { ref, onMounted } from 'vue';
    import { confirmation } from '../../functions'
    import { useAuthStore } from '../../stores/auth';
    import { show_alerta } from '../../functions';
    import EncabezadoVue from '../../pages/master/encabezado.vue'
    import { Table, TableHead, TableBody, TableHeadCell, TableRow, TableCell, Breadcrumb, Button, Modal   } from 'flowbite-vue'
    import CreateForm from './Create.vue';
    import EditForm from './Edit.vue';
    import DeleteForm from './Delete.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'

    const props = defineProps({
        formato_id: Number,
    })
    
    const authStore = useAuthStore();
    const secciones_formato=ref([]);
    
    const load=ref(false);

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getSecciones()})

    const getSecciones=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/formatos/'+props.formato_id+'/seccion_formato', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                secciones_formato.value=response.data.data.secciones_formato
                
                console.log(response)
                res= response.data.status
                //show_alerta(response.data.message,'success','')
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
</script>