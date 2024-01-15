<template>
    
    <EncabezadoVue v-if="false&&!showWindowSeccion"
        namePage="CATEGORÍA DE ARTÍCULOS"  
    >
        <template #button_create>
            <CreateForm :tipo_articulos="tipo_articulos" @update="getTipoArticulos()"/>

        </template>
    </EncabezadoVue>
    <div v-if="!showWindowSeccion" class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Categoría de artículos</h4>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <RouterLink to="/home" class="text-muted text-decoration-none">
                                Home
                            </RouterLink>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Categorías</li>
                    </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <CreateForm  @update="getTipoArticulos()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive mb-4" v-if="!showWindowSeccion">

        <table class="table table-responsive border text-nowrap customize-table mb-0 align-middle">
            <thead class="text-dark fs-4">
                <tr>

                    <th scope="col">
                        <h6 class="fs-4 fw-semibold mb-0">Tipo</h6>
                    </th>
                    <th scope="col">
                        <h6 class="fs-4 fw-semibold mb-0">Campos</h6>
                    </th>


                    <th scope="col">
                        <h6 class="fs-4 fw-semibold mb-0">Actions</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                
                <tr v-for="(tipo_articulo,index) in tipo_articulos" :key="index">

                    <td>
                        <div class="d-flex align-items-center text-wrap">
                            {{ tipo_articulo.tipo }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center text-wrap">
                            <button @click=openSeccion(tipo_articulo.id,tipo_articulo.tipo)>Ver</button>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center text-wrap">
                            <EditForm  @update="getTipoArticulos()" class="text-left" :id="tipo_articulo.id" :tipo_articulos="tipo_articulo.tipo"/>

                            <DeleteForm @update="getTipoArticulos()" :name="tipo_articulo.tipo" url="tipo_articulos" :id="tipo_articulo.id"/>
                        </div>
                    </td>
                </tr>
                
                
                
                
            </tbody>
        </table>
            
    </div>
    <CampoForm :nombreArticulo="tipo_articulo" :tipo_articulo_id="tipo_articulo_id" v-if="showWindowSeccion"/>
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
    const tipo_articulo=ref('')
    const load=ref(false);

    axios.defaults.headers.common['Authorization']='Bearer'+authStore.authToken;

    onMounted(()=>{getTipoArticulos()})

    const openSeccion=(id,name)=>{
        console.log("id:"+id)
        tipo_articulo_id.value=id
        tipo_articulo.value=name
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