<style>

    
    /* Añado la declaración de font-family, para usar la fuente de Google Fonts en este PDF */
    
    h1 {
        font-family: 'Poppins', sans-serif;
        color: 303030;
        font-size: 20px;
    }
    body {
        
        font-family: 'Roboto Condensed', sans-serif;
        color: 303030;
        font-size: 12px;
    }

    .fecha {
        font-family: 'Roboto Flex', sans-serif;
    }
    
    /* todo el otro CSS necesario para el PDF */
    /* ... */
</style>
<p class="fecha">Fecha de impresión: {{$fecha_consulta}}</p>
@foreach ($seccionesformato as $seccion)
    <h1>{{$seccion->seccion}}</h1>
    <table>
    
    @foreach ($articulo->Propiedad as $propiedad)
        @if($propiedad->CampoPropiedad->seccion_formato_id==$seccion->id)
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