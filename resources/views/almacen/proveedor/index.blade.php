@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[4]->Todos === 1)
        <div class="row">
            <div class="col-xs-11 col-lg-11">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{url('almacen/proveedor')}}"><i class="fa fa-home"></i> Proveedor</a></li>
                    <li class="active">Datos</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
            <div class="col-xs-1 col-lg-1">
                <a href="#" class="btn btn-warning btn-block" data-toggle="tooltip" data-placement="top"
                   title="Reporte"><span class="glyphicon glyphicon-list-alt"></span></a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">

                    <div class="panel-heading" style="background-color: #1fb5ad;">
                        <h3 class="panel-title" style="color:#fff;"><b>Listado de Proveedores</b></h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered datatable dt-responsive">
                            <thead style="background-color: #e3f2fd">
                            <tr>
                                <th>CÓDIGO</th>
                                <th>NOMBRE</th>
                                <th>T/DOC.</th>
                                <th>N° DOCUMENTO</th>
                                <th>DIRECCIÓN</th>
                                <th>TELÉFONO</th>
                                <th algin="center" style="width:10%;text-align: center;">
                                    @if($usuario_opciones[4]->Ing_Opc === 1)
                                        <a href="{{url('almacen/proveedor/create')}}" class="btn btn-primary"
                                           data-toggle="tooltip"
                                           data-placement="top" title="Agregar Proveedor"><span
                                                    class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    @endif
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($proveedores as $prov)
                                <tr>
                                    <td>{{$prov->Cod_CP}}</td>
                                    <td>{{$prov->Nom_CP}}</td>
                                    <td>{{$prov->Tip_Doc}}</td>
                                    <td>{{$prov->Num_Doc}}</td>
                                    <td>{{$prov->Dir_CP}}</td>
                                    <td>{{$prov->Tel_CP}}</td>
                                    <input type="hidden" value="{{ $prov->Tip_CP }}">
                                    <td>
                                        @if($usuario_opciones[4]->Mod_Opc === 1)
                                            <a href="{{ url('almacen/proveedor/edit', ['codEmp' => '01', 'CodCP' => $prov->Cod_CP, 'TipCP' => $prov->Tip_CP, 'NomCP' => $prov->Nom_CP]) }}"
                                               class="btn btn-primary"><span
                                                        class='glyphicon glyphicon-pencil'></span>
                                            </a>
                                        @endif
                                        @if($usuario_opciones[4]->Bor_Opc === 1)
                                            <a href="" data-target="#modal-delete-{{$prov->Cod_CP}}"
                                               data-toggle="modal">
                                                <button class="btn btn-danger"><span
                                                            class='glyphicon glyphicon-trash'></span>
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @include('almacen.proveedor.modal')
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

