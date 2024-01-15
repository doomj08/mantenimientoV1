<template>
    
    <EncabezadoVue v-if="false&&!showWindowSeccion"
        namePage="FORMATOS"  
    >
        <template #button_create>
            <CreateForm :clientes="clientes" @update="getFormatos()"/>

        </template>
    </EncabezadoVue>
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Formatos</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink to="/home" class="text-muted text-decoration-none">
                                Home
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Formatos</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <CreateForm  @update="getFormatos()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive mb-4" v-if="!showWindowSeccion">

                    <table class="table table-responsive border text-nowrap customize-table mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>

                                <th scope="col">
                                    <h6 class="fs-4 fw-semibold mb-0">#</h6>
                                </th>
                                <th scope="col">
                                    <h6 class="fs-4 fw-semibold mb-0">Cliente</h6>
                                </th>
                                <th scope="col">
                                    <h6 class="fs-4 fw-semibold mb-0">Versión</h6>
                                </th>
                                <th scope="col">
                                    <h6 class="fs-4 fw-semibold mb-0">Secciones</h6>
                                </th>

                                <th scope="col">
                                    <h6 class="fs-4 fw-semibold mb-0">Actions</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr v-for="(formato,index) in formatos" :key="index">

                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="d-flex align-items-center text-wrap">
                                        <div>{{ formato.id }}</div>
                                    </div>
                                </td>
                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="d-flex align-items-center text-wrap">
                                        <div>{{ formato.cliente_id }}</div>
                                    </div>
                                </td>
                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="d-flex align-items-center text-wrap">
                                        <button @click=openSeccion(formato.id)>Ver</button>
                                    </div>
                                </td>
                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="d-flex align-items-center text-wrap">
                                        {{ formato.version }}
                                    </div>
                                </td>
                            
                                <td class="p-4 space-x-2 whitespace-nowrap">
                                    <EditForm class="text-left" :id="formato.id" :clientes="clientes" @update="getFormatos()"/>

                                    <DeleteForm :name="formato.nombre_interno" url="formatos" :id="formato.id" @update="getFormatos()"/>
                                </td>
                            </tr>
                            
                            
                            
                            
                        </tbody>
                    </table>
              
    </div>
    <SeccionForm :formato_id="formatoId" v-if="showWindowSeccion"/>
</template>

<script setup>
    import axios from 'axios'
    import { ref, onMounted } from 'vue';
    import { confirmation } from '../../functions'
    import { useAuthStore } from '../../stores/auth';
    import { show_alerta } from '../../functions';
    import EncabezadoVue from '../../pages/master/encabezado.vue'
    import CreateForm from './Create.vue';
    import EditForm from './Edit.vue';
    import SeccionForm from '../SeccionFormatos/Index.vue';
    import DeleteForm from './Delete.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'
    
    const authStore = useAuthStore();
    const formatos=ref([]);
    const clientes=ref([]);
    const tipo_articulos=ref([]);
    const load=ref(false);

    const showWindowSeccion = ref(false)
    const formatoId=ref(null)

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getFormatos()})

    const openSeccion=(id)=>{
        formatoId.value=id
        showWindowSeccion.value=true
    }

    const getFormatos=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/formatos/', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                formatos.value=response.data.data.formatos
                clientes.value=response.data.data.clientes
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