<template>
    <EncabezadoVue 
        namePage="TICKETS"  
    >
        <template #button_create>
            <CreateForm  @update="getTickets()"/>
        </template>
    </EncabezadoVue>
    
    

        <table class="w-full table-fixed border-separate border-spacing-2 border border-slate-400">
  <thead>
    <tr>
      <th>N°</th>
      <th>Fecha / Hora</th>
      <th>Descripción</th>
      <th>Cliente</th>
      <th>Estado</th>
      <th>Actions</th>

    </tr>
  </thead>
  <tbody>
    <tr class="bg-white hover:bg-gray-100 dark:hover:bg-gray-700" v-for="(ticket,index) in tickets" :key="index">
        <td>{{ ticket.num_ticket }}</td>
        <td>{{ ticket.fecha_hora }}</td>
        <td>{{ ticket.descripcion }}</td>
        <td>{{ ticket.cliente.nombre }}</td>
        <td>{{ (ticket['estado-ticket']>0)?'Cerrado':'Abierto' }}</td>
        <td class="grid space-y-1 whitespace-nowrap">
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