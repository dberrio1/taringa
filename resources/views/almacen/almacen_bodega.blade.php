@extends('almacen')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}({{$nombre_corto}})</a>
@endsection

@section('cuerpo')
    <div style="width: 30%;height: 27%;float: left; position: relative">
        <select id="familia" class="form-control" style="height: 30px;font-size: 12px">
            <option value="0">Familia de Producto</option>
            @foreach($familias as $familia)
                <option value={{$familia['id']}}>{{$familia['nombre']}}</option>
            @endforeach
        </select>
        <!--<p style="height: 0px"></p>
        <select id="sol" class="form-control" style="height: 30px;font-size: 12px">
            <option value="{{$id}}">{{$nombre_corto}}</option>
        </select>-->
        <p style="height: 0px"></p>
        <select id="cc" class="form-control" style="height: 30px;font-size: 12px">
            <option value="0">Cuentas</option>
            @foreach($cc as $c)
                <option value={{$c['id']}}>{{$c['cuenta']}}</option>
            @endforeach
        </select>
        <p style="height: 0px"></p>
        <select id="producto" class="form-control" style="height: 30px;font-size: 12px">
            <option value="0">Producto</option>
        </select>

        <button type="button" id = "cgaProducto" class="btn btn-secondary btn-sm btn-block" style="position: absolute;bottom: 0">Carga Producto</button>
    </div>
    <div id="divProductos" style="width: 100%;">
        <table id="tblProductos" class="display" style="width:100%;font-size: 13px">
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
    <div>

        <input type="hidden" id="seluni" value="">
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
                "scrollY":        "200px",
                "scrollCollapse": true,
                "paging": false,
                "searching": false,
                "info":     true,
                "language": {
                    "decimal": ",",
                    "thousands": "."
                }
            } );
            $(document).on('click', '#cgaProducto',function () {
                var t = $('#tblProductos').DataTable()

                t.row.add( [
                    '{{$nombre_corto}}',
                    $('#cc option:selected').text(),
                    $('#producto option:selected').text(),
                    $('#seluni').val(),
                    '<input type="text" id = "valor_'+i+'" class="suma" value="0" style="width: 40px"></td>',

                ] ).draw( false );
                i++;

            });
            $(document).on('change', '#familia',function (e) {
                $.get("{{route('bodega')}}" +"/"+e.target.value,function (response,prod) {
                    $('#producto').empty();
                    $('#producto').append('<option value="0">Producto</option>');
                    for(var i=0; i<= response.length;i++){
                        $('#producto').append('<option value="'+ response[i].id + '">'+ response[i].producto +'</option>')
                    }
                });
            });
            $(document).on('change', '#producto',function (e) {
                $.get("{{route('bodega')}}" +"/proveedor/"+$(this).val(),function (response,prod) {
                    for(var i=0; i<= response.length;i++){
                        $('#seluni').val(response[i].unit);

                    }
                });
            });
            $(document).on('click', '#gensol',function () {
                var myRows = { solicitud: [] };
                var x = 1;

                var $th = $('#tblProductos th');
                $('#tblProductos tbody tr').each(function(i, tr){
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
                        var table = $('#tblProductos').DataTable();
                        table.rows().remove().draw( false );
                    },
                    error: function(msg)
                    {
                        console.log(msg);
                    }
                });
            });
            $('#tblProductos tbody').on( 'click', 'tr', function () {
                var table = $('#tblProductos').DataTable();
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );

            $(document).on('click','#delprod',function () {
                var table = $('#tblProductos').DataTable();
                table.row('.selected').remove().draw( false );
            });

        });

    </script>
@endsection
