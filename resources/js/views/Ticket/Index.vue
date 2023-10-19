<template>
    <EncabezadoVue 
        namePage="TICKETS"  
        createButtonText="Agregar cliente"
    >
        <template #button_create>
            <CreateForm  @update="getTickets()"/>
        </template>
    </EncabezadoVue>
    
    <div class="flex flex-col">
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
                                Descripción
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Cliente 
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
                        
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" v-for="(ticket,index) in tickets" :key="index">

                            <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ ticket.id }}</div>
                                </div>
                            </td>
                            <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ ticket.descripcion }}</div>
                                </div>
                            </td>
                            <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ ticket.cliente.nombre }}</div>
                                </div>
                            </td>
                            <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ (ticket['estado-ticket']>0)?'Cerrado':'Abierto' }}</div>
                                </div>
                            </td>
                          
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <router-link  :to="{ name: 'actividad_ticket', params: { ticket_id: ticket.id }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                        <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z"/>
                                    </svg>
                                    <span class="ml-3">Informes</span>
                                </router-link>
                                <EditForm @update="getTickets()" class="text-left" :id="ticket.id"/>

                                <DeleteForm  @update="getTickets()" :name="ticket.nombre" url="tickets" :id="ticket.id"/>
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