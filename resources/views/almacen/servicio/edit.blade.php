@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[1]->Mod_Opc === 1)
        <form action="{{ url('almacen/servicio/edit/') }}" method="POST">
            <div class="panel panel-default">

                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Actualización del Servicio</b></h3>
                </div>
                <div class="panel-body">

                    @foreach($servicio as $serv)

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="CodServ">Código</label>
                                    <input type='text' value="{{ $serv->Cod_Serv }}" name="CodServ" class="form-control"
                                           id="CodServ" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="NomServ">Nombre</label>
                                    <input type='text' name="NomServ" value="{{ $serv->Nom_Serv }}" class="form-control"
                                           placeholder="Nombre de Artículo" id="NomServ">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="DesServ">Descripción</label>
                                    <input type='text' name="DesServ" value="{{ $serv->Des_Serv }}" class="form-control"
                                           placeholder="Descripción del Artículo" id="DesServ">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="CodServ">Precio</label>
                                    <input type='text' name="PreServ" value="{{ $serv->Pre_Serv }}"
                                           class="form-control " id="PreServ">
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="CodServ" value="{{ $serv->Cod_Serv }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @endforeach

                </div>
                <div class="panel-footer">
                    <button type="submit" id="Insert" name="Insert" class="btn btn-primary Insertar" title="Grabar">
                        <span class="glyphicon glyphicon-floppy-saved"></span> Actualizar
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




