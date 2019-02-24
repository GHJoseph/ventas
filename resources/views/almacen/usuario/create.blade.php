@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[11]->Ing_Opc === 1)
        <form action="{{ route('usuarios.store') }}" method="POST">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Registro Usuarios</b></h3>
                </div>
                <div class="panel-body">
                    <div class="col-row">
                        {{--<div class="col-md-3">
                            <div class="form-group">
                                <label for="CodUsu">Código</label>
                                <input type='number' name="CodUsu" class="form-control " id="CodPac" disabled>
                            </div>
                        </div>--}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Seleccione al Personal</label>
                                <select name="SelectPer" id="SelectPer" class="form-control classPersonal">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="NomUsu">Nombre de Usuario</label>
                                <input type='text' name="NomUsu" class="form-control" placeholder="Nombre del paciente"
                                       id="NomUsu">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="KeyUsu">Contraseña</label>
                                <input type='password' name="KeyUsu" class="form-control" placeholder="Password"
                                       id="KeyUsu">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="KeyUsuConfirm">Confirme Contraseña</label>
                                <input type='password' name="KeyUsuConfirm" class="form-control"
                                       placeholder="Confirme Contraseña" id="KeyUsuConfirm">
                            </div>
                        </div>
                    </div>
                    <div class="col-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodTipUsu">Tipo de Usuario</label>
                                <select name="CodTipUsu" id="CodTipUsu" class="form-control">
                                    @foreach($tipo_usuarios as $usuarios)
                                        <option value="{{$usuarios->Cod_Tip_Usu}}">{{$usuarios->Nom_Tip_Usu}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodPais">Pais</label>
                                <select name="CodPais" id="CodPais" class="form-control">
                                    @foreach($pais as $paises)
                                        <option value="{{ $paises->Cod_Pais}}">{{$paises->Nom_Pais}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodDep">Departamento</label>
                                <select name="CodDep" id="CodDep" class="form-control">
                                    @foreach($depart as $departamento)
                                        <option @if($departamento->Cod_Dep === '15') selected
                                                @endif value="{{ $departamento->Cod_Dep}}">{{$departamento->Nom_Dep}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodLoc">Local</label>
                                <select name="CodLoc" id="CodLoc" class="form-control">
                                    @foreach($local as $locales)
                                        <option value="{{$locales->Cod_Loc}}">{{$locales->Nom_Loc}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <div class="panel-footer">
                    <button type="submit" id="Insert" class="btn btn-primary Insertar" title="Grabar"><span
                                class="glyphicon glyphicon-floppy-saved"></span> Registrar
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-success" data-toggle="tooltip"
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
            <!-- Me filtra los Clientes por combo -->
            var busquedaScript = {
                language: {
                    inputTooShort: function (args) {
                        return "Buscar Personal";
                    },
                    errorLoading: function () {
                        return "Error buscando Personal";
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
                placeholder: "Buscar Personal",
                ajax: {
                    url: "{{ route('BuscaPersonal') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            personal: params.term
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
            $(".classPersonal").select2(busquedaScript);

            function formatRepo(repo) {
                if (repo.loading) return repo.text;
                return repo.name;
            }

            function formatRepoSelection(repo) {
                return repo.name || repo.text;
            }
        });


    </script>
@endsection

