@extends('bodega')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')
    <div style="width: 70%; float: left; position: absolute; top: 25%" class="bordes">
        <label style="font-weight:bold;margin-left: 5px"> Fec. Solicitud</label>
        <label style="text-indent: 7px;">:</label>
        <label id="fec_solicitud" style="font-weight:bold;margin-left: 5px"></label>
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

    </div>

@endsection
@section('js_bodega')
    <script type="text/javascript">
        $(document).ready(function () {
            var i=1;
            buscaSol();

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

        });
        function limpiar(){
            $('#recibirsol').css('visibility','hidden');
            $('#fec_compra').html('');
            $('#solicitante').html('');
            $('#cuenta').html('');
            var table = $('#productos_solicitados').DataTable();
            table.rows().remove().draw( false );
        }
        function buscaSol() {
            var url ="{{route('bodega.solicitud',':id')}}".replace(':id',{{$id}});
            var url2="{{route('bodega.solicitud_detalle',':id')}}".replace(':id',{{$id}});

            $.get(url,function (response,prod) {
                $('#recibirsol').css('visibility','visible');
                $('#fec_compra').html('');
                $('#solicitante').html('');
                $('#cuenta').html('');

                if(response[0].estado === 0){
                    $('#recibirsol').css('visibility','hidden');
                    $('.checkbox').css('visibility','hidden');
                }


                $('#fec_compra').append(response[0].created_at);
                $('#solicitante').append(response[0].solicitante);
                $('#cuenta').append(response[0].cuenta);
            });
            $.get(url2,function (response,prod) {
                for(var i=0; i<= response.length;i++){
                    $('#productos_solicitados tbody tr').empty();
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


        }
    </script>
@endsection

