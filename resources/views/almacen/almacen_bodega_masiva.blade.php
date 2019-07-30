@extends('almacen')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}({{$nombre_corto}})</a>
@endsection

@section('cuerpo')
    <div style="width: 40%;height:7%;float: left; position: relative">
        <div style="width: 50%; float: left; position: relative">
            <select id="cc" class="form-control" style="width: 90%; height: 30px;font-size: 12px">
                <option value="0">Cuentas</option>
                @foreach($cc as $c)
                    <option value={{$c['id']}}>{{$c['cuenta']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div id="divProductos" style="width: 100%;">
        <table id="tblProductos" class="display" style="width:100%;font-size: 13px">
            <thead>
            <tr>
                <th>Solicitante</th>
                <th>Producto</th>
                <th>Unidad</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prod as $key => $p)
                <tr>
                    <td>{{$nombre_corto}}</td>
                    <td>{{$p->producto}}</td>
                    <td>{{$p->unidad}}</td>

                </tr>
            @endforeach
            </tbody>
            </tfoot>

        </table>
        <div id="divProductossolicitar" style="width: 100%;">
            <table id="tblProductosSolicitar" class="display" style="width:100%;font-size: 13px">
                <thead>
                <tr>
                    <th>Solicitante</th>
                    <th>Cuenta</th>
                    <th>Producto</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                </tr>
                </thead>
                <tbody>
                </tfoot>

            </table>
            <button type="button" id = "gensol" class="btn btn-secondary btn-sm" >Genera Orden de Compra</button>
            <button type="button" id = "delprod" class="btn btn-secondary btn-sm" >Borrar</button>
        </div>
    </div>

@endsection

@section('js_bodega')
    <script type="text/javascript">
        $(document).ready(function () {
            var i = 1;
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            $('#tblProductos').DataTable( {
                "scrollY": "200px",
                "scrollCollapse": true,
                "paging": false,
                "searching": true,
                "info":     true
            } );
            $('#tblProductosSolicitar').DataTable( {
                "scrollY":        "200px",
                "scrollCollapse": true,
                "paging": false,
                "searching": false,
                "info":     true
            } );

            $('#tblProductos tbody tr td').on( 'click', function () {

                var $row_index = $(this).parent().index();

                var solicitante = $('#tblProductos tbody tr:eq(' + $row_index + ')').find('td').eq(0).text();
                var producto = $('#tblProductos tbody tr:eq(' + $row_index + ')').find('td').eq(1).text();
                var unidad = $('#tblProductos tbody tr:eq(' + $row_index + ')').find('td').eq(2).text();

                var t = $('#tblProductosSolicitar').DataTable();
                t.row.add( [
                    solicitante,
                    $('#cc option:selected').text(),
                    producto,
                    unidad,
                    '<input type="text" id = "valor_'+i+'" class="suma" value="0" style="width: 40px"></td>',

                ] ).draw( false );
                i++;
            });
            $(document).on('click', '#gensol',function () {
                var myRows = { solicitud: [] };
                var x = 1;

                var $th = $('#tblProductosSolicitar th');
                $('#tblProductosSolicitar tbody tr').each(function(i, tr){
                    var obj = {}, $tds = $(tr).find('td');
                    $th.each(function(index, th){
                        if(index == 4){
                            obj[$(th).text()] = $('#valor_'+x).val();
                            x++;
                        }else{
                            obj[$(th).text()] = $tds.eq(index).text();
                        }

                    });
                    myRows.solicitud.push(obj);
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({

                    data: JSON.stringify(myRows),
                    url: '{{route('almacen.post')}}',
                    method: 'POST',

                    success: function(data)
                    {
                        console.log(data);
                        var table = $('#tblProductosSolicitar').DataTable();
                        table.row().remove().draw( false );
                    },
                    error: function(msg)
                    {
                        console.log(msg);
                    }
                });
            });


        });

    </script>
@endsection
