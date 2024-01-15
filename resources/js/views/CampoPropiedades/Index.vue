<template>
    <EncabezadoVue  v-if="false"
        :namePage="'CAMPOS DE INFORMES ['+ [tipo_articulo_id]+']'"
    >
        <template #button_create>
            

        </template>
    </EncabezadoVue>
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Configuración de informe [{{'Artículo: '+ nombreArticulo}}]</h4>
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

    <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100 p-0">
            <div class="card-body">
                <div class="mb-4">
                    <h5 class="mb-0">Secciones y campos</h5>
                </div>
                <Accordion flush>
                    <accordion-panel v-for="(seccion_all, index) in all_secciones" :key="index">
                    <accordion-header class="accordion-item m-0 p-0">
                            <h2 class="accordion-header d-flex">
                                {{seccion_all.seccion}}
                                <DeleteForm :name="seccion_all.seccion" url="seccion_formato" :id="seccion_all.id"/>
                            </h2>
                        
                    </accordion-header>
                    <accordion-content class="m-0 p-0">
                        
                        <emply v-for="(seccion,index) in secciones_formato" :key="index">                          
                                <label v-if="seccion.id==seccion_all.id" type="button" data-modal-toggle="add-user-modal" class="m-0.5 inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                                v-for="(campo,index) in seccion.campo_propiedad" :key="index">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="#000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></svg>
                                    {{campo.nombre_propiedad}}
                                    <EditForm :id="campo.id" @update="getPropiedades()"/>
                                    <DeleteForm :id="campo.id" url="campos_propiedades" @update="getPropiedades()"/>
                                </label>
                        </emply>
                        <CreateForm :tipo_articulo="tipo_articulo_id" :seccion_formato_id="seccion_all.id"/>
                    </accordion-content>
                    </accordion-panel>

                   
                </Accordion>
                <div >
                    <CreateSeccion :formato_id="1"/>
                </div>
                
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
    import CreateSeccion from '../SeccionFormatos/Create.vue';

    import EditForm from './Edit.vue';
    import DeleteForm from './Delete.vue';
    import TableBodyVue from '../../pages/master/tablabody.vue'

    import { Accordion, AccordionPanel, AccordionHeader, AccordionContent, Badge, Button } from 'flowbite-vue'

    
    const authStore = useAuthStore();
    const campo_propiedades=ref([]);
    const secciones_formato=ref([]);
    const all_secciones=ref([]);
    
    const load=ref(false);

    const props = defineProps({
        tipo_articulo_id: Number,
        nombreArticulo: String,
    })

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getPropiedades()})

    const getPropiedades=async () =>{
        console.log('api/tipo_articulos/'+props.tipo_articulo_id+'/campos_propiedades')
        let res;
            const config = {
            headers: {
                'Authorization': 'Bearer '+authStore.authToken,
            }
        };
            await axios(
            {
                method:'GET', url:'api/tipo_articulos/'+props.tipo_articulo_id+'/campos_propiedades', data:null,headers:config.headers
            }
        )
        .then(
            (response) => {
                campo_propiedades.value=response.data.data.campo_propiedad
                secciones_formato.value=response.data.data.secciones
                all_secciones.value=response.data.data.all_secciones
                
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