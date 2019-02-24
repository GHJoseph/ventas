@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[0]->Mod_Opc === 1)
        <form action="{{ url('almacen/articulo/edit/') }}" method="POST" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Actualización del Artículo</b></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                @foreach($articulo as $art)
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="CodArt">Código</label>
                                            <input type='text' value="{{ $art->Cod_Art }}" name="CodArt"
                                                   class="form-control " id="CodArt" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="NomArt">Nombre del Artículo</label>
                                            <input type='text' name="NomArt" value="{{ $art->Nom_Art }}"
                                                   class="form-control" placeholder="Nombre de Artículo"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="CodRub">Rubro</label>
                                            <select name="CodRub" id="CodRub" class="form-control">
                                                <option value="{{$art->Cod_Rub}}" selected>{{ $art->Nom_Rub}}</option>
                                                @foreach($rubro as $rub)
                                                    <option value="{{$rub->Cod_Rub}}">{{$rub->Nom_Rub}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodUnd">Unidad</label>
                                        <select name="CodUnd" id="CodUnd" class="form-control">
                                            <option value="{{$art->Cod_Und}}"> {{$art->Nom_Und}} </option>
                                            @foreach($unidad as $unid)
                                                <option value="{{$unid->Cod_Und}}">{{$unid->Nom_Und}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Precio">Precio Minimo S/</label>
                                        <input type='text' style="text-align:right;" name="pmin" id="pmin" class="form-control"
                                               value="{{ $art->Pre_Min_MN }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Precio">Precio Venta S/</label>
                                        <input type='text' style="text-align:right;" name="pventa" id="pventa" class="form-control"
                                               value="{{ $art->Pre_Vta_MN }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Precio">Precio Minimo $</label>
                                        <input type='text' style="text-align:right;" name="pminME" id="pminME" class="form-control"
                                               value="{{ $art->Pre_Min_ME }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Precio">Precio Venta $</label>
                                        <input type='text' style="text-align:right;" name="pventaME" id="pventaME" class="form-control"
                                               value="{{ $art->Pre_Vta_ME }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="StockMin">Stock Minimo</label>
                                        <input type='number' name="StockMin" value="{{$art->Stock_Min}}"
                                               class="form-control" placeholder="Ingrese stock mínimo">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="StockMax">Stock Maximo</label>
                                        <input type='number' name="StockMax" value="{{$art->Stock_Max}}"
                                               class="form-control" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="StockActual">Stock Actual</label>
                                        <input type='number' name="StockActual" class="form-control" placeholder=""
                                               value="{{$art->Stock_Actual}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="FecArt">Fecha Creación</label>
                                    <input type="datetime" name="FecArt" class="form-control pull-right"
                                           value="{{ date('d-m-Y h:i:s', strtotime($art->Fec_Art))}}" id="FecArt"
                                           readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="FotoArt">Foto</label> <img id="imgSalida" class="img-fluid img-thumbnail"
                                                                       src="@if($art->Foto_Art !== null) {{asset($art->Foto_Art)}} @endif"/>
                                <input type="file" name="FotoArt" id="fileToUpload" class="form-control">
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary Insertar" title="Actualizar"><span
                                class="glyphicon glyphicon-floppy-saved"></span> Actualizar
                    </button>
                    <a href="{{ url('almacen/articulo') }}" class="btn btn-success" data-toggle="tooltip"
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
@section('javascripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#fileToUpload").change(function () {
                readurl(this);
            });

            function readurl(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#imgSalida").attr("src", e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
@endsection
