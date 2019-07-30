@extends('bodega')
@section('nombre_conectado')
    <a class="nav-link">{{auth()->user()->nombre}}</a>
@endsection

@section('cuerpo')
    <div style="width: 40%;height:7%;float: left; position: relative">
        <div style="width: 50%; float: left; position: relative">
            <select id="sol" class="form-control" style="width: 90%;height: 30px;font-size: 12px">
                <option value="0">Solicitante</option>
                @foreach($ocs as $s)
                    <option value={{$s->oc}}>{{$s->proveedor}}</option>
                @endforeach
            </select>
        </div>
        <div style="width: 50%; float: left; position: relative">
            <button type="button" id = "genoc" class="btn btn-secondary btn-sm" >Genera Orden de Compra</button>
        </div>
    </div>
    <div id = "ordencompra" style="position: absolute;top: 25%;width: 70%" align="center">
        <div id="nombreSolicitante" style="float: left;position: absolute">
            <h4 id = "nombreSolicitante"> Solciedad de Inversiones</h4>
            <h6 id = "nombreCortoSolicitante">Taringa</h6>
        </div>
        </br>
        <div id="datosSolicitante" style="width: 100%;position:relative; top:30%" class="bordes" align="left">
            <label style="margin-left: 5px">giro</label>

        </div>


    </div>
@endsection
