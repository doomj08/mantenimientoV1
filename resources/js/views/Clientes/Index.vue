<template>
    <EncabezadoVue v-if="false"
        namePage="CLIENTES"  
        createButtonText="Agregar cliente"
    >
        <template #button_create>
            <CreateForm @update="getClientes()"/>

        </template>
    </EncabezadoVue>
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Clientes</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink to="/home" class="text-muted text-decoration-none">
                                Home
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Clientes</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <CreateForm  @update="getClientes()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive mb-4">

                <Spinner v-if="load" color="red" size="6" class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600"/>
                <table v-else class="table table-responsive border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>

                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Nombre</h6>
                            </th>
                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Documento</h6>
                            </th>
                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Contacto</h6>
                            </th>
                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Correo</h6>
                            </th>
                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Teléfono</h6>
                            </th>

                            <th scope="col">
                                <h6 class="fs-4 fw-semibold mb-0">Actions</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr v-for="(cliente,index) in clientes" :key="index">

                            <td>
                                <div class="d-flex align-items-center text-wrap">
                                    {{ cliente.nombre }}
                                </div>
                            </td>
                            <td>
                                <div class=" align-items-center text-wrap">
                                    <span class="block">{{ cliente.tipo_documento }}</span>
                                    <span class="block">{{ cliente.num_documento }}</span>
                                </div>
                            </td>
                            <td >
                                <div class="d-flex align-items-center text-wrap">
                                    {{cliente.contacto}}
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center text-wrap">
                                    {{cliente.correo}}
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    {{cliente.telefono}}
                                </div>
                                
                            </td>
                          
                            <td>
                                <div class=" align-items-center">
                                    <div class="block w-full">
                                        <EditForm :id="cliente.id" @update="getClientes()"/>
                                    </div>
                                    <div class="block w-full">
                                        <DeleteForm class="block" :name="cliente.nombre" url="clientes" :id="cliente.id" @update="getClientes()"/>
                                    </div>
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
    import { useAuthStore } from '../../stores/auth';
    import { show_alerta } from '../../functions';
    import EncabezadoVue from '../../pages/master/encabezado.vue'    
    import CreateForm from './Create.vue';
    import EditForm from './Edit.vue';
    import DeleteForm from './Delete.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'
    import { Spinner  } from 'flowbite-vue'
    
    const authStore = useAuthStore();
    const clientes=ref([]);

    const load=ref(false);

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getClientes()})

    const getClientes=async () =>{
        load.value=true
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/clientes/', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                clientes.value=response.data.data.clientes
                
                console.log(response)
                res= response.data.status
                
            }
        )
        .catch((e)=>{
            let desc='';
            res = e.data;
            console.log('errores')
            console.log(e)
            show_alerta(e.response.data.message,'error','')
        }).finally(()=>{
            load.value=false
        });
        return res;
    }
</script>