@extends('layouts.main')
@section('stylesheets')
    <style>
        .contacto {
            border: 1px rgb(210, 214, 222) solid;
            border-radius: 5px;
        }
    </style>
@endsection
@section('contenido')
    @if($usuario_opciones[2]->Mod_Opc === 1)
    <form action="{{ url('almacen/cliente/edit/') }}" method="POST">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #1fb5ad;">
                <h3 class="panel-title" style="color:#fff;"><b>Actualización del Cliente</b></h3>
            </div>
            <div class="panel-body">
                @foreach($clientes as $cliente)
                    <div class="col-row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="CodCP">Código</label>
                                <input type='text' value="{{ $cliente->Cod_CP }}" name="CodCP" class="form-control "
                                       id="CodCP" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodTipDoc">Tipo de documento</label>
                                <select name="TipDoc" id="tipoDocumento" class="form-control">
                                    @foreach($tipo_documentos as $tipo_documento)
                                        <option @if($tipo_documento->Cod_Tip_Doc === $cliente->Cod_Doc) selected
                                                @endif value="{{$tipo_documento->Cod_Tip_Doc}}">{{$tipo_documento->Nom_Tip_Doc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="TipCP">Número de documento</label>
                                <input type='text' value="{{ $cliente->Num_Doc }}" name="NumDoc" class="form-control "
                                       id="NumDoc" autofocus="true">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="NomCP">Nombre</label>
                                <input type='text' name="NomCP" value="{{ $cliente->Nom_CP }}" class="form-control"
                                       placeholder="Nombre del paciente" id="NomCP">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ApeCP">Apellidos</label>
                                <input type='text' name="ApeCP" value="{{ $cliente->Ape_CP }}" class="form-control"
                                       placeholder="Apellidos del paciente" id="ApeCP">
                            </div>
                        </div>
                        {{--<div class="col-md-2">
                            <div class="form-group">
                                <label for="TipCP">Tipo de Paciente</label>
                                <input type='text' value="{{ $cliente->Tip_CP }}" name="TipCP" class="form-control " id="TipCP">
                            </div>
                        </div>--}}
                    </div>

                    <div class="col-row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="TelCP">Telefono</label>
                                <input type='text' name="TelCP" value="{{ $cliente->Tel_CP }}" class="form-control"
                                       placeholder="Ingrese su teléfono" id="TelCP">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="CelCP">Celular</label>
                                <input type='text' name="CelCP" value="{{ $cliente->Cel_CP }}" class="form-control"
                                       placeholder="Ingrese su celular" id="CelCP">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="MailCP">Correo</label>
                                <input type='email' value="{{ $cliente->Mail_CP }}" name="MailCP" class="form-control "
                                       placeholder="Ingrese su correo" id="MailCP">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="DirCP">Dirección</label>
                                <input type='text' value="{{ $cliente->Dir_CP }}" name="DirCP" class="form-control "
                                       id="DirCP">
                            </div>
                        </div>

                    </div>

                    <div class="col-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodPais">País</label>
                                <select name="CodPais" id="pais" class="form-control">

                                    @foreach($paises as $pais)
                                        <option value="{{$pais->Cod_Pais}}">{{$pais->Nom_Pais}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodDep">Departamento</label>
                                <select name="CodDep" id="departamento" class="form-control">
                                    <option value="{{$cliente->Cod_Dep}}" selected>{{ $cliente->Nom_Dep}}</option>
                                    @foreach($departamento as $dep)
                                        <option value="{{$dep->Cod_Dep}}">{{$dep->Nom_Dep}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodPro">Provincia</label>
                                <select name="CodPro" id="provincia" class="form-control">
                                    <option value="{{$cliente->Cod_Pro}}" selected>{{ $cliente->Nom_Pro}}</option>
                                    @foreach($provincia as $pro)
                                        <option value="{{$pro->Cod_Pro}}">{{$pro->Nom_Pro}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodDis">Distrito</label>
                                <select name="CodDis" id="distrito" class="form-control">
                                    <option value="{{$cliente->Cod_Dis}}" selected>{{ $cliente->Nom_Dis}}</option>
                                    @foreach($distrito as $dist)
                                        <option value="{{$dist->Cod_Dis}}">{{$dist->Nom_Dis}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 contacto">
                        <div class="col-xs-12">
                            <label for="">CONTACTOS:</label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodPais">Paciente</label>
                                <select name="CodPac" id="paciente" class="form-control paciente">

                                    @foreach($paciente as $pacientes)
                                        <option @if($pacientes->Cod_Pac === $cliente->Cod_Pac) selected
                                                @endif value="{{$pacientes->Cod_Pac}}">{{$pacientes->Nom_Pac}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="MailCP">Nombre de Contacto</label>
                                <input type='text' name="NomCnt" class="form-control "
                                       placeholder="Ingrese el nombre de contacto"
                                       id="NomCnt" value="{{$cliente->Nom_Cnt}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="MailCP">Teléfono de Contacto</label>
                                <input type='text' name="TelCnt" class="form-control "
                                       placeholder="Ingrese el teléfono"
                                       id="TelCnt" value="{{$cliente->Tel_Cnt}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="MailCP">Cargo de Contacto</label>
                                <input type='text' name="CrgCnt" class="form-control "
                                       placeholder="Ingrese el cargo"
                                       id="CrgCnt" value="{{$cliente->Crg_Cnt}}">
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="CodCP" value="{{ $cliente->Cod_CP }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @endforeach
            </div>
            <div class="panel-footer">
                <button type="submit" id="Insert" class="btn btn-primary Insertar" title="Grabar"><span
                            class="glyphicon glyphicon-floppy-saved"></span> Actualizar
                </button>
                <a href="{{ url('almacen/cliente') }}" class="btn btn-success" data-toggle="tooltip"
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
        var busquedaScript = {
            language: {
                inputTooShort: function (args) {
                    return "Buscar Pacientes";
                },
                errorLoading: function () {
                    return "Error buscando Pacientes";
                },
                loadingMore: function () {
                    return "Buscando más resultados";
                },
                noResults: function () {
                    return "No se han encontrado resultados";
                },
                searching: function () {
                    return "Buscando...";
                }
            },
            placeholder: "Buscar Pacientes",
            ajax: {
                url: "{{ route('BuscaPacientes') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        paciente: params.term
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data.items
                    };
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 2,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        };
        $(".paciente").select2(busquedaScript);

        function formatRepo(repo) {
            if (repo.loading) return repo.text;
            return repo.name;
        }

        function formatRepoSelection(repo) {
            return repo.name || repo.text;
        }
    </script>
@endsection