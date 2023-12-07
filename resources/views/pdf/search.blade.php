<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento</title>
    <script src="https://unpkg.com/vue@next"></script>
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
    </style>
</head>
<body>
    <div id="app" class="search-container">
        <div class="container">
            <form class="search-form" @submit.prevent="search">
                <label for="search">Digite su número de Nit/CC para consultar sus tickets:</label>
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
                            <th>Estado</th>
                            <th>Empresa</th>
                            <th>Ver PDF</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="result in results">
                            <td>@{{result.num_ticket}}</td>
                            <td>@{{result.descripcion}}</td>
                            
                            <td>@{{result["estado-ticket"]?'Abierto':'Cerrado'}}</td>
                            <td>@{{result.empresa.razon_social}}</td>
                            <td><a :href="'/pdf/ticket/'+result.id+'/view'">Ver</a></td>

                            
                

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
        const app = Vue.createApp({
            data() {
                return {
                    searchTerm: '',
                    results: [],
                    searched: false
                };
            },
            methods: {
                search() {
                    axios.post('/search', { search: this.searchTerm })
                        .then(response => {
                            this.results = response.data.data.tickets;
                            console.log(response.data.data.tickets)
                            this.searched = true;
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }
        });

        app.mount('#app');
    </script>
</body>
</html>
