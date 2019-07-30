@extends('admin')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')
    <form id="proveedores" method="POST">
        <div style="width: 25%;position: absolute; float: left;">
            <div class="form-group">
                <label for="exampleFormControlInput1">Rut</label>
                <input class="form-control form-control-sm" type="text" id="rut" style="text-align: right" placeholder="11.111.111-1">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nombre Proveedor</label>
                <input class="form-control form-control-sm" type="text" id="nombre" style="text-align: left" placeholder="Andina S.A.">
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput1">Nombre Contacto</label>
                <input class="form-control form-control-sm" type="text" id="contacto" style="text-align: left" placeholder="Andres Silva">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Correo Contacto</label>
                <input class="form-control form-control-sm" type="email" id="correo" style="text-align: left" placeholder="nombre@empresa.cl">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Fono Contacto</label>
                <input class="form-control form-control-sm" type="text" id="fono" style="text-align: right" placeholder="223332211">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Estado</label>
                <select class="form-control form-control-sm">
                    <option value = "1">Vigente</option>
                    <option value = "0">Bloqueado</option>
                </select>

            </div>
            <input type="button" id="grabar" class="btn btn-secondary btn-sm btn-block" value="Grabar">


        </div>
    </form>
    <div id="divProveedores" style="width: 65%;position: relative;float: right">
        <table id="tblProveedores" class="display" style="width:100%;font-size: 13px">
            <thead>
            <tr>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th>Correo</th>
                <th>Fono</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prov as $key => $p)
                <tr>
                    <td>{{$p->rut}}</td>
                    <td>{{$p->nombre}}</td>
                    <td>{{$p->contacto}}</td>
                    <td>{{$p->correo}}</td>
                    <td>{{$p->fono}}</td>
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
            var i = 1;
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            $(document).on('click', '#grabar',function (e) {
                e.preventDefault();

                var form = {rut:$('#rut').val(), nombre: $('#nombre').val(), contacto: $('#contacto').val(), correo: $('#correo').val(),fono:$('#fono').val()};
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({

                    data: JSON.stringify(form),
                    url: '{{route('admin.proveedor')}}',
                    method: 'POST',

                    success: function(data)
                    {
                        console.log(data);
                        var t = $('#tblProveedores').DataTable()

                        t.row.add( [
                            $('#rut').val(),
                            $('#nombre').val(),
                            $('#contacto').val(),
                            $('#correo').val(),
                            $('#fono').val()
                        ] ).draw( false );
                        $('input').val('');

                    },
                    error: function(msg)
                    {
                        console.log(msg);
                    }
                });
            });
            $('#tblProveedores').DataTable( {
                "scrollY": "800px",
                "scrollCollapse": true,
                "paging": false,
                "searching": true,
                "info":     true
            } );


        });

    </script>
@endsection
