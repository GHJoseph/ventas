@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[11]->Todos === 1)
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #1fb5ad;">
                        <h3 class="panel-title" style="color:#fff;"><b><i class="fa fa-male"></i> Listado de
                                Usuarios</b></h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered datatable dt-responsive display nowrap" style="width:100%">
                            <thead style="background-color: #e3f2fd">
                            <tr>
                                <th>CÓDIGO</th>
                                <th>USUARIO</th>
                                <th>NOMBRE Y APELLIDOS</th>
                                <th>T/DOC.</th>
                                <th>N° DOCUMENTO</th>
                                <th>TIPO DE USUARIO</th>
                                <th align="center" style="width:10%;text-align: center;" scope="col">
                                    @if($usuario_opciones[11]->Ing_Opc === 1)
                                        <a href="{{route('usuarios.create')}}" class="btn btn-primary"
                                           data-toggle="tooltip"
                                           data-placement="top" title=" Agregar Articulo"><span
                                                    class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    @endif
                                    @if($usuario_opciones[11]->Imp_Opc === 1)
                                        <a href="#" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                           title="Reporte"><span
                                                    class="glyphicon glyphicon-list-alt"></span></a>
                                    @endif
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($usuarios as $usu)
                                <tr>
                                    <td>{{$usu->Cod_Usu}}</td>
                                    <td>{{$usu->Nom_Usu}}</td>
                                    <td>{{$usu->Nom_Per}}</td>
                                    <td>{{$usu->Tip_Doc}}</td>
                                    <td>{{$usu->Num_Doc}}</td>
                                    <td>{{$usu->Nom_Tip_Usu}}</td>
                                    <td>
                                        @if($usuario_opciones[11]->Mod_Opc === 1)
                                            <a href="{{ route('usuarios.edit',$usu->Cod_Usu) }}"
                                               class="btn btn-primary"><span class='glyphicon glyphicon-pencil'></span></a>
                                        @endif
                                        @if($usuario_opciones[11]->Bor_Opc === 1)
                                            <a href=""
                                               data-target="#modal-delete-{{$usu->Cod_Usu}}"
                                               data-toggle="modal">
                                                <button class="btn btn-danger"><span
                                                            class='glyphicon glyphicon-trash'></span>
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @include('almacen.usuario.modal')
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
