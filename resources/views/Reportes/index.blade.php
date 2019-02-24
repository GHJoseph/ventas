@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[9]->Todos === 1)
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #1fb5ad;">
                        <h3 class="panel-title" style="color:#fff;"><b><i class="fa fa-file"></i> Reportes</b></h3>
                    </div>
                    <div class="panel-body">
                        <form action=" {{route('reportes.index')}}" method="GET">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="CodRep">Reporte</label>
                                    <select name="CodRep" id="CodRep" class="form-control">
                                        <option value="0">Ventas
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group" style="margin-right: 10px;">
                                    <label class="">Desde</label>
                                    <div data-date-viewmode="years" data-date-format="dd-mm-yyyy"
                                         data-date="{{$inicio}}"
                                         class="input-append date dpYears">
                                        <input id="desde" name="desde" type="text" readonly="" value="{{$inicio}}"
                                               size="16"
                                               class="form-control">
                                        <span class="input-group-btn add-on">
                                                <button class="btn btn-primary" type="button"><i
                                                            class="fa fa-calendar"></i></button>
                                              </span>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-right: 10px;">
                                    <label for="hasta">Hasta</label>
                                    <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="{{$fin}}"
                                         class="input-append date dpYears">
                                        <input id="hasta" name="hasta" type="text" readonly="" value="{{$fin}}"
                                               size="13"
                                               class="form-control">
                                        <span class="input-group-btn add-on">
                                                <button class="btn btn-primary" type="button"><i
                                                            class="fa fa-calendar"></i></button>
                                              </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <label for="hasta">Opciones</label>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    @if($usuario_opciones[9]->Imp_Opc === 1)
                                        <a href="{{ route('ventas.excel',['desde'=>$inicio,'hasta'=>$fin]) }}"
                                           class="btn btn-success"><i
                                                    class="fa fa-table"></i> Excel</a>
                                        {{-- <button class="btn btn-danger"><i class="fa fa-file-o"></i> PDF</button>--}}
                                    @endif
                                </div>
                            </div>
                        </form>
                        <div class="col-xs-12">
                            <table class="table table-bordered dt-responsive datatable">
                                <thead style="background-color: #e3f2fd">
                                <tr>
                                    <th class="text-center">N° de Venta</th>
                                    <th class="text-center">Fecha de Venta</th>
                                    <th class="text-center">Doc</th>
                                    <th class="text-center">Serie</th>
                                    <th class="text-center">Número</th>
                                    <th class="text-center">Fecha de Doc</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Total S/</th>
                                    {{-- <th>TOTAL $US</th>--}}
                                    <th class="text-center">Moneda</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ventas as $venta)
                                    <tr>
                                        <td class="text-center">{{$venta->Num_Vnt}}</td>
                                        <td class="text-center">{{date('d-m-Y', strtotime($venta->Fec_Vnt))}}</td>
                                        <td class="text-center">{{$venta->Tip_Doc}}</td>
                                        <td class="text-center">{{$venta->Ser_Doc}}</td>
                                        <td class="text-center">{{$venta->Num_Doc}}</td>
                                        <td class="text-center">{{date('d-m-Y', strtotime($venta->Fec_Doc))}}</td>
                                        <td class="text-left">{{$venta->Nom_CP}}</td>
                                        <td class="text-right">{{$venta->Tot_Vta_MN}}</td>
                                        {{--<td>{{$venta->Tot_Vta_ME}}</td>--}}
                                        <td class="text-center">{{$venta->Cod_Mon }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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
@section('javascripts')
    <script type="text/javascript">
        $('.dpYears').datepicker({
            autoclose: true,
            orientation: "auto top",
            format: 'dd-mm-yyyy'
        });
    </script>
@endsection
