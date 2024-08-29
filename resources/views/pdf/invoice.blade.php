<style>

<link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>

@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&family=Roboto:wght@500&display=swap');
    /* Añado la declaración de font-family, para usar la fuente de Google Fonts en este PDF */
    
    h1 {
        font-family: 'Roboto Flex', sans-serif;
        color: #303030;
        font-size: 20px;
    }
    body {
        font-family: 'Roboto Flex', sans-serif;
        
        color: #303030;
        font-size: 12px;
    }
    caption{
        text-align:left;
    }
    .fecha {
        font-family: 'Roboto Flex', sans-serif;
    }
    thead{
        text-align:center;
    }

    .ticket thead th{
        text-align:center
    }

    .ticket{
        width: 100%;
        
    }

    .ticket tbody tr td{
        margin:3px;
        padding:4px;
    }
    
    /* todo el otro CSS necesario para el PDF */
    /* ... */
</style>
<p class="fecha">Fecha de impresión: {{$fecha_consulta}}</p>
@foreach ($seccionesformato as $index=>$seccion)
        @php
            $titulo_base = "$seccion->seccion";
            $titulo_base2 = "$seccion->seccion";
        @endphp
    
    <table>
    
    @foreach ($articulo->Propiedad as $index2=>$propiedad)
        @if($propiedad->CampoPropiedad->seccion_formato_id==$seccion->id)

            @if($titulo_base2==$titulo_base)
                <caption><h1>{{$seccion->seccion}}</h1></caption>
            @endif
            @php
                $titulo_base2 = "$seccion->seccion_disabled";
            @endphp
        <tr>
                <td>{{ $propiedad->CampoPropiedad->nombre_propiedad }}</td>
                <td>{{ $propiedad->propiedad }}</td>
        </tr>
        @endif
    @endforeach
    
    @foreach ($articulo->Componente as $componente)
        @foreach ($componente->Propiedad as $propiedad)
            @if($propiedad->CampoPropiedad->seccion_formato_id==$seccion->id)
                <tr>
                    
                        
                        <td>{{$propiedad->CampoPropiedad->nombre_propiedad}}</td>
                        <td>{{ $propiedad->propiedad }}</td>
                </tr>
            @endif
        @endforeach
@endforeach



</table>
@endforeach
@if($tickets)
    <table class="ticket">
    <caption><h1>Tickets asociados</h1></caption>
        <thead>
            <tr>
                <th rowspan="2">Núm. ticket</th>
                <th colspan="2" style="text-align:center;">Creado en</th>
                <th colspan="4">Descripción</th>
                <th rowspan="2">Estado</th>
            </tr>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $index=>$ticket)
            <tr>
                <td style="text-align:center">{{$ticket->num_ticket}}</td>
                <td>{{date('Y-m-d', strtotime($ticket->fecha_hora))}}</td>
                <td>{{date('h:m:s A', strtotime($ticket->fecha_hora))}}</td>            
                <td colspan="4">{{$ticket->descripcion}}</td>
                <td>{{$ticket['estado-ticket']}}</td>
            </tr>
                

            @endforeach
        </tbody>
    </table>
@endif