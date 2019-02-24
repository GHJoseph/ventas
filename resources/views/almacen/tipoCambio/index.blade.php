@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[14]->Todos === 1)
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #1fb5ad;">
                        <h3 class="panel-title" style="color:#fff;"><b><i class="fa fa-dollar"></i> Listado de Tipos de
                                Cambio</b>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered datatable dt-responsive display nowrap" style="width:100%">
                            <thead style="background-color: #e3f2fd">
                            <tr>
                                <th>Fecha</th>
                                <th>Valor de Compra</th>
                                <th>Valor de Venta</th>
                                <th>Fecha y Hora Obtenida</th>
                                <th align="center" style="width:10%;text-align: center;" scope="col">
                                    {{--@if($usuario_opciones[14]->Ing_Opc === 1)
                                        <a href="{{route('tipos.create')}}" class="btn btn-primary"
                                           data-toggle="tooltip"
                                           data-placement="top" title=" Agregar Tipo de Cambio"><span
                                                    class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    @endif--}}
                                    @if($usuario_opciones[14]->Imp_Opc === 1)
                                        <a href="#" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                           title="Tipo de cambio"><span
                                                    class="glyphicon glyphicon-list-alt"></span></a>
                                    @endif
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($valores as $valor)
                                <tr>
                                    <td>{{$valor->NumDia}}-{{$valor->NumMes}}-{{$valor->Anno}}</td>
                                    <td>{{$valor->Val_Cmp}}</td>
                                    <td>{{$valor->Val_Vta}}</td>
                                    <td>{{$valor->Fecha}}</td>
                                    <td>
                                        @if($usuario_opciones[14]->Mod_Opc === 1)
                                            <a href="{{ route('editTipoCambio',[$valor->NumDia,$valor->NumMes,$valor->Anno]) }}"
                                               class="btn btn-primary"><span class='glyphicon glyphicon-pencil'></span></a>
                                        @endif
                                        {{--@if($usuario_opciones[14]->Bor_Opc === 1)
                                            <a href=""
                                               data-target="#modal-delete-{{$valor->NumDia}}"
                                               data-toggle="modal">
                                                <button class="btn btn-danger"><span
                                                            class='glyphicon glyphicon-trash'></span>
                                                </button>
                                            </a>
                                        @endif--}}
                                    </td>
                                </tr>

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
