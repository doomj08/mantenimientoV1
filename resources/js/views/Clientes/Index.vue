<template>
    <EncabezadoVue 
        namePage="CLIENTES"  
        createButtonText="Agregar cliente"
    >
        <template #button_create>
            <CreateForm @update="getClientes()"/>

        </template>
    </EncabezadoVue>
    
    <div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <Spinner v-if="load" color="red" size="6" class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600"/>
                <table v-else class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>

                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Nombre
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Documento
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Contacto
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Correo
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Teléfono
                            </th>

                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" v-for="(cliente,index) in clientes" :key="index">

                            <td class="items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ cliente.nombre }}</div>
                                </div>
                            </td>
                            <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-400 dark:text-white">{{ cliente.tipo_documento }}</div>
                                    <div class="text-base font-semibold text-gray-400 dark:text-white">{{ cliente.num_documento }}</div>
                                </div>
                            </td>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                {{cliente.contacto}}
                            </th>

                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                {{cliente.correo}}
                            </th>

                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                {{cliente.telefono}}
                            </th>
                          
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <EditForm class="text-left" :id="cliente.id" @update="getClientes()"/>

                                <DeleteForm :name="cliente.nombre" url="clientes" :id="cliente.id" @update="getClientes()"/>
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