<template>
    <SeccionForm :formato_id="formatoId" v-if="showWindowSeccion"/>
    <EncabezadoVue v-if="!showWindowSeccion"
        namePage="FORMATOS"  
    >
        <template #button_create>
            <CreateForm :clientes="clientes" @update="getFormatos()"/>

        </template>
    </EncabezadoVue>
    
    <div class="flex flex-col" v-if="!showWindowSeccion">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>

                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    #
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Cliente
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Versión
                                </th>
                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Secciones
                                </th>

                                <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" v-for="(formato,index) in formatos" :key="index">

                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-500 dark:text-white">{{ formato.id }}</div>
                                    </div>
                                </td>
                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ formato.cliente_id }}</div>
                                    </div>
                                </td>
                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <button @click=openSeccion(formato.id)>Ver</button>
                                    </div>
                                </td>
                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ formato.version }}</div>
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
            </div>
        </div>
    </div>
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