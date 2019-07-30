@extends('bodega')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')
    <div style="width: 40%;height: 35%;float: left; position: relative">
        <select id="familia" class="form-control" style="height: 30px;font-size: 12px">
            <option value="0">Familia de Producto</option>
            @foreach($familias as $familia)
                <option value={{$familia['id']}}>{{$familia['nombre']}}</option>
            @endforeach
        </select>
        <p style="height: 0px"></p>
        <select id="sol" class="form-control" style="height: 30px;font-size: 12px">
            <option value="0">Solicitante</option>
            @foreach($sol as $s)
                <option value={{$s['id']}}>{{$s['nombre_corto']}}</option>
            @endforeach
        </select>
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

        <button type="button" id = "bscProveedor" class="btn btn-secondary btn-sm btn-block" style="position: absolute;bottom: 0">Buscar Proveedor</button>

    </div>
    <div style="width: 55%; height:35%;float: right;text-align: center; position: relative">
        <!--<h3 id="titulo"></h3>-->
        <div id="divproveedores" style="width: 100%;visibility: hidden">
            <table id="tblproveedores"  class="display" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Unidad</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <button type="button" id = "cgaProducto" class="btn btn-secondary btn-sm btn-block" style="position: absolute;bottom: 0">Carga Producto</button>
        </div>


    </div>
    <div id="divProductos" style="width: 100%;">
        <table id="tblProductos" class="display" style="width:100%;font-size: 13px">
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
    <div>
        <input type="hidden" id="selprov" value="">
        <input type="hidden" id="selval" value="">
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
            $('#bscProveedor').click(function () {

                $('#divproveedores').css('visibility', 'visible');
            });
            $(document).on('click', '#tblproveedores tbody tr',function () {
                $('#selprov').val($(this).find('td').eq(0).text());
                $('#selval').val($(this).find('td').eq(1).text());
                $('#seluni').val($(this).find('td').eq(2).text());
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
            $('#tblproveedores').DataTable( {
                "scrollCollapse": false,
                "paging": false,
                "searching": false,
                "info":     false
            } );
            $(document).on('click', '#cgaProducto',function () {
                var t = $('#tblProductos').DataTable()

                t.row.add( [
                    $('#sol option:selected').text(),
                    $('#cc option:selected').text(),
                    $('#producto option:selected').text(),
                    $('#seluni').val(),
                    $('#selprov').val(),
                    $('#selval').val(),
                    '<input type="text" id = "valor_'+i+'" class="suma" value="0" style="width: 40px"></td>',
                    ' '
                ] ).draw( false );
                i++;

            });
            $(document).on('change', '.suma',function () {
                var $d = $(this).parent("td");
                var col = $d.parent().children().index($d);
                var row = $d.parent().parent().children().index($d.parent());
                var valor = $('#tblProductos tbody tr:eq(' + row + ')').find('td').eq(5).text();
                var cantidad = $(this).val();
                /*var resultado = valor * cantidad;
                $('#tblProductos tbody tr:eq(' + row + ')').find('td').eq(7).text(formatNumero(resultado));*/
                $('#tblProductos tbody tr:eq(' + row + ')').find('td').eq(7).text(valor * cantidad);
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
                var t = $('#tblproveedores').DataTable();


                $.get("{{route('bodega')}}" +"/proveedor/"+$(this).val(),function (response,prod) {
                    $('#tblproveedores tbody tr').empty();

                   for(var i=0; i<= response.length;i++){
                       t.row.add( [
                            response[i].nombre,
                            response[i].precio,
                            response[i].unit,

                       ]).draw( false );
                    }
                });
            });
            $(document).on('click', '#genoc',function () {
                var myRows = { o_compra: [] };
                var x = 1;

                var $th = $('#tblProductos th');
                $('#tblProductos tbody tr').each(function(i, tr){
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
            $('#tblproveedores tbody').on( 'click', 'tr', function () {
                var table = $('#tblproveedores').DataTable();
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );
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
        /*function formatNumero(num) {
            return (
                num
                    .toFixed(0) // always two decimal digits
                    .replace('.', ',') // replace decimal point character with ,
                    .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            ) // use . as a separator
        }*/

    </script>
@endsection
