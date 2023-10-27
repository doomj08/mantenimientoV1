<template>
    <EncabezadoVue 
        namePage="PDF"  
    >
    
    </EncabezadoVue>
    
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