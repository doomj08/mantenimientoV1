<template>
    <EncabezadoVue   
        :namePage="'TICKET N° '+ticket.num_ticket+' ticket_id:'+ticket.id"
        to2="Ticket"
        to3="Servicios"
        :descripcion="ticket.descripcion"
    >
        <template #button_create>
            <CreateForm :ticket_id="ticket.id" @update="getActividades()" />
            

        </template>
    </EncabezadoVue>
    <Accordion flush>
        <accordion-panel  v-for="(servicio, index) in servicios" :key="index">
        <accordion-header>
            <table 
                class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <tbody  class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <tr>
                        <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                        Descripción
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                        Fecha / Hora Programada
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                        Fecha / Hora Inicio- Fin
                    </th>
                    <th v-if="false" scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                        Artículos / Ítems
                    </th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                        Actions
                    </th>
                    </tr>
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-500">
                                <td class="items-center p-4 mr-12 whitespace-nowrap">
                                    <div class="text-xs font-normal">
                                        <div class=" font-semibold text-gray-900  dark:text-white">{{ (servicio.precio)?'$'+servicio.precio:'' }}</div>
                                    </div>
                                    <div class="text-sm font-normal">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ servicio.descripcion }}</div>
                                    </div>

                                </td>
                                <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ servicio.fecha_programada }}</div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ servicio.fecha_inicio }}</div>
                                    </div>
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">{{ servicio.fecha_fin }}</div>
                                    </div>
                                </td>
                                <td v-if="false" class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <kbd v-for="(articulo,index) in servicio.servicio_articulos" :key="index" class="inline-flex m-1 items-center px-2 py-1.5 text-gray-800 bg-green-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">
                                            <span class="">{{ articulo.nombre_interno }}</span>
                                        </kbd>
                                    </div>
                                </td>


                                <td class="p-4 space-x-2 whitespace-nowrap">{{ ticket.cliente_id}}
                                    <AddArticulo :cliente_id="ticket.cliente_id" :servicio_id="servicio.id" :ticket_id="ticket_id" @update="getActividades()" />
                                    <AddActividad :ticket_id="ticket_id" :servicio_id="servicio.id" @update="getActividades()"/>
                                    <EditForm @update="getActividades()" class="text-left" :ticket_id="servicio.ticket_id" :servicio_id="servicio.id"/>
                                    <DeleteForm @update="getActividades()" :name="servicio.id" :url="'tickets/'+props.ticket_id+'/servicio'" :id="servicio.id"/>
                                </td>
                            </tr>
                    </tbody>
                </table>
            
        </accordion-header>
        <accordion-content>
          <div class="flex">
            <div class="w-full">
                <div class="w-full">
                    <div href="#" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                        v-for="(actividad,index) in servicio.actividades" :key="index"
                        >
                            <svg v-if="actividad.estado_ticket=='cerrado'" class="mx-14 w-[25px] h-[25px] text-green-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                            <svg v-else class="mx-14 w-[25px] h-[25px] text-red-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            {{ actividad.estado_ticket }}
                            <div class="flex flex-col justify-between p-4 leading-normal">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ actividad.fecha_hora }}</h5>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><strong>Actividad realizada: </strong>{{ actividad.descripcion }}</p>
                            </div>
                            
                            <EditActividad :actividad_id="actividad.id" :ticket_id="servicio.ticket_id" @update="getActividades()" />
                            <DeleteActividad @update="getActividades()" :name="servicio.id" :url="'delete_actividad/'+props.ticket_id" :id="actividad.id"/>
                    </div>
                </div>
            </div>
            <div class="w-1/2">
                <div href="#" class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                    
                >
                <kbd v-for="(articulo,index) in servicio.servicio_articulos" :key="index" class="inline-flex m-1 items-center px-2 py-1.5 text-gray-800 bg-green-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">
                    
                    <span class="">{{ articulo.nombre_interno }}</span>
                </kbd>
                </div>

            </div>  
          </div>



            
        </accordion-content>
        </accordion-panel>

        
    </Accordion>

    
</template>

<script setup>
    import axios from 'axios'
    import { ref, onMounted,onBeforeMount } from 'vue';
    import { confirmation } from '../../functions'
    import { useAuthStore } from '../../stores/auth';
    import { show_alerta } from '../../functions';
    import EncabezadoVue from '../../pages/master/encabezado.vue'
    import CreateForm from './Create.vue';
    import AddActividad from './AddActividad.vue';
    import AddArticulo from './AddArticulo.vue';
    import EditActividad from '../TicketActividad/Edit.vue';
    import DeleteActividad from '../TicketActividad/Delete.vue';
    import EditForm from './Edit.vue';
    import DeleteForm from './Delete.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'

    
    import { Accordion, AccordionPanel, AccordionHeader, AccordionContent, Badge, Button } from 'flowbite-vue'
    
    
    const authStore = useAuthStore();
    const ticket=ref([]);
    const actividades_ticket=ref([]);
    const articulos_ticket=ref([]);
    const cliente_id=ref([]);
    const servicios=ref([]);

    const load=ref(false);

    const props = defineProps({
        ticket_id: Number,
        ticket_num: Number,
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
                method:'GET', url:'api/tickets/'+props.ticket_num+'/servicio/', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                servicios.value=response.data.data.servicios
                ticket.value=response.data.data.ticket
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