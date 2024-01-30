<style>

    h1 {
        font-family: 'Poppins', sans-serif;
        color: 303030;
        font-size: 20px;
        
        text-align: center;
    }
    body {
        
        font-family: 'Roboto Condensed', sans-serif;
        color: 303030;
        font-size: 12px;
    }

    .fecha {
        font-family: 'Roboto Flex', sans-serif;
    }
    .encabezado{
        font-family: 'Poppins', sans-serif;
        color: 303030;
        font-size: 15px;
        
    }
    .table{
        width: 100%;
        font-family: 'Poppins', sans-serif;
        color: 303030;
        font-size: 13px;
        font-weight: 100;
        text-align: center;
    }

    .folio{
        padding: 0px 5px 0px 34px;
    }
    .folio div{
        border: 1px;
        border-style: solid;
        border-color: #660000;
        padding: 5px 5px 5px 5px;
        border-radius: 5px;
        color: #660000;
        text-align: left;
    }
    .body{
        width: 100%;
        font-family: 'Poppins', sans-serif;
        color: 303030;
        font-size: 13px;
        font-weight: 100;
        text-align: left;
    }
    .body th{
        text-align: left;
    }
    .body td{
        font-family: 'Roboto Flex', sans-serif;
        color: #222;
        font-style: normal;
        font-weight: 400;
        margin-bottom: 5px;
    }
    hr{
        height: 6px;
        background-color: #000;
    }
    .separador_delgado{
        height: 2px;
        background-color: #aaa;
        border: #aaa;
    }
    .cliente{
        margin-bottom: 4px;
        font-weight: bold;
        border: #000 solid 1px;
    }
    .productos{
        width: 100%;
        font-family: 'Poppins', sans-serif;
        color: 303030;
        font-size: 13px;
        font-weight: 100;
        text-align: left;
        border: none;
        padding:0px;
        margin: 0px;
        border-style: none;
        
        border-collapse:collapse;
        
    }
    .productos thead th{
        color: #fff;        
        padding:5px;
        background-color: #000;
    }
    .productos th{
        text-align: left;

        
    }
    .productos td{
        font-family: 'Roboto Flex', sans-serif;
        color: #222;
        font-style: normal;
        font-weight: 400;
        margin-bottom: 5px;
    }
    .productos tbody td{
        color: #000;        
        padding:5px;
        background-color: #fff;
        border: 0px none #fff;

    }
    .actividades{
        list-style: square;
    }
    .separador{
        height: 10px;
        margin: 0px;
        padding: 0px;
        width: 100%;
    }
    
    .logo{
        height: 60px;
    }
    .recomendaciones thead th{
        text-align: left;
    }
    /* todo el otro CSS necesario para el PDF */
    /* ... */
    .firmas{
        width: 45%;
        display: inline-block;
        vertical-align: top;
    }
    .desgaste {
        font-family: 'Black Ops One', system-ui;
            font-size: 14px;
            position: absolute;
            right:-10px;
            top:140px;
            border-radius:50%;
            padding:0px 5px 2px 5px;
            text-align:center;
            line-height: 0.7;
    }
    .cerrado_ok{
        border: 0 solid rgba(200, 250, 100, 1); /* Borde blanco con 50% de transparencia */
            color: #069867;
    }
    .cerrado_no_ok{
        border: 0 solid rgba(200, 250, 100, 1); /* Borde blanco con 50% de transparencia */
            color: #399012;
    }
    .abierto_ok{
        border: 0 solid rgba(255, 100, 100, 0.9); /* Borde blanco con 50% de transparencia */
            color: #e20b4a;
    }
    .abierto_no_ok{
        border: 0 solid rgba(255, 100, 100, 0.9); /* Borde blanco con 50% de transparencia */
            color: #8c0012;
    }


</style>

@if($ticket['estado-ticket']=='Cerrado')


        @if($ticket['max-tiempo-final']<=$ticket->fecha_estimada)
            <div class="desgaste cerrado_ok" data-text="Cerrado">
            CERRADO
            <br>
                <small>          {!! \Carbon\Carbon::parse($ticket['max-tiempo-final'])->diffForHumans(\Carbon\Carbon::parse($ticket->fecha_estimada),false,false,3)!!} <br> de la fecha estimada</small>
                <br>{{$ticket->fecha_estimada}}
            </div>
        @else
        
        <div class="desgaste cerrado_no_ok" data-text="Cerrado">
        CERRADO
        <br>
            <small>     {!! \Carbon\Carbon::parse($ticket['max-tiempo-final'])->diffForHumans(\Carbon\Carbon::parse($ticket->fecha_estimada),false,false,3)!!}<br> de la fecha estimada</small>
            <br>{{$ticket->fecha_estimada}}
        </div>
        @endif

@else
    @if($now<=$ticket->fecha_estimada)
    <div class="desgaste abierto_ok" data-text="Cerrado">
        ABIERTO
        <br>
        <small>            {!! \Carbon\Carbon::parse($now)->diffForHumans(\Carbon\Carbon::parse($ticket->fecha_estimada),false,false,3)!!}<br> de la fecha estimada</small> 
        <br>{{$ticket->fecha_estimada}}
    </div>
    @else
    <div class="desgaste abierto_no_ok" data-text="Cerrado">
        ABIERTO
        <br>
        <small>            {!! \Carbon\Carbon::parse($now)->diffForHumans(\Carbon\Carbon::parse($ticket->fecha_estimada),false,false,3)!!}<br> de la fecha estimada</small> 
        <br>{{$ticket->fecha_estimada}}
    </div>
    @endif
@endif






<table class="table">
    <thead class="">
        <tr>
            <th rowspan="3" style="width: 25%;">      
                <img class="logo" alt="" src="data:image/png;base64,{{$logo}}" >
            </th>
            <th style="width: 50%;">{{$encabezado["titulo1"]}}</th>
            <th rowspan="3" class="folio" style="width: 25%;">
                <div >
                    Folio {{$ticket->num_ticket}}
                </div>
            </th>
        </tr>
        <tr>
            <th class="">{{$encabezado["titulo2"]}}</th>
        </tr>
        <tr>
            <th style="font-size: 11px;">{{$encabezado["titulo3"]}}</th>
        </tr>
    </thead>
</table>
<hr>
<table class="body">
    <tbody>
        <tr class="">
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Correo</th>
            <th colspan="2">Teléfono</th>
        </tr>
        <tr>
            <td>{{$ticket->cliente->nombre}}</td>
            <td>{{$ticket->cliente->contacto}}</td>
            <td>{{$ticket->cliente->correo}}</td>
            <td colspan="1">{{$ticket->cliente->telefono}}</td>
            <td></td>
        </tr>
        <div class="separador"></div>
        <tr>
            <th colspan="1">Dirección</th>
            <th colspan="1">Ciudad</th>
        </tr>
        <tr>
            <td colspan="1">{{$ticket->cliente->direccion}}</td>
            <td colspan="1">{{$ticket->cliente->ciudad}}</td>
        </tr>
    </tbody>
</table>
<hr>
@foreach($ticket->servicio as $index=>$servicio)
    @if($index>0)
        <hr class="separador_delgado">
    @endif

    
<table class="body">
    
    <tbody>
        
            <tr class="">
                <th colspan="2">Servicio</th>
                <th colspan="2">Novedad reportada</th>
                <th>Precio</th>
                <th>¿Tiene IVA?</th>
            </tr>
        
        <tr>
            <td colspan="2">{{$servicio->descripcion}}</td>
            <td colspan="2">{{$ticket->descripcion}}</td>
            
            <td>
                
                
                    
                @money($servicio->precio) 
                
            </td>
            <td>{{$servicio->tiene_iva?'Si':'No'}}</td>
            
        </tr>
        <div class="separador"></div>
        <tr class="">
            <th>Fecha programada</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th colspan="2">Duración</th>
        </tr>
        
        <tr class="">
            <td>{{$servicio->fecha_programada}}</td>
            <td>{{$servicio->fecha_inicio}}</td>
            <td>{{$servicio->fecha_fin}}</td>
            <td colspan="2">
                {!! \Carbon\Carbon::parse($servicio->fecha_inicio)->diffForHumans(\Carbon\Carbon::parse($servicio->fecha_fin),true,false,3)!!}
            </td>
        </tr>
        <div class="separador"></div>
        <tr>
            <th colspan="3">Pagos recibidos</th>
            <th>Pago total</th>
            <th>Saldo pendiente</th>
        </tr>
        <tr>
            <td colspan="3">
                @foreach($servicio->pagos as $index=>$pagos)
                    <span>{{$pagos->concepto}}: @money($pagos->valor)
                    @if($servicio['count-pagos']>0 && $index<$servicio['count-pagos']-1)
                    ,
                    @endif
                    </span>
                @endforeach
            </td>
            <td>
                @money($servicio['pago-total'])
                
            </td>
            <td>
            @money(($servicio->precio*1)-($servicio['pago-total']*1))
                
            </td>

        </tr>
    </tbody>
    
</table>
<ul>
    
</ul>
@endforeach
<table class="productos">
    
    <thead>
        <tr class="">
            <th style="width: 5%;">Cantidad</th>
            <th style="width: 10%;">Código</th>
            <th style="width: 10%;">Producto</th>
            <th style="width: 60%;">Descripción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ticket->Servicio as $servicio)
            @foreach($servicio->ServicioArticulos as $articulo)
                <tr>
                    <td>1</td>
                    <td>{{$articulo->id}}</td>
                    <td>{{$articulo->TipoArticulo->tipo}}</td>
                    
                    
                    <td style="width: 40%;">
                        @foreach($articulo->Propiedad as $propiedad)
                            @if($propiedad->visible)
                                |<strong>{{$propiedad->CampoPropiedad->nombre_propiedad}}: </strong>
                                {{$propiedad->propiedad}}|
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        @endforeach
        
 
    </tbody>
</table>
<hr>
<table class="actividades">
    <thead>
    <tr>
            <th >Actividades</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>
                <ul style="padding: 0px 0px 0px 10px; margin: 0px;">
                @foreach($ticket->Servicio as $servicio)
                    @foreach($servicio->Actividades as $actividadTicket)
                        
                            <li>{{$actividadTicket->descripcion}}</li>
                            
                            
                            
                            
                        
                    @endforeach
                @endforeach
                </ul>
            </td>
        </tr>
        
 
    </tbody>
</table>
<table class="recomendaciones">
    <thead>
    <tr>
            <th>Recomendaciones</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>
                <ul style="padding: 0px 0px 0px 10px; margin: 0px;">
                @foreach($ticket->Recomendaciones as $recomendacion)
                    
                        <li>{{$recomendacion->recomendacion}}</li>
                        
                        
                        
                        
                    
                @endforeach
                </ul>
            </td>
        </tr>
        
 
    </tbody>
</table>
<div class="firmas">
<table>
    <tbody>
        @foreach($tecnicos as $tecnico)
            <tr><td><strong>Correo técnico</strong></td></tr>
            <tr><td>{{$tecnico->email}}</td></tr>
            <tr><td><strong>{{$tecnico->name}}</strong></td></tr>
            <tr><td>
                <img
                width="250px;"
                src="{{($tecnico->FirmaDigitalizada)?$tecnico->FirmaDigitalizada->firma_digital:'Sin Firma'}}" 
                alt="Firma Digitalizada">
            </td></tr>
        @endforeach
    </tbody>
</table>
</div>
<div class="firmas">
<table>
    <tbody>
        @foreach($tecnicos as $tecnico)
            <tr><td><strong>Correo cliente</strong></td></tr>
            <tr><td>{{$ticket->Cliente->correo}}</td></tr>
            <tr><td><strong>{{$ticket->Cliente->nombre}}</strong></td></tr>
            
        @endforeach
    </tbody>
</table>
</div>




