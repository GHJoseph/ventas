@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[0]->Ing_Opc === 1)
        <form action="{{ url('almacen/articulo/create/') }}" method="POST" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Registro del Artículo</b></h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="CodArt">Código</label>
                                        <input type='text' name="CodArt" class="form-control " id="CodArt" disabled>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre del Artículo</label>
                                        <input type='text' name="NomArt" class="form-control"
                                               placeholder="Nombre de Artículo" required></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodRub">Familia</label>
                                        <select name="CodRub" id="CodRub" class="form-control">
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
                                        <select name="CodUnd" class="form-control">
                                            @foreach($unidad as $unid)
                                                <option value="{{$unid->Cod_Und}}">{{$unid->Nom_Und}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Precio">Precio Minimo S/</label>
                                        <input type='number' name="pmin" id="pmin" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Precio">Precio Venta S/</label>
                                        <input type='number' name="pventa" id="pventa" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Precio">Precio Minimo $</label>
                                        <input type='number' name="pminME" id="pminME" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Precio">Precio Venta $</label>
                                        <input type='number' name="pventaME" id="pventaME" class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="StockMin">Stock Minimo</label>
                                        <input type='number' name="StockMin" class="form-control"
                                               placeholder="Ingrese stock mínimo">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="StockMax">Stock Máximo</label>
                                        <input type='number' name="StockMax" class="form-control"
                                               placeholder="Ingrese stock máximo">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="StockMin">Stock Actual</label>
                                        <input type='number' name="StockMin" class="form-control"
                                               placeholder="Ingrese stock mínimo">
                                    </div>
                                </div>

                                <!--<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="FecArt">Fecha Creación</label>
                                        <input type="datetime" name="FecArt" class="form-control pull-right" id="FecArt">
                                    </div>
                                </div>-->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="imagen">Foto</label> <img id="imgSalida" class="img-fluid img-thumbnail"
                                                                      src=""/>
                                <!--
                                                                        <br />
                                                                        <input name="fileToUpload" class="form-control" id="fileToUpload" type="file" />
                                -->
                                <input type="file" name="FotoArt" id="fileToUpload" class="form-control">
                                <!--Defina un campo de selección de archivos y un botón "Examinar ..." (para cargas de archivos):
                                                                        <input type="submit" value="Upload Image" name="I"> -->
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <img id="imagen" src="" class="img img-thumbnail">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary Insertar" title="Registrar"><span
                                class="glyphicon glyphicon-floppy-saved"></span> Registrar
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
        $("#fileToUpload").change(function () {
            readurl(this);
        });

        function readurl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#imagen").attr("src", e.target.result)
                }
                reader.readAsDataURL(input.files[0])
            }
        }
    </script>
@endsection