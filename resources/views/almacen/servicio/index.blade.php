@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[1]->Todos === 1)
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #1fb5ad;">
                        <h3 class="panel-title" style="color:#fff;"><b>Listado de Servicios</b></h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered datatable dt-responsive">
                            <thead style="background-color: #e3f2fd">
                            <tr>
                                <th>CÓDIGO</th>
                                <th>SERVICIO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>PRECIO</th>
                                <th align="center" style="width:10%;text-align: center;">
                                    @if($usuario_opciones[1]->Ing_Opc === 1)
                                        <a href="{{url('almacen/servicio/create')}}" class="btn btn-primary"
                                           data-toggle="tooltip" data-placement="top" title=" Agregar Articulo"><span
                                                    class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                       title="Reporte"><span class="glyphicon glyphicon-list-alt"></span></a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($servicios as $serv)
                                <tr>
                                    <td>{{$serv->Cod_Serv}}</td>
                                    <td>{{$serv->Nom_Serv}}</td>
                                    <td>{{$serv->Des_Serv}}</td>
                                    <td>{{$serv->Pre_Serv}}</td>
                                    <td>
                                        @if($usuario_opciones[1]->Mod_Opc === 1)
                                            <a href="{{ url('almacen/servicio/edit', ['codEmp' => '01', 'CodServ' => $serv->Cod_Serv, 'NomServ' => $serv->Nom_Serv]) }}"
                                               class="btn btn-primary"><span class='glyphicon glyphicon-pencil'></span>
                                            </a>
                                        @endif
                                        @if($usuario_opciones[1]->Bor_Opc === 1)
                                            <a href="" data-target="#modal-delete-{{$serv->Cod_Serv}}"
                                               data-toggle="modal">
                                                <button class="btn btn-danger"><span
                                                            class='glyphicon glyphicon-trash'></span>
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @include('almacen.servicio.modal')
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <b><i class="fa fa-warning"></i></b> Usted no tiene acceso a esta opción, comuniquese con el administrador
            para que le dé los permisos necesarios.
        </div>
    @endif
@endsection


