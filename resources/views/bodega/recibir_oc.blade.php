@extends('bodega')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')
    <div style="width: 70%;height:7%;float: left; position: relative">
        <div style="width:25%; float: left; position: relative">
            <input id = "numoc" class="form-control" type="text" placeholder="Orden de Compra" style="width: 95%">
        </div>
        &nbsp;
        <div style="width: 50%; float: left; position: relative;" >
            <button type="button" id = "buscaoc" class="btn btn-secondary btn-sm" style="height: 38px">Buscar Orden de Compra</button>

        </div>

    </div>
    <div style="width: 70%; float: left; position: absolute; top: 25%" class="bordes">
        <div style="width:25%; float: right; position: relative">
            <input id = "numfac" class="form-control" type="text" placeholder="N° de Factura" style="width: 95%">
        </div>
        <label style="font-weight:bold;margin-left: 5px"> Proveedor</label>
        <label style="text-indent:25px;">:</label>
        <label id="nomProv" style="font-weight:bold;margin-left: 5px"></label>
        </br>
        <label style="font-weight:bold;margin-left: 5px"> Fec. Compra</label>
        <label style="text-indent: 7px;">:</label>
        <label id="fec_compra" style="font-weight:bold;margin-left: 5px"></label>
        </br>
        <label style="font-weight:bold;margin-left: 5px"> Solicitante</label>
        <label style="text-indent:22px;">:</label>
        <label id="solicitante" style="font-weight:bold;margin-left: 5px"></label>
        </br>
        <label style="font-weight:bold;margin-left: 5px"> cuenta</label>
        <label style="text-indent:52px;">:</label>
        <label id="cuenta" style="font-weight:bold;margin-left: 5px"></label>
    </div>
    <div style="width: 70%; float: left; position: absolute; top: 45%" class="bordes">
        <label style="font-weight:bold;margin-left: 5px; margin-top: 5px">Lista de Productos</label>
        <table id="productos_solicitados" class="display" style="width:100%;font-size: 13px">
            <thead>
            <tr>
                <th style="width: 5%">Id</th>
                <th style="width: 5%">Cantidad</th>
                <th style="width: 30%">Producto</th>
                <th style="width: 10%">Unidad</th>
                <th style="width: 10%">Modifica</th>
                <th style="width: 15%">Cantidad Modif</th>
                <th style="width: 30%">Observaciones</th>
            </tr>
            </thead>
            <tbody>
            </tfoot>

        </table>
        <p></p>
        <button type="button" id = "recibiroc" class="btn btn-secondary btn-sm" style="visibility: hidden;height: 38px;margin-left: 2px">Recibir Orden de Compra</button>
        <p></p>
    </div>

@endsection
@section('js_bodega')
    <script type="text/javascript">
        $(document).ready(function () {
            var i=1;
            var var_select;

            $.get("{{route('recibir.observaciones')}}",function (response,prod) {

                var_select = '<select id="sel_" class="form-control" style="width: 90%;height: 30px;font-size: 12px">'
                for(var i=0; i<= response.length;i++) {
                    var_select = var_select +'<option value='+response[i].id+'>'+response[i].observacion+'</option>'
                }
                var_select =var_select+'</select>';

            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            $('#productos_solicitados').DataTable( {
                "scrollY": "200px",
                "scrollCollapse": true,
                "paging": false,
                "searching": false,
                "info":     false,

            } );
            $(document).on('click', '#buscaoc',function () {
                var url ="{{route('bodega.recibir')}}"+'/'+$('#numoc').val();
                var url2 ="{{route('bodega.recibir')}}"+'/detalle/'+$('#numoc').val();
                $.get(url,function (response,prod) {
                    $('#recibiroc').css('visibility','visible');
                    $('#nomProv').html('');
                    $('#fec_compra').html('');
                    $('#solicitante').html('');
                    $('#cuenta').html('');

                    if(response[0].estado === 0){
                        $('#recibiroc').css('visibility','hidden');
                        $('.checkbox').css('visibility','hidden');
                    }


                    $('#nomProv').append(response[0].proveedor);
                    $('#fec_compra').append(response[0].created_at);
                    $('#solicitante').append(response[0].solicitante);
                    $('#cuenta').append(response[0].cuenta);
                });
                $.get(url2,function (response,prod) {
                    for(var i=0; i<= response.length;i++){

                        var t = $('#productos_solicitados').DataTable();

                        for(var i=0; i<= response.length;i++){

                            t.row.add( [
                                response[i].id,
                                response[i].cantidad,
                                response[i].producto,
                                response[i].unidad,
                                '<input type="checkbox" class ="checkbox" id="chk_'+ i+'">',
                                '<input type="text" style="width:35px;visibility: hidden" value="'+response[i].cantidad+'" id="txt_'+ i+'">',
                                ''

                            ]).draw( false );
                        }
                    }
                });

            });
            $(document).on('change','.checkbox',function (){
                var chk_paso = $(this).attr('id').split('_');

                if(this.checked) {

                    $('#txt_'+chk_paso[1]).css('visibility', 'visible');

                    var $d = $(this).parent("td");
                    var col = $d.parent().children().index($d);
                    var row = $d.parent().parent().children().index($d.parent());

                    $('#productos_solicitados tbody tr:eq(' + row + ')').find('td').eq(6).append(var_select.replace('sel_','sel_'+chk_paso[1]));

                }else{
                    $('#txt_'+chk_paso[1]).css('visibility', 'hidden');
                    var $d = $(this).parent("td");
                    var col = $d.parent().children().index($d);
                    var row = $d.parent().parent().children().index($d.parent());

                    $('#productos_solicitados tbody tr:eq(' + row + ')').find('td').eq(6).html('');
                }
            });
            $(document).on('click', '#recibiroc',function () {
                var data = {"ordencompra": $('#numoc').val(),"factura": $('#numfac').val()};
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({

                    data: JSON.stringify(data),
                    url: '{{route('recibir.post')}}',
                    method: 'POST',

                    success: function(data)
                    {
                        console.log(data);
                        actualiza_det_oc();
                    },
                    error: function(msg)
                    {
                        console.log(msg);
                    }
                });
            });
        });
        function actualiza_det_oc() {
            var myRows = { det_o_compra: [] };
            var x = 0;

            var $th = $('#productos_solicitados th');
            $('#productos_solicitados tbody tr').each(function(i, tr){
                var obj = {}, $tds = $(tr).find('td');
                $th.each(function(index, th){
                    if(index == 5){
                        obj[$(th).text()] = $('#txt_'+x).val();
                        //x++;
                    }else{
                        if(index == 6){
                            obj[$(th).text()] = $('#sel_'+x+' option:selected').text()
                            x++;
                        }else{
                            obj[$(th).text()] = $tds.eq(index).text();
                        }
                    }

                });
                myRows.det_o_compra.push(obj);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({

                data: JSON.stringify(myRows),
                url: '{{route('recibir.detalle.post')}}',
                method: 'POST',

                success: function(data)
                {
                    if(data == 'Ok'){
                        limpiar();
                    }else{
                        console.log(data);
                    }

                },
                error: function(msg)
                {
                    console.log(msg);
                }
            });
        }
        function limpiar(){
            $('#recibiroc').css('visibility','hidden');
            $('#nomProv').html('');
            $('#fec_compra').html('');
            $('#solicitante').html('');
            $('#cuenta').html('');

                var table = $('#productos_solicitados').DataTable();
                table.rows().remove().draw( false );

        }
    </script>
@endsection

