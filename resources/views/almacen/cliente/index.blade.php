@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[2]->Todos === 1)
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">

                    <div class="panel-heading" style="background-color: #1fb5ad;">
                        <h3 class="panel-title" style="color:#fff;"><b><i class="fa fa-male"></i> Listado de
                                Clientes</b></h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered datatable dt-responsive">
                            <thead style="background-color: #e3f2fd">
                            <tr>
                                <th>CÓDIGO</th>
                                <th>NOMBRE</th>
                                <th>T/DOC.</th>
                                <th>N. DOCUMENTO</th>
                                <th>PACIENTE</th>
                                <th>TELÉFONO</th>
                                <th align="center" style="width:10%;text-align: center;">
                                    @if($usuario_opciones[2]->Ing_Opc === 1)
                                        <a href="{{url('almacen/cliente/create')}}" class="btn btn-primary"
                                           data-toggle="tooltip"
                                           data-placement="top" title="Agregar Cliente"><span
                                                    class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                       title="Reporte"><span class="glyphicon glyphicon-list-alt"></span></a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{$cliente->Cod_CP}}</td>
                                    <td>{{$cliente->Ape_CP}} {{$cliente->Nom_CP}}</td>
                                    <td>{{$cliente->Tip_Doc}}</td>
                                    <td>{{$cliente->Num_Doc}}</td>
                                    <td>{{$cliente->Nom_Pac}}</td>
                                    <td>{{$cliente->Tel_CP}}</td>
                                    <input type="hidden" value="{{ $cliente->Tip_CP }}">
                                    <td>
                                        @if($usuario_opciones[2]->Mod_Opc === 1)
                                            <a href="{{ url('almacen/cliente/edit', ['codEmp' => '01', 'CodCP' => $cliente->Cod_CP, 'TipCP' => $cliente->Tip_CP, 'NomCP' => $cliente->Nom_CP]) }}"
                                               class="btn btn-primary"><span class='glyphicon glyphicon-pencil'></span>
                                            </a>
                                        @endif
                                        @if($usuario_opciones[2]->Bor_Opc === 1)
                                            <a href="" data-target="#modal-delete-{{$cliente->Cod_CP}}"
                                               data-toggle="modal">
                                                <button class="btn btn-danger"><span
                                                            class='glyphicon glyphicon-trash'></span>
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @include('almacen.cliente.modal')
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

