<template>
    <CampoForm :tipo_articulo_id="tipo_articulo_id" v-if="showWindowSeccion"/>
    <EncabezadoVue v-if="!showWindowSeccion"
        namePage="CATEGORÍA DE ARTÍCULOS"  
    >
        <template #button_create>
            <CreateForm :tipo_articulos="tipo_articulos" @update="getTipoArticulos()"/>

        </template>
    </EncabezadoVue>
    
    <div class="flex flex-col" v-if="!showWindowSeccion">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>

                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Tipo
                            </th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Campos
                            </th>


                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" v-for="(tipo_articulo,index) in tipo_articulos" :key="index">

                            <td class="flex items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ tipo_articulo.tipo }}</div>
                                </div>
                            </td>
                            <td class=" items-center p-4 mr-12 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <button @click=openSeccion(tipo_articulo.id)>Ver</button>
                                    </div>
                                </td>
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <EditForm  @update="getTipoArticulos()" class="text-left" :id="tipo_articulo.id" :tipo_articulos="tipo_articulo.tipo"/>

                                <DeleteForm @update="getTipoArticulos()" :name="tipo_articulo.tipo" url="tipo_articulos" :id="tipo_articulo.id"/>
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
    import CampoForm from '../CampoPropiedades/Index.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'
    
    const authStore = useAuthStore();
    const tipo_formato_id=ref([]);
    const tipo_articulos=ref([]);
    const showWindowSeccion = ref(false)
    const tipo_articulo_id=ref(0)
    const load=ref(false);

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getTipoArticulos()})

    const openSeccion=(id)=>{
        console.log("id:"+id)
        tipo_articulo_id.value=id
        console.log("id:"+tipo_articulo_id.value)
        showWindowSeccion.value=true
    }

    const getTipoArticulos=async () =>{
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/tipo_articulos/', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
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