<template>
    <EncabezadoVue 
        namePage="ARTICULOS"  
        createButtonText="Agregar artículo"
    >
        <template #button_create>
            <CreateForm :tipo_articulos="tipo_articulos" @update="getArticulos()"/>
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
                                Nombre interno
                            </th>

                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" v-for="(articulo,index) in articulos" :key="index">

                            <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ articulo.nombre_interno }}</div>
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ articulo.tipo_articulo.tipo }}</div>
                                </div>
                            </td>
                          
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <router-link  :to="{ name: 'propiedad', params: { articulo_id: articulo.id,nombre_interno:articulo.nombre_interno,tipo_articulo_id:articulo.tipo_articulo_id }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                    Registrar Propiedades
                                </router-link>
                                <EditForm @update="getArticulos()" class="text-left" :id="articulo.id" :tipo_articulos="tipo_articulos"/>

                                <DeleteForm  @update="getArticulos()" :name="articulo.nombre_interno" url="articulo" :id="articulo.id"/>
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
    import { Table, TableHead, TableBody, TableHeadCell, TableRow, TableCell, Breadcrumb, Button, Modal   } from 'flowbite-vue'
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