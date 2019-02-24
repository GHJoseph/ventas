@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[12]->Mod_Opc === 1)
        {!! Form::open(['url' => '/roles/'.$usuario->Cod_Usu, 'method' => 'PATCH'])!!}
        <div class="row">
            <div class="col-sm-9 icheck ">
                <div class="minimal single-row">
                    <div class="checkbox ">
                        <input type="checkbox">
                        <label>Black Checkbox </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #1fb5ad;">
                        <h3 class="panel-title" style="color:#fff;"><b><i class="fa fa-users"></i>
                                Menus</b></h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="CodUsu">Código</label>
                                    <input type='text' name="CodUsu" class="form-control"
                                           id="CodUsu" value="{{$usuario->Cod_Usu}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="NomUsu">Usuario</label>
                                    <input type='text' name="NomUsu" class="form-control" id="NomUsu"
                                           value="{{$usuario->Nom_Usu}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="NomPer">Personal</label>
                                    <input type='text' name="NomPer" class="form-control" id="NomPer"
                                           value="{{$usuario->Pat_Per}} {{$usuario->Mat_Per}} {{$usuario->Nom_Per}}"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="TipUsu">Tipo</label>
                                    <input type='text' name="TipUsu" class="form-control" id="TipUsu"
                                           value="{{$usuario->Nom_Tip_Usu}}" readonly>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered dt-responsive tabla" style="width:100%">
                            <thead style="background-color: #e3f2fd">
                            <tr>
                                <th class="text-center">Código de Menu</th>
                                <th class="text-center">Nombre de Menus</th>
                                <th class="text-center">Todo</th>
                                <th class="text-center">Nuevo</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Eliminar</th>
                                <th class="text-center">Imprimir</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($opciones)>0)
                                @foreach($opciones as $opcion)
                                    <tr>
                                        <td class="text-center">{{$opcion->Cod_Men}}</td>
                                        <td>{{$opcion->Nom_Men}}</td>
                                        <td class="text-center">
                                            <input id="{{$opcion->Cod_Men}}" type="checkbox"
                                                   class="check" @if($opcion->Todos===1) checked @endif>
                                            <input type="hidden" name="sel[]"
                                                   value="@if($opcion->Todos===1) 1 @else 0 @endif">
                                            <input type="hidden" name="opcion[]" value="{{$opcion->Cod_Men}}">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="" value="" @if($opcion->Ing_Opc === 1) checked
                                                   @endif
                                                   class="op-{{$opcion->Cod_Men}} nuevo"
                                                   @if($opcion->Todos===0) disabled @endif>
                                            <input type="hidden" name="nuevo[]" class="n-{{$opcion->Cod_Men}}"
                                                   value="@if($opcion->Ing_Opc===1) 1 @else 0 @endif">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="" value=""
                                                   class="op-{{$opcion->Cod_Men}} editar"
                                                   @if($opcion->Mod_Opc === 1) checked @endif
                                                   @if($opcion->Todos===0) disabled @endif>
                                            <input type="hidden" name="editar[]" class="e-{{$opcion->Cod_Men}}"
                                                   value="@if($opcion->Mod_Opc===1) 1 @else 0 @endif">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="" value=""
                                                   class="op-{{$opcion->Cod_Men}} borrar"
                                                   @if($opcion->Bor_Opc === 1) checked @endif
                                                   @if($opcion->Todos===0) disabled @endif>
                                            <input type="hidden" name="borrar[]" class="b-{{$opcion->Cod_Men}}"
                                                   value="@if($opcion->Bor_Opc===1) 1 @else 0 @endif">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="" value=""
                                                   class="op-{{$opcion->Cod_Men}} imprimir"
                                                   @if($opcion->Imp_Opc === 1) checked @endif
                                                   @if($opcion->Todos===0) disabled @endif>
                                            <input type="hidden" name="imprimir[]" class="i-{{$opcion->Cod_Men}}"
                                                   value="@if($opcion->Imp_Opc===1) 1 @else 0 @endif">
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($menus as $m=> $menu)
                                    <tr>
                                        <td class="text-center">{{$menu->Cod_Men}}</td>
                                        <td>{{$menu->Nom_Men}}</td>
                                        <td class="text-center">
                                            <input id="{{$menu->Cod_Men}}" type="checkbox"
                                                   class="check">
                                            <input type="hidden" name="sel[]"
                                                   value="0">
                                            <input type="hidden" name="opcion[]" value="{{$menu->Cod_Men}}">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="" value=""
                                                   class="op-{{$menu->Cod_Men}} nuevo">
                                            <input type="hidden" name="nuevo[]" class="n-{{$menu->Cod_Men}}"
                                                   value="0">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="" value=""
                                                   class="op-{{$menu->Cod_Men}} editar">

                                            <input type="hidden" name="editar[]" class="e-{{$menu->Cod_Men}}"
                                                   value="0">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="" value=""
                                                   class="op-{{$menu->Cod_Men}} borrar">
                                            <input type="hidden" name="borrar[]" class="b-{{$menu->Cod_Men}}"
                                                   value="0">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="" value=""
                                                   class="op-{{$menu->Cod_Men}} imprimir">
                                            <input type="hidden" name="imprimir[]" class="i-{{$menu->Cod_Men}}"
                                                   value="0">
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary" title="Grabar"><span
                                    class="glyphicon glyphicon-floppy-saved"></span> Grabar
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-success" data-toggle="tooltip"
                           data-placement="top" title="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>
                            Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close()  !!}
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
            var tabla = $('.tabla').DataTable({
                "pageLength": 25,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "No results matched": "No se encontraron resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });
            $('.check').change(function () {
                var id = $(this).attr('id');
                var check = $(this).prop('checked');
                var opciones = $('.op-' + id);
                if (check) {
                    opciones.prop('disabled', false);
                    opciones.prop('checked', true);
                    $(this).next().val('1');
                    $('.n-' + id).val('1');
                    $('.e-' + id).val('1');
                    $('.b-' + id).val('1');
                    $('.i-' + id).val('1');
//$(this).parent().append('<input type="hidden" name="sel[]" value="0">')
                } else {
                    opciones.prop('checked', false);
                    opciones.prop('disabled', true);
                    $(this).next().val('0');
                    $('.n-' + id).val('0');
                    $('.e-' + id).val('0');
                    $('.b-' + id).val('0');
                    $('.i-' + id).val('0');
                }
            });
            $('.nuevo').change(function () {
                var check = $(this).prop('checked');
                if (check) {
                    $(this).next().val('1')
                } else {
                    $(this).next().val('0')
                }
            });
            $('.editar').change(function () {
                var check = $(this).prop('checked');
                if (check) {
                    $(this).next().val('1')
                } else {
                    $(this).next().val('0')
                }
            });
            $('.borrar').change(function () {
                var check = $(this).prop('checked');
                if (check) {
                    $(this).next().val('1')
                } else {
                    $(this).next().val('0')
                }
            });
            $('.imprimir').change(function () {
                var check = $(this).prop('checked');
                if (check) {
                    $(this).next().val('1')
                } else {
                    $(this).next().val('0')
                }
            });
        });

    </script>
@endsection