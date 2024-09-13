<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe Api21</title>
    <style>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>

    @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed&family=Roboto:wght@500&display=swap');
    /* Añado la declaración de font-family, para usar la fuente de Google Fonts en este PDF */
    body {
        font-family: 'Roboto Flex', sans-serif;
    }
    .page-break {
        page-break-after: avoid;
    }
    
    .propiedades  td {
        font-family: 'Roboto Flex', sans-serif;
        border: 0.5px solid black;
        width: 350px;   
    }
    .propiedades thead td{
        border-radius: 5px 5px 0 0;
    }

    .caption{
        font-family: 'Roboto Flex', sans-serif;
        color: #fff;
        font-size: 17px;
        text-align:center;
        padding:3px;
        font-weight:bold;
        background-color: #303030;
    }
    table{
        margin-bottom:20px;
        page-break-inside: avoid;
        padding:0px;
    }
    table td h5, table td h6{
        margin:0px;
    }
    table td h5{
        float: left;
        font-size:15px;
        
        
    }
    table td h6{
        font-weight: normal;
        font-size:13px;
    }

    .ticket{
        width: 100%;
        font-family: 'Roboto Flex', sans-serif;
        border: 0.5px #303030 solid;
        padding:0px;
        border-radius: 7px 7px 0 0;
        
    }
    .ticket .caption{
        background-color:#e3000e;
        border-radius: 7px 7px 0 0;
    }
    .ticket thead, .ticket tbody{
        
    }
    .ticket thead{
        border-radius: 5px 5px 0px 0px;
    }
    .ticket thead tr td{
        margin:3px;
        padding:4px;
        font-size:15px;
    }
    .ticket tbody tr td{
        margin:3px;
        padding:4px;
        font-size:14px;
    }
    .even td{
        background-color:white;
    }
    .odd td{
        background-color:#eaeded;
        
    }
    .url{
        
    }
    header {
    position: fixed;
    top:17cm;
    right:0cm;
    left:18.7cm;
    width: 10cm;
    }
    .url{
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        text-transform:none;
        font-style:none;
        font-size:12px;
    }
    .fecha{
        float: left;
        font-size:12px;
    }
    .cliente{
        float: right;
        font-size:12px;
    }
    .info{
        position: relative;
        top:-35px;
        margin-bottom:-50px;
    }
    /* todo el otro CSS necesario para el PDF */
    /* ... */
</style>
</head>
<body>
    <header>
        <small class="url">
            Este documento lo puede consultar en: 
            <a href="www.api21.itcomn.com/pdf/informe/{{$articulo->id}}">
            api21.itcomn.com/pdf/informe/{{$articulo->id}}
            </a>
        </small>
    </header>
    <main>
        <p class=info>
            <small class="fecha">Fecha de impresión: {{$fecha_consulta}}</small>
            @if($articulo->cliente_id)
                <small class="cliente">Propiedad de: {{$articulo->cliente->nombre}}</small>
            @endif
        </p>
        
        

        @foreach ($seccionesformato as $index=>$seccion)
                @php
                    $titulo_base = "$seccion->seccion";
                    $titulo_base2 = "$seccion->seccion";
                    $even=1;
                @endphp
            <table class="propiedades">
            
            @foreach ($articulo->Propiedad as $index2=>$propiedad)
                @if($propiedad->CampoPropiedad->seccion_formato_id==$seccion->id)

                    @if($titulo_base2==$titulo_base)
                        
                        <thead>
                            <tr>
                                <td colspan=2 class="caption">
                                    {{$seccion->seccion}}
                                </td>
                            </tr>
                        </thead>
                        @php $even=0 @endphp
                    @endif
                    @php
                        $titulo_base2 = "$seccion->seccion_disabled";
                        
                    @endphp
                    @if ($even==1)
                        @php $even=0 @endphp
                    @else
                        @php $even=1 @endphp
                        
                    @endif
                    @if ($even==1)
                        <tr>
                    @endif
                        <td>
                            <h5>{{ $propiedad->CampoPropiedad->nombre_propiedad }}</h5>
                            <br>
                            <h6>{{ $propiedad->propiedad }}</h6>
                        </td>
                        
                    @if ($even==0)
                        </tr>
                    @endif
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
        <table class="ticket" style="width:711px">
        
            <thead>
                <tr>
                    <th colspan=8 class="caption">Tickets asociados</th>
                </tr>
                <tr>
                    <th rowspan="2">Núm. ticket</th>
                    <th colspan="2" style="text-align:center;">Creado en</th>
                    <th colspan="4" rowspan=2>Novedad Reportada</th>
                    <th rowspan="2">Estado</th>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($servicios as $index=>$servicio_articulo)

                @if($loop->even)
                    <tr class="even">
                        
                @else
                <tr class="odd">
                    
                @endif
                
                    <td style="text-align:center">{{$servicio_articulo->servicio->ticket->num_ticket}}</td>
                    <td>{{date('Y-m-d', strtotime($servicio_articulo->servicio->ticket->fecha_hora))}}</td>
                    <td>{{date('h:m:s A', strtotime($servicio_articulo->servicio->ticket->fecha_hora))}}</td>            
                    <td colspan="4">{{$servicio_articulo->servicio->ticket->descripcion}}</td>
                    <td>{{$servicio_articulo->servicio->ticket['estado-ticket']}}</td>
                </tr>
                    

                @endforeach
            </tbody>
        </table>
       
    </main>
</body>
</html>

