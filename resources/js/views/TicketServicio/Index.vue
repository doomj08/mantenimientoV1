<template>
    <EncabezadoVue  
    v-if="false" 
        :namePage="'TICKET N° '+ticket.num_ticket+' ticket_id:'+ticket.id"
        to2="Ticket"
        to3="Servicios"
        :descripcion="ticket.descripcion"
    >
        <template #button_create>
            <CreateForm :ticket_id="ticket.id" @update="getActividades()" />
            

        </template>
    </EncabezadoVue>
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-8">
                    <h4 class="fw-semibold mb-8">Servicios del Ticket N° {{ticket.num_ticket}}</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink to="/home" class="text-muted text-decoration-none">
                                Home
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item">
                            <RouterLink to="/ticket" class="text-muted text-decoration-none">
                                Tickets
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Servicios</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-4">
                    <div class="text-center mb-1">
                        <CreateForm :ticket_id="ticket.id"  @update="getActividades()"/>
                        <AddRecomendacion :ticket_id="ticket.id" @update="getActividades()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full">
        <strong>Recomendaciones</strong>
        <ul style="list-style:disc; padding-left: 30px;">
            <li v-for="(recomendacion,index) in ticket.recomendaciones" :key="index">
                {{ recomendacion.recomendacion }}
                <EditRecomendacion @update="getActividades()" :recomendacion_id="recomendacion.id" :ticket_id="ticket.id"/>
                <DeleteRecomendacon @date="getActividades()" :recomendacion_id="recomendacion.id" :name="recomendacion.id" :url="'tickets/'+props.ticket_id+'/servicio'" :id="servicio.id"/>

            </li>
        </ul>
       
    </div>
    <Accordion flush>
        <accordion-panel  v-for="(servicio, index) in servicios" :key="index">
        <accordion-header>
            <div class="card">
                    <div class="card-header d-flex">
                        <div class="w-2/3">
                            {{ servicio.descripcion }} <br>
                        </div>
                        <div class="w-1/3">
                            <EditForm @update="getActividades()" class="text-left" :ticket_id="servicio.ticket_id" :servicio_id="servicio.id"/>
                            <DeleteForm @update="getActividades()" :name="servicio.id" :url="'tickets/'+props.ticket_id+'/servicio'" :id="servicio.id"/>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-resposive">
                            <thead>
                                <tr>
                                    <th>Fecha/Hora programada</th>
                                    <th>Fecha/Hora Iniciación</th>
                                    <th>Fecha/Hora Finalización</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ servicio.fecha_programada }}</td>
                                    <td>{{ servicio.fecha_inicio }}</td>
                                    <td>{{ servicio.fecha_fin }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <AddPago  v-if="true" 
                                            :servicio_id="servicio.id" 
                                            :ticket_id="ticket_id"                                    
                                            @update="getActividades()"
                                        />
                                    </td>
                                    <td>
                                        <AddArticulo  v-if="(!servicio['estado-servicio']>0)" :cliente_id="ticket.cliente_id" :servicio_id="servicio.id" :ticket_id="ticket_id" @update="getActividades()" />
                                    </td>
                                    <td>
                                        <AddActividad v-if="(!servicio['estado-servicio']>0)" :ticket_id="ticket_id" :servicio_id="servicio.id" @update="getActividades()"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class=" card-footer">
                                        Valor: {{ (servicio.precio)?'$'+servicio.precio:'' }},
                                    <span class="mx-2"> 
                                        Total de pagos recibidos: {{ servicio['pago-total'] }} 
                                        en
                                        {{ servicio['count-pagos']>1?servicio['count-pagos']+' pagos':servicio['count-pagos']+' pago' }}.
                                        Saldo pendiente: {{ servicio.precio-servicio['pago-total'] }}
                                        
                                    </span>
                    </div>
                  </div>

            
        </accordion-header>
        <accordion-content>
            <div class="w-full">
                <div class="flex flex-col p-4 items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <strong>Pagos realizados: </strong>
                    <EditPago v-for="(pago,index) in servicio.pagos" :key="index"
                        :ticket_id="ticket.id"
                        :servicio_id="servicio.id"
                        :id_pago="pago.id"
                        @update="getActividades()"
                    >
                        {{ pago.concepto }}: ${{ pago.valor }}
                    </EditPago>
            </div>
            </div>  
            <div class="w-full">
                    <div class="flex flex-col p-4 items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                        v-for="(actividad,index) in servicio.actividades" :key="index"
                        >
                        <div class="d-flex align-items-center text-wrap text-left px-1">
                            <svg v-if="actividad.estado_ticket=='cerrado'" class="mx-4 w-[10px] h-[10px] text-green-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M1 5.917 5.724 10.5 15 1.5"/>
                            </svg>
                            <svg v-else class="mx-4 w-[10px] h-[10px] text-red-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            {{ actividad.estado_ticket }}
                        </div>
                            <div class="d-flex align-items-center text-wrap px-4 my-2">
                                <h5 class="px-1 text-md font-bold tracking-tight text-gray-900 dark:text-white">{{ actividad.fecha_hora }}</h5>
                                <p class=" px-2 text-justify"><strong>Actividad realizada: </strong>{{ actividad.descripcion }}</p>
                            </div>
                            <div class="align-items-center text-wrap">
                                <EditActividad :actividad_id="actividad.id" :ticket_id="servicio.ticket_id" @update="getActividades()" />
                                <DeleteActividad @update="getActividades()" :name="servicio.id" :url="'delete_actividad/'+props.ticket_id" :id="actividad.id"/>
                            </div>
                    </div>
            </div>
            <div class="w-full">
                <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row  hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
                    
                >
                <kbd v-for="(articulo,index) in servicio.servicio_articulos" :key="index" class="inline-flex m-1 items-center px-2 py-1.5 text-gray-800 bg-green-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-100 dark:border-gray-500">
                    
                    <span class="">{{ articulo.nombre_interno }}</span>
                </kbd>
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
    import AddPago from './AddPago.vue';
    import EditPago from './EditPago.vue';
    import EditActividad from '../TicketActividad/Edit.vue';
    import DeleteActividad from '../TicketActividad/Delete.vue';
    import EditForm from './Edit.vue';
    import AddRecomendacion from './../TicketRecomendacion/Create.vue';
    import EditRecomendacion from './../TicketRecomendacion/Edit.vue';
    import DeleteRecomendacon from './../TicketRecomendacion/Delete.vue';
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