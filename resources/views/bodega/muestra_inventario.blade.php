@extends('bodega')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')

    <div style="height: 81%; width: 100%">
        <label style="font-weight:bold;margin-left: 25px; margin-top: 5px">Lista de Productos</label>
        <table id="inventario" class="display" style="width:100%;font-size: 13px; margin-left:  5px">
            <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Inv. Ideal</th>
                <th>Diferencia</th>
            </tr>
            </thead>
            <tbody>
            @foreach($inventario as $inv)
                <tr>
                    <td>{{$inv->producto}}</td>
                    <td>{{$inv->cantidad}}</td>
                    <td>{{$inv->limite}}</td>
                    <td>{{$inv->cantidad - $inv->limite}}</td>
                </tr>
            @endforeach
            </tbody>
            </tfoot>

        </table>

    </div>

@endsection
@section('js_bodega')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            $('#inventario').DataTable( {
                "scrollY": "400px",
                "scrollCollapse": true,
                "paging": false,
                "searching": true,
                "info":     true,

            } );
            $('#inventario tbody tr').each(function(){ //filas con clase 'dato', especifica una clase, asi no tomas el nombre de las columnas
                   var diferencia = $(this).find('td').eq(3).text();
                   if(diferencia <= 10 && diferencia >5){
                       $(this).css('background-color', 'yellow');
                   }
                    if(diferencia <= 5){
                        $(this).css('background-color', 'red');
                    }
            })

        });

    </script>
@endsection

