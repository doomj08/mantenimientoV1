<template>
    <EncabezadoVue 
        namePage="ARTICULOS"  
        createButtonText="Agregar artículo"
        v-if="false"
    >
        <template #button_create>
            <CreateForm :tipo_articulos="tipo_articulos" @update="getArticulos()"/>
        </template>
    </EncabezadoVue>
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Artículos</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink to="/home" class="text-muted text-decoration-none">
                                Home
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Artículos</li>
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

                    <th scope="col">
                        <h6 class="fs-4 fw-semibold mb-0">Nombre interno</h6>
                    </th>

                    <th scope="col">
                        <h6 class="fs-4 fw-semibold mb-0">Actions</h6>
                    </th>
                </tr>
            </thead>
            <tbody >
                
                <tr v-for="(articulo,index) in articulos" :key="index">

                    <td>
                        <div class=" align-items-center text-wrap">
                            <div class="text-base font-semibold text-gray-900 dark:text-white">{{ articulo.nombre_interno }}</div>
                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ articulo.tipo_articulo.tipo }}</div>
                        </div>
                    </td>
                    
                    <td>
                        <div class=" align-items-center text-wrap">
                            <router-link  :to="{ name: 'propiedad', params: { articulo_id: articulo.id,nombre_interno:articulo.nombre_interno,tipo_articulo_id:articulo.tipo_articulo_id }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                Registrar Propiedades
                            </router-link>
                            <EditForm @update="getArticulos()" class="text-left" :id="articulo.id" :tipo_articulos="tipo_articulos"/>

                            <DeleteForm  @update="getArticulos()" :name="articulo.nombre_interno" url="articulo" :id="articulo.id"/>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
        

</template>

<script setup>
    import axios from 'axios'
    import { ref, onMounted } from 'vue';
    import { confirmation } from '../../functions'
    import { useAuthStore } from '../../stores/auth';
    import { show_alerta } from '../../functions';
    import EncabezadoVue from '../../pages/master/encabezado.vue'
    //import { Table, TableHead, TableBody, TableHeadCell, TableRow, TableCell, Breadcrumb, Button, Modal   } from 'flowbite-vue'
    import CreateForm from './Create.vue';
    import EditForm from './Edit.vue';
    import DeleteForm from './Delete.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'
    
    const authStore = useAuthStore();
    const articulos=ref([]);
    const tipo_articulos=ref([]);
    const load=ref(false);

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getArticulos()})

    const getArticulos=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/articulo/', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                articulos.value=response.data.data.articulos
                tipo_articulos.value=response.data.data.tipo_articulos
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