<template>
    <EncabezadoVue 
    v-if="false"
        namePage="INFORMES"  
        createButtonText="Agregar artículo"
    >
        <template #button_create>
            <CreateForm :tipo_articulos="tipo_articulos" @update="getInformes()"/>

        </template>
    </EncabezadoVue>
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Configuración  Informes</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink to="/home" class="text-muted text-decoration-none">
                                Home
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Informes</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <CreateForm  @update="getInformes()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive mb-4">

                <table class="table table-responsive border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>

                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Artículo</h6>
                            </th>
                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Versión Formato</h6>
                            </th>

                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Actions</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr v-for="(informe,index) in informes" :key="index">

                            <td>
                                <div class="d-flex align-items-center text-wrap">
                                    {{ informe.articulo_id }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center text-wrap">
                                    {{ informe.formato.version }}
                                </div>
                            </td>
                          
                            <td>
                                <div class="d-flex align-items-center text-wrap">
                                    <a target="_blank"  :href="'/informe/'+informe.id" class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                        Ver Informe</a>
                                    <EditForm class="text-left" :id="informe.id" @update="getInformes()"/>

                                    <DeleteForm :name="informe.nombre_interno" url="informes" :id="informe.id" @update="getInformes()"/>
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
    
    const authStore = useAuthStore();
    const informes=ref([]);
    const tipo_articulos=ref([]);
    const load=ref(false);

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getInformes()})

    const getInformes=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/informes/', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                informes.value=response.data.data.informes
                
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