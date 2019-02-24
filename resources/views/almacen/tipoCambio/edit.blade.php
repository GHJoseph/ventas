@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[14]->Mod_Opc === 1)
        {!! Form::model($tipos, ['method' => 'PATCH','route' => ['tipos.update', $tipos->NumDia]]) !!}
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #1fb5ad;">
                <h3 class="panel-title" style="color:#fff;"><b>Actualización del Tipo de Cambio</b></h3>
            </div>
            <div class="panel-body">
                <input type="hidden" name="anno" value="{{$tipos->Anno}}">
                <input type="hidden" name="mes" value="{{$tipos->NumMes}}">
                <div class="col-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="CodUsu">Fecha</label>
                            <input type='text' name="fecha" class="form-control " id="fecha"
                                   value="{{$tipos->NumDia}}-{{$tipos->NumMes}}-{{$tipos->Anno}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="compra">Precio de Compra</label>
                            <input type='text' name="compra" class="form-control " id="compra"
                                   value="{{$tipos->Val_Cmp}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="venta">Precio de Venta</label>
                            <input type='text' name="venta" class="form-control " id="venta"
                                   value="{{$tipos->Val_Vta}}" readonly>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
            <div class="panel-footer">
                <button type="submit" id="Insert" class="btn btn-primary Insertar" title="Grabar"><span
                            class="glyphicon glyphicon-floppy-saved"></span> Actualizar
                </button>
                <a href="{{ url('tipos.index') }}" class="btn btn-success" data-toggle="tooltip"
                   data-placement="top" title="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>
                    Cancelar</a>
            </div>
        </div>
        {!! Form::close() !!}
    @else
        <div class="alert alert-info">
            <b><i class="fa fa-warning"></i></b> Usted no tiene acceso a esta opción, comuniquese con el administrador
            para que le dé los permisos necesarios.
        </div>
    @endif
@endsection
