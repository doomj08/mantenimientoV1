<template>
    <EncabezadoVue 
        :namePage="'TICKET N° '+ticket_id"
        createButtonText="Agregar cliente"
    >
        <template #button_create>
            <CreateForm :ticket_id="ticket_id" @update="getActividades()" />
            <AddArticulo :cliente_id="props.clienteId" :ticket_id="ticket_id" @update="getActividades()" />

        </template>
    </EncabezadoVue>
    
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th>Artículos</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            <tr>
                            <td>
                                <kbd v-for="(articulo,index) in articulos_ticket" :key="index" class="inline-flex m-1 items-center px-2 py-1.5 text-gray-800 bg-green-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">
                                        
                                    <span class="">{{ articulo.articulo.nombre_interno }}</span>
                                </kbd>
                            </td>
                            </tr>
                        </tbody>
                    </table>    
                </div>    
            </div>
        </div>
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                N° 
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Fecha / Hora
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Descripción 
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Estado 
                            </th>

                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" v-for="(actividad,index) in actividades_ticket" :key="index">

                            <td class="items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ actividad.id }}</div>
                                </div>
                            </td>
                            <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ actividad.fecha_hora }}</div>
                                </div>
                            </td>
                            <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ actividad.descripcion }}</div>
                                </div>
                            </td>
                            <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ (actividad['estado-ticket']>0)?'Cerrado':'Abierto' }}</div>
                                </div>
                            </td>

                          
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <EditForm @update="getActividades()" class="text-left" :id="actividad.id"/>

                                <DeleteForm @update="getActividades()" :name="actividad.id" :url="'tickets/'+props.ticket_id+'/actividad_ticket'" :id="actividad.id"/>
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
    import { ref, onMounted,onBeforeMount } from 'vue';
    import { confirmation } from '../../functions'
    import { useAuthStore } from '../../stores/auth';
    import { show_alerta } from '../../functions';
    import EncabezadoVue from '../../pages/master/encabezado.vue'
    import CreateForm from './Create.vue';
    import AddArticulo from './AddArticulo.vue';
    import EditForm from './Edit.vue';
    import DeleteForm from './Delete.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'
    
    const authStore = useAuthStore();
    const actividades_ticket=ref([]);
    const articulos_ticket=ref([]);
    const cliente_id=ref([]);

    const load=ref(false);

    const props = defineProps({
        ticket_id: Number,
    })

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getActividades()})

    const getActividades=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/tickets/'+props.ticket_id+'/actividad_ticket/', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                actividades_ticket.value=response.data.data.actividades_ticket
                cliente_id.value=response.data.data.cliente_id
                articulos_ticket.value=response.data.data.articulos_ticket
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