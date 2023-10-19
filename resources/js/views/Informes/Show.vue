<template>
    {{ pdf }}
    <embed type="application/pdf" :src="pdf" original-url="http://127.0.0.1:8000/informe/1" background-color="4283586137" javascript="allow" full-frame="">
</template>

<script setup>
    import axios from 'axios'
    import { ref, onMounted } from 'vue';

    import { useAuthStore } from '../../stores/auth';
    import {show_alerta, show_toast } from '../../functions';

    
    const authStore = useAuthStore();
    const pdf=ref([]);
    
    const load=ref(false);

    const props = defineProps({
        informe_id: Number,
    })

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getPDF()})

    const getPDF=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/informe/'+props.informe_id, data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                pdf.value=  response.data.data.pdf
                res= response.data.status
                show_alerta(response.data.message,'success','')
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