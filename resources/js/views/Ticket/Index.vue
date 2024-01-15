<template>
    <EncabezadoVue 
        namePage="TICKETS"  
        v-if="false"
    >
        <template #button_create>
            <CreateForm  @update="getTickets()"/>
        </template>
    </EncabezadoVue>
    
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Tickets</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink to="/home" class="text-muted text-decoration-none">
                                Home
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Tickets</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <CreateForm  @update="getTickets()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive mb-4">
        <table class="table table-responsive border text-nowrap customize-table mb-0 align-middle">
            <thead class="text-dark fs-4">
                <tr>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">N°</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Fecha / Hora</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Descripción</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Cliente</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Estado</h6>
                    </th>
                    <th>
                        <h6 class="fs-4 fw-semibold mb-0">Actions</h6>
                    </th>


                </tr>
            </thead>
            <tbody>
                <tr v-for="(ticket,index) in tickets" :key="index">
                    <td>
                        <div class="d-flex align-items-center text-wrap">{{ ticket.num_ticket }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center text-wrap">{{ ticket.fecha_hora }}</div></td>
                    <td>
                        <div class="d-flex align-items-center text-wrap">{{ ticket.descripcion }}</div></td>
                    <td>
                        <div class="d-flex align-items-center text-wrap">{{ ticket.cliente.nombre }}</div></td>
                    <td>
                        <div class="d-flex align-items-center text-wrap">{{ (ticket['estado-ticket']>0)?'Cerrado':'Abierto' }}</div></td>
                    <td class="grid space-y-1 whitespace-nowrap text-wrap">
                        <router-link  :to="{ name: 'ticket_servicios', params: { ticket_id:ticket.id, ticket_num:ticket.num_ticket }}" class=" inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                v-if="(ticket['estado-ticket']<ticket.servicio_count || ticket.servicio_count==0 )"
                            >
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                Detalles Ticket
                            </router-link>
                            <EditForm @update="getTickets()" class=" text-left" :id="ticket.id" v-if="(!ticket['estado-ticket']>0)"/>

                            <DeleteForm  @update="getTickets()" class=" " :name="ticket.nombre" url="tickets" :id="ticket.id" v-if="(!ticket['estado-ticket']>0)"/>
                            <router-link class="  text-center"  :to="{ name: 'ticket_pdf', params: { ticket_id:ticket.id }}">Ver PDF</router-link>
                        
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
            

            
        


</template>
<style scoped>
    .td{
    word-break: break-all !important;
    white-space: nowrap !important;
    width : 10% !important;
    }
</style>

<script setup>
    import axios from 'axios'
    import { ref, onMounted } from 'vue';
    import { confirmation } from '../../functions'
    import { useAuthStore } from '../../stores/auth';
    import { show_alerta } from '../../functions';
    import EncabezadoVue from '../../pages/master/encabezado.vue'
    import CreateForm from './Create.vue';
    import EditForm from './Edit.vue';
    import DeleteForm from './Delete.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'
    
    const authStore = useAuthStore();
    const tickets=ref([]);

    const load=ref(false);

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getTickets()})

    const getTickets=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/tickets/', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                tickets.value=response.data.data.tickets

                
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