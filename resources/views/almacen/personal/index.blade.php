@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[5]->Todos === 1)
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Listado del Personal</b></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered datatable dt-responsive">
                        <thead style="background-color: #e3f2fd">
                        <tr>
                            <th>CÓDIGO</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>NOMBRES</th>
                            <th>T/DOC.</th>
                            <th>N° DOCUMENTO</th>
                            <th>CARGO</th>
                            <th>FECHA DE INGRESO</th>
                            <th align="center" style="width:10%;text-align: center;" scope="col">
                                @if($usuario_opciones[5]->Ing_Opc === 1)
                                    <a href="{{url('almacen/personal/create')}}" class="btn btn-primary"
                                       data-toggle="tooltip" data-placement="top" title=" Agregar Articulo"><span
                                                class="glyphicon glyphicon-plus"></span>
                                    </a>
                                @endif
                                @if($usuario_opciones[5]->Imp_Opc === 1)
                                    <a href="#" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                       title="Reporte"><span class="glyphicon glyphicon-list-alt"></span></a>
                                @endif
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($personal as $per)
                            <tr>
                                <td>{{$per->Cod_Per}}</td>
                                <td>{{$per->Pat_Per}}</td>
                                <td>{{$per->Mat_Per}}</td>
                                <td>{{$per->Nom_Per}}</td>
                                <td>{{$per->Tip_Doc}}</td>
                                <td>{{$per->Num_Doc}}</td>
                                <td>{{$per->Nom_Tip_Crg}}</td>
                                <td>{{$per->Fec_Ing}}</td>
                                <td>
                                    @if($usuario_opciones[5]->Mod_Opc === 1)
                                        <a href="{{ url('almacen/personal/edit', ['codEmp' => '01', 'CodPer' => $per->Cod_Per, 'NomPer' => $per->Nom_Per]) }}"
                                           class="btn btn-primary"><span
                                                    class='glyphicon glyphicon-pencil'></span></a>
                                    @endif
                                    @if($usuario_opciones[5]->Bor_Opc === 1)
                                        <a href="" data-target="#modal-delete-{{$per->Cod_Per}}"
                                           data-toggle="modal">
                                            <button class="btn btn-danger"><span
                                                        class='glyphicon glyphicon-trash'></span></button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @include('almacen.personal.modal')
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




