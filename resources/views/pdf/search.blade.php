<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
       body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;

            
            margin: 20px;
        }

        .container2 {
            display: flex;
            flex-direction: column;
            align-items: center;

           
            margin: 20px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        label,
        input,
        button {
            display: block;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        input {
            padding: 8px;
            font-size: 16px;
        }

        button {
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            color:white;
            background-color:rgba(4,4,50,1)
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #000;
            color:white;
        }
        td{
            border: 0px none #ddd;
        }
        .list{

            display: flex;

            padding:0px;
        }
        .list li{
            display: inline-block;
            margin-left:5px;
            margin-right:5px;
        }
    </style>
</head>
<body>
    <div id="app" class="search-container">
        <div class="container">
            <form class="search-form" @submit.prevent="search">
                <label for="search">Digite su número de Nit/CC para consultar sus tickets:</label>
                <small>Para NIT ingrese el número completo con número de verificación, sin puntos ni comas</small>
                <input v-model="searchTerm" type="text" id="search" name="search" placeholder="Ingrese su búsqueda">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <!-- Tabla de resultados -->
        <div class="container">

            <div v-if="results.length > 0">
                <table>
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Descripción</th>
                            <th>Artículos Relacionados</th>
                            <th>Estado</th>
                            <th>Empresa</th>
                            <th>Ver PDF</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="result in results">
                            <td>@{{result.num_ticket}}</td>
                            <td>@{{result.descripcion}}</td>
                            <td>
                                <ul class="list">
                                    <template v-for="servicio in result.servicio">
                                        <li v-for="articulo in servicio.servicio_articulos">
                                            <a :href="'/pdf/informe/'+articulo.id" target="_blank">@{{articulo.nombre_interno}}</a>
                                        </li>
                                    </template>
                                </ul>

                            </td>
                            
                            <td>@{{result["estado-ticket"]?'Cerrado':'Abierto'}}</td>
                            <td>@{{result.empresa.razon_social}}</td>
                            <td>
                                <a :href="'/pdf/ticket/'+result.id+'/view'" target="_blank">Ver</a>
                            </td>

                            
                

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else>
            <p v-if="searched && results.length === 0">No se encontraron resultados.</p>
        </div>
    </div>

    <script>
        let token = document.head.querySelector('meta[name="csrf-token"]');

        if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
        const { createApp, ref } = Vue
        createApp({
            data() {
                return {
                    searchTerm: '',
                    results: [],
                    searched: false
                };
            },
            methods: {
                search() {
                    axios.post('/search/{{$uuid}}', { search: this.searchTerm },headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                    })
                        .then(response => {
                            this.results = response.data.data.tickets;
                            console.log(response.data.data)
                            this.searched = true;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }
        }).mount('#app')

    </script>
</body>
</html>
