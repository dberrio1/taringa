@extends('bodega')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')
    <div style="width: 40%;height:7%;float: left; position: relative">
        <div style="width: 50%; float: left; position: relative">
            <select id="sol" class="form-control" style="width: 90%;height: 30px;font-size: 12px">
                <option value="0">Solicitante</option>
                @foreach($sol as $s)
                    <option value={{$s['id']}}>{{$s['nombre_corto']}}</option>
                @endforeach
            </select>

        </div>
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
                <th>Producto</th>
                <th>Unidad</th>
                <th>Proveedor 1</th>
                <th>Valor Uni. 1</th>
                <th>Proveedor 2</th>
                <th>Valor Uni. 2</th>
                <th>Proveedor 3</th>
                <th>Valor Uni. 3</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prod as $key => $p)
                <tr>
                    <td>{{$p->producto}}</td>
                    <td>{{$p->unidad}}</td>
                    <td>{{$p->proveedor_1}}</td>
                    <td align="right">
                        {{$p->precio_1}}
                        @if($p->precio_1 <> "")
                            <input type="radio" id = "{{$p->proveedor_1}}|{{$p->precio_1}}" class="precio" name="precio_{{$key+1}}">
                        @endif
                    </td>
                    <td>{{$p->proveedor_2}}</td>
                    <td align="right">
                        {{$p->precio_2}}
                        @if($p->precio_2 <> "")
                            <input type="radio" id = "{{$p->proveedor_2}}|{{$p->precio_2}}" class="precio" name="precio_{{$key+1}}">
                        @endif
                    </td>
                    <td>{{$p->proveedor_3}}</td>
                    <td align="right">
                        {{$p->precio_3}}
                        @if($p->precio_3 <> "")
                            <input type="radio" id = "{{$p->proveedor_3}}|{{$p->precio_3}}" class="precio" name="precio_{{$key+1}}">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
            </tfoot>

        </table>
    </div>
    </br>
    <div id="divProductossolicitar" style="width: 100%;">
        <table id="tblProductosSolicitar" class="display" style="width:100%;font-size: 13px">
            <thead>
            <tr>
                <th>Solicitante</th>
                <th>Cuenta</th>
                <th>Producto</th>
                <th>Unidad</th>
                <th>Proveedor</th>
                <th>Valor Uni.</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            </tfoot>

        </table>
        <button type="button" id = "genoc" class="btn btn-secondary btn-sm" >Genera Orden de Compra</button>
        <button type="button" id = "delprod" class="btn btn-secondary btn-sm" >Borrar</button>
    </div>
@endsection
@section('js_bodega')
    <script type="text/javascript">
        $(document).ready(function () {
            var i=1;
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

            $('input[type=radio]').on('change',function () {
                var id_radio = $(this).attr('id').split('|');
                var proveedor = id_radio[0];
                var valor = id_radio[1];

                var $d = $(this).parent("td");
                var col = $d.parent().children().index($d);
                var row = $d.parent().parent().children().index($d.parent());
                var producto = $('#tblProductos tbody tr:eq(' + row + ')').find('td').eq(0).text();
                var unidad = $('#tblProductos tbody tr:eq(' + row + ')').find('td').eq(1).text();

                var t = $('#tblProductosSolicitar').DataTable()

                t.row.add( [
                    $('#sol option:selected').text(),
                    $('#cc option:selected').text(),
                    producto,
                    unidad,
                    proveedor,
                    valor,
                    '<input type="text" id = "valor_'+i+'" class="suma" value="0" style="width: 40px"></td>',
                    ' '
                ] ).draw( false );
                i++;
            });
            $(document).on('change', '.suma',function () {
                var $d = $(this).parent("td");
                var col = $d.parent().children().index($d);
                var row = $d.parent().parent().children().index($d.parent());
                var valor = $('#tblProductosSolicitar tbody tr:eq(' + row + ')').find('td').eq(5).text();
                var cantidad = $(this).val();
                var resultado = valor * cantidad;
                $('#tblProductosSolicitar tbody tr:eq(' + row + ')').find('td').eq(7).text(resultado);
            });
            /*$('#divProductossolicitar tbody').on( 'click', 'tr', function () {
                var table = $('#divProductossolicitar').DataTable();
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
            });*/
            $(document).on('click', '#genoc',function () {
                var myRows = { o_compra: [] };
                var x = 1;

                var $th = $('#tblProductosSolicitar th');
                $('#tblProductosSolicitar tbody tr').each(function(i, tr){
                    var obj = {}, $tds = $(tr).find('td');
                    $th.each(function(index, th){
                        if(index == 6){
                            obj[$(th).text()] = $('#valor_'+x).val();
                            x++;
                        }else{
                            obj[$(th).text()] = $tds.eq(index).text();
                        }

                    });
                    myRows.o_compra.push(obj);
                });


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({

                    data: JSON.stringify(myRows),
                    url: '{{route('bodega.post')}}',
                    method: 'POST',

                    success: function(data)
                    {
                        console.log("{{route('bodega')}}"+'/imprimir/'+ data);
                        url = "{{route('bodega')}}"+'/imprimir/'+ data;
                        window.location.assign(url)
                    },
                    error: function(msg)
                    {
                        console.log(msg);
                    }
                });
            });

        });
        function formatNumero(num) {
            return (
                num
                    .toFixed(0) // always two decimal digits
                    .replace('.', ',') // replace decimal point character with ,
                    .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            ) // use . as a separator
        }


    </script>
@endsection
