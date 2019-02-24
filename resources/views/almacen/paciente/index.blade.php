@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[3]->Todos === 1)
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Listado de Pacientes</b></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered datatable dt-responsive">
                        <thead style="background-color: #e3f2fd">
                        <tr>
                            <th>CÓDIGO</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>T/DOC</th>
                            <th>N° DOCUMENTO</th>
                            <th>DIRECCIÓN</th>
                            <th align="center" style="width:10%;text-align: center;" scope="col">
                                @if($usuario_opciones[3]->Ing_Opc === 1)
                                    <a href="{{url('almacen/paciente/create')}}" class="btn btn-primary"
                                       data-toggle="tooltip"
                                       data-placement="top" title=" Agregar Articulo"><span
                                                class="glyphicon glyphicon-plus"></span>
                                    </a>
                                @endif
                                @if($usuario_opciones[3]->Imp_Opc === 1)
                                    <a href="#" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                       title="Reporte"><span
                                                class="glyphicon glyphicon-list-alt"></span></a>
                                @endif
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pacientes as $pas)
                            <tr>
                                <td>{{$pas->Cod_Pac}}</td>
                                <td>{{$pas->Nom_Pac}}</td>
                                <td>{{$pas->Pat_Pac}}</td>
                                <td>{{$pas->Mat_Pac}}</td>
                                <td>{{$pas->Tip_Doc}}</td>
                                <td>{{$pas->Num_Doc}}</td>
                                <td>{{$pas->Dir_Pac}}</td>
                                <td>
                                    @if($usuario_opciones[3]->Mod_Opc === 1)
                                        <a href="{{ url('almacen/paciente/edit', ['codEmp' => '01', 'codLoc' => '01', 'CodPac' => $pas->Cod_Pac, 'nomPac' => $pas->Nom_Com]) }}"
                                           class="btn btn-primary"><span class='glyphicon glyphicon-pencil'></span></a>
                                    @endif
                                    @if($usuario_opciones[3]->Bor_Opc === 1)
                                        <a href="" data-target="#modal-delete-{{$pas->Cod_Pac}}"
                                           data-toggle="modal">
                                            <button class="btn btn-danger"><span
                                                        class='glyphicon glyphicon-trash'></span>
                                            </button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @include('almacen.paciente.modal')
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
