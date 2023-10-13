<h1>Informe PDF</h1>

<h1>Ficha técnica Tabla Fija</h1>


<table>
    @foreach ($articulo->toArray() as $column => $value)
        <tr>
            @if(!is_array($value))
                <td>{{ $column }}</td>
                <td>{{ $value }}</td>
            @endif
        </tr>
    @endforeach
</table>

<h1>Ficha técnica Tabla Dinámica</h1>

<table>
    
    @foreach ($articulo->Propiedad as $propiedad)
        <tr>
            
                <td>{{ $propiedad->CampoPropiedad->nombre_propiedad }}</td>
                <td>{{ $propiedad->propiedad }}</td>
                
        </tr>
    @endforeach
    @foreach ($articulo->Componente as $componente)
        @foreach ($componente->Propiedad as $propiedad)
            <tr>
                
                    
                    <td>{{$propiedad->CampoPropiedad->nombre_propiedad}}</td>
                    <td>{{ $propiedad->propiedad }}</td>
            </tr>
        @endforeach
    @endforeach
</table>


