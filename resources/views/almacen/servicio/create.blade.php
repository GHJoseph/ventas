@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[1]->Ing_Opc === 1)
    <form action="{{ url('almacen/servicio/create/') }}" method="POST">
        <div class="row">
            <div class="col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{url('almacen/servicio')}}"><i class="fa fa-home"></i> Servicios</a></li>
                    <li class="active">Crear</li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #1fb5ad;">
                <h3 class="panel-title" style="color:#fff;"><b>Registro del Servicio</b></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="CodServ">Código</label>
                            <input type='text' name="CodServ" class="form-control " id="CodServ" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="NomServ">Nombre</label>
                            <input type='text' name="NomServ" class="form-control" placeholder="Nombre de Artículo"
                                   id="NomServ">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="DesServ">Descripción</label>
                            <input type='text' name="DesServ" class="form-control"
                                   placeholder="Descripción del Artículo" id="DesServ">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="CodServ">Precio</label>
                            <input type='text' name="PreServ" class="form-control " id="PreServ">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
            <div class="panel-footer">
                <button type="submit" id="Insert" name="Insert" class="btn btn-primary Insertar" title="Grabar">
                    <span class="glyphicon glyphicon-floppy-saved"></span> Registrar
                </button>
                <a href="{{ url('almacen/servicio') }}" class="btn btn-success" data-toggle="tooltip"
                   data-placement="top" title="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>
                    Cancelar</a>
            </div>
        </div>
    </form>
    @else
        <div class="alert alert-info">
            <b><i class="fa fa-warning"></i></b> Usted no tiene acceso a esta opción, comuniquese con el administrador
            para que le dé los permisos necesarios.
        </div>
    @endif
@endsection




