<template>
    <EncabezadoVue 
        namePage="PDF"  
        v-if="false"
    >
    
    </EncabezadoVue>
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Vista PDF</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink to="/home" class="text-muted text-decoration-none">
                                Home
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item">
                            <RouterLink to="/ticket" class="text-muted text-decoration-none">
                                Orden de Servicio
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Vista PDF</li>
                    </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <object :data="'data:application/pdf;base64,'+pdf_base64" type="application/pdf" width="100%" height="600px" />

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
    const pdf_base64=ref([]);

    const props = defineProps({
        ticket_id: Number,
    })

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
                method:'GET', url:'api/pdf/ticket/'+props.ticket_id, data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                pdf_base64.value=response.data
                
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