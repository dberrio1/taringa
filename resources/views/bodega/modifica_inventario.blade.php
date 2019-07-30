@extends('bodega')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')
    <div style="width: 40%;height: 20%;float: left; position: relative">
        <select id="familia" class="form-control" style="height: 30px;font-size: 12px">
            <option value="0">Familia de Producto</option>
            @foreach($familias as $familia)
                <option value={{$familia['id']}}>{{$familia['nombre']}}</option>
            @endforeach
        </select>
        <p style="height: 0px"></p>

        <select id="producto" class="form-control" style="height: 30px;font-size: 12px">
            <option value="0">Producto</option>
        </select>

        <button type="button" id = "bscProducto" class="btn btn-secondary btn-sm btn-block" style="position: absolute;bottom: 0">Buscar Producto</button>

    </div>
    <div style="width: 30%;height: 53%;margin-top: 10%; position: absolute">
        <div class="form-group">
            <label for="exampleFormControlInput1">Producto</label>
            <input class="form-control form-control-sm" type="text" id="producto" style="text-align: left" readonly>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Existencia</label>
            <input class="form-control form-control-sm" type="text" id="cantidad" style="text-align: left;width: 50px" readonly>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nueva Cantidad</label>
            <input class="form-control form-control-sm" type="text" id="nuevo" style="text-align: left;width: 50px">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Observaciones</label>
            <input class="form-control form-control-sm" type="text" id="nuevo" style="text-align: left;width: 50px">
        </div>
        <button type="button" id = "nvoProducto" class="btn btn-secondary btn-sm btn-block" style="position: absolute;bottom: 0">Guarda Producto</button>
    </div>


@endsection

@section('js_bodega')

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
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
        $(document).on('click', '#bscProducto',function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({

                data: $('#producto option:selected').text(),
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

</script>
@endsection
