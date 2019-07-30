@extends('bodega')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')
    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active">
            Solicitudes Pendientes
        </a>
        @foreach($solicitudes as $sol)
            <a href="{{route('bodega.sol_detalle',[$sol->id])}}" class="list-group-item list-group-item-action"><b>{{$sol->solicitante}}:</b>  {{$sol->cuenta}}({{$sol->id}})</a>

        @endforeach

    </div>

@endsection

@section('js_bodega')
    <script type="text/javascript">
        $(document).ready(function () {
            var i = 1;
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });

    </script>
@endsection
