@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[0]->Todos === 1)
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #1fb5ad;">
                        <h3 class="panel-title" style="color:#fff;"><b>Listado de Artículos</b></h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered datatable dt-responsive">
                            <thead style="background-color: #e3f2fd">
                            <tr>
                                <th class="text-center">CÓDIGO</th>
                                <th class="text-center">DESCRIPCIÓN</th>
                                <th class="text-center">UNIDAD</th>
                                <th class="text-center">STOCK-MIN</th>
                                <th class="text-center">STOCK-MAX</th>
                                <th class="text-center">PRECIO-MINIMO</th>
                                <th class="text-center">PRECIO-VENTA</th>
                                <th align="center" style="width:10%;text-align: center;">
                                    @if($usuario_opciones[0]->Ing_Opc === 1)
                                        <a href="{{url('almacen/articulo/create')}}" class="btn btn-primary"
                                           data-toggle="tooltip"
                                           data-placement="top" title=" Agregar Articulo"><span
                                                    class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    @endif
                                    <a href="#" class="btn btn-warning" data-toggle="tooltip" data-placement="top"
                                       title="Reporte"><span class="glyphicon glyphicon-list-alt"></span></a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articulos as $art)
                                <tr>
                                    <td class="text-center">{{$art->Cod_Art}}</td>
                                    <td>{{$art->Nom_Art}}</td>
                                    <td class="text-center">{{$art->Tip_Und}}</td>
                                    <td class="text-center">{{$art->Stock_Min}}</td>
                                    <td class="text-center">{{$art->Stock_Max}}</td>
                                    <td style="text-align:right;" class="precio">{{$art->Pre_Min_MN}}</td>
                                    <td style="text-align:right;" class="precio">{{$art->Pre_Vta_MN}}</td>
                                    <td class="text-center">
                                        @if($usuario_opciones[0]->Mod_Opc === 1)
                                            <a href="{{ url('almacen/articulo/edit', ['codEmp' => '01', 'codALM' => '01', 'CodArt' => $art->Cod_Art, 'NomArt' => $art->Nom_Art, 'pmin' => $art->Pre_Min_MN,'pventa' => $art->Pre_Vta_MN]) }}"
                                               class="btn btn-primary"><span class='glyphicon glyphicon-pencil'></span></a>
                                        @endif
                                        @if($usuario_opciones[0]->Bor_Opc === 1)
                                            <a href="" data-target="#modal-delete-{{$art->Cod_Art}}"
                                               data-toggle="modal">
                                                <button class="btn btn-danger"><span
                                                            class='glyphicon glyphicon-trash'></span>
                                                </button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @include('almacen.articulo.modal')
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

