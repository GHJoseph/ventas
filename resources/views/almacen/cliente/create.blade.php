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
    @if($usuario_opciones[2]->Ing_Opc === 1)
        <form action="{{ url('almacen/cliente/create/') }}" method="POST">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Nuevo Cliente</b></h3>
                </div>
                <div class="panel-body">
                    <div class="col-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodTipDoc">Tipo de documento</label>
                                <select name="TipDoc" id="tipoDocumento" class="form-control">
                                    @foreach($tipo_documentos as $tipo_documento)
                                        <option @if($tipo_documento->Cod_Tip_Doc === '06') selected
                                                @endif value="{{$tipo_documento->Cod_Tip_Doc}}">{{$tipo_documento->Nom_Tip_Doc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--<div class="col-md-2">
                            <div class="form-group">
                                <label for="CodCP">Código</label>
                                <input type='number' name="CodCP" class="form-control " id="CodCP" disabled/>
                            </div>
                        </div>--}}
                        <div class="col-md-2">
                            <label for="NumDoc">Número de Documento</label>
                            <div class="input-group">
                                <input id="dni_ruc" type="text" name="NumDoc" class="form-control"
                                       placeholder="Número de documento" value="{{ old('NumDoc') }}" required
                                       autofocus="true">
                                <span class="input-group-btn">
                                    <button id="reniec" type="button" class="btn btn-primary"><i
                                                class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            {{--<div class="form-group">
                                <label for="NumDoc">DNI/RUC</label>
                                <input type='number' name="NumDoc" class="form-control " id="NumDoc"
                                       placeholder="DNI/RUC"/>
                            </div>--}}
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="NomCP">Nombre/Razón Social</label>
                                <input type='text' name="NomCP" class="form-control" placeholder="Nombre del paciente"
                                       id="NomCP" value="{{ old('NomCP') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ApeCP">Apellidos</label>
                                <input type='text' name="ApeCP" class="form-control"
                                       placeholder="Apellidos del paciente" id="ApeCP" value="{{ old('ApeCP') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="TelCP">Telefono</label>
                                <input type='text' class="form-control"
                                       placeholder="Ingrese su teléfono" name="TelCP" id="TelCP"
                                       value="{{ old('TelCP') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="CelCP">Celular</label>
                                <input type='text' name="CelCP" class="form-control" placeholder="Ingrese su celular"
                                       id="CelCP" value="{{ old('CelCP') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="MailCP">Correo</label>
                                <input type='email' name="MailCP" class="form-control " placeholder="Ingrese su correo"
                                       id="MailCP" value="{{ old('MailCP') }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="DirCP">Dirección</label>
                                <input type='text' name="DirCP" class="form-control " placeholder="Ingrese su dirección"
                                       id="DirCP" value="{{ old('DirCP') }}">
                            </div>
                        </div>

                    </div>

                    <div class="col-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodPais">País</label>
                                <select name="CodPais" id="pais" class="form-control">
                                    @foreach($pais as $pais)
                                        <option value="{{$pais->Cod_Pais}}">{{$pais->Nom_Pais}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodDep">Departamento</label>
                                <select name="CodDep" id="departamento" class="form-control">
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
                                    {{--@foreach($provincia as $pro)
                                        <option value="{{$pro->Cod_Pro}}">{{$pro->Nom_Pro}}</option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="CodDis">Distrito</label>
                                <select name="CodDis" id="distrito" class="form-control">
                                    {{--@foreach($distrito as $dist)
                                        <option value="{{$dist->Cod_Dis}}">{{$dist->Nom_Dis}}</option>
                                    @endforeach--}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cliente">Paciente</label>
                                <select name="CodPac" id="selectpaciente" name="selectpaciente"
                                        class="form-control paciente"
                                        value="{{ old('selectpaciente') }}"></select><span
                                        style="color:red"> {{$errors->first('selectpaciente')}} </span>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="MailCP">Nombre de Contacto</label>
                                <input type='text' name="NomCnt" class="form-control "
                                       placeholder="Ingrese el nombre de contacto"
                                       id="NomCnt" value="{{ old('NomCnt') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="MailCP">Teléfono de Contacto</label>
                                <input type='text' name="TelCnt" class="form-control " placeholder="Ingrese el teléfono"
                                       id="TelCnt" value="{{ old('TelCnt') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="MailCP">Cargo de Contacto</label>
                                <input type='text' name="CrgCnt" class="form-control " placeholder="Ingrese el cargo"
                                       id="CrgCnt" value="{{ old('CrgCnt') }}">
                            </div>
                        </div>

                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                </div>
                <div class="panel-footer">
                    <button type="submit" id="Insert" class="btn btn-primary Insertar" title="Grabar"><span
                                class="glyphicon glyphicon-floppy-saved"></span> Registro
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

        load_data();
        $("#departamento").on('change', function () {
            cargarProvincia($('#pais').val(), $(this).val());
            $("#distrito").html('');
        }).val(-1);
        $("#provincia").on('change', function () {
            cargarDistrito($('#pais').val(), $("#departamento").val(), $(this).val());
        });

        function load_data() {
            $("#reniec").click(function () {
                $("#NomCP").val('');
                $("#ApeCP").val('');
                $("#DirCP").val('');
                var tipo_doc = "";
                var tipo = $("#tipoDocumento").val();
                var numero = $("#dni_ruc").val();
                $("#NomCP").val('');
                $("#direccion").val('');
                if (tipo !== '' && numero !== '') {
                    if (tipo === "01") {
                        tipo_doc = "DNI";
                    } else {
                        if (tipo === "06") {
                            tipo_doc = "RUC";
                        }
                        else {
                            tipo_doc = "OTRO";
                        }
                    }
                    if (tipo_doc !== "OTRO") {
                        $.ajax({
                            "async": true,
                            "crossDomain": true,
                            "url": "http://servicio.fitcoders.com/v1/all",
                            "method": "POST",
                            "headers": {
                                "Content-Type": "application/json",
                            },
                            "processData": false,
                            "data": '{"id": "' + numero + '","key": "5b54cd7434a49a0fd4cd5ed2","service": "' + tipo_doc + '"}',
                            beforeSend: function () {
                                $("#reniec").html('<i class="fa fa-spinner fa-spin"></i>');
                            },
                            success: function (response) {
                                if (response['success']) {
                                    $.each(response, function (index, value) {
                                        if (tipo === "01") {
                                            $("#NomCP").val(value['nombre']);
                                            $("#ApeCP").val(value['paterno'] + ' ' + value['materno']);
                                            $("#DirCP").val(value['direccion']);
                                        } else {
                                            $("#NomCP").val(value['razon_social']);
                                            $("#DirCP").val(value['direccion']);
                                        }

                                    });
                                    departamento(response['item']['departamento'], response['item']['provincia'], response['item']['distrito']);
                                } else {
                                    $("#dni_ruc").val('');
                                    alert(response['message']);
                                    /*new PNotify({
                                        title: 'Información',
                                        text: response['message'],
                                        type: 'info',
                                        hide: true,
                                        styling: 'bootstrap3'
                                    });*/
                                }
                            },
                            complete: function (data) {
                                $("#reniec").html('<i class="fa fa-search"></i>');
                            },
                            error: function (response) {
                                alert('Hubo un error con el servidor, recargue la pestaña por favor.');
                            }
                        });
                    } else {
                        alert("Búsqueda habilitada sólo con DNI y/o RUC.")
                    }

                } else {
                    alert('Hubo un error, intentelo nuevamente');
                    /*new PNotify({
                        title: 'Información',
                        text: 'Seleccione el tipo de documento e ingrese el número',
                        type: 'error',
                        hide: true,
                        styling: 'bootstrap3'
                    });*/
                }

            });
        }

        function departamento(dep, pro, dis) {
            if (dep !== "") {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('departamento')}}',
                    dataType: 'JSON',
                    "data": {
                        'dep': dep
                    },
                    beforeSend: function () {
                        //$("#reniec").html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function (response) {
                        //provincia(response[0]['Cod_Dep']);
                        $("#departamento").val(response[0]['Cod_Dep']);
                        cargarProvincia($('#pais').val(), response[0]['Cod_Dep']);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST',
                            url: '{{route('provincia.buscar')}}',
                            dataType: 'JSON',
                            "data": {
                                'pro': pro
                            },
                            beforeSend: function () {
                                //$("#reniec").html('<i class="fa fa-spinner fa-spin"></i>');
                            },
                            success: function (response) {
                                $("#provincia").val(response[0]['Cod_Pro']);
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('distrito.buscar')}}',
                                    dataType: 'JSON',
                                    "data": {
                                        'dis': dis
                                    },
                                    beforeSend: function () {
                                        //$("#reniec").html('<i class="fa fa-spinner fa-spin"></i>');
                                    },
                                    success: function (response) {
                                        cargarDistrito($('#pais').val(), response[0]['Cod_Dep'], response[0]['Cod_Pro']);
                                        $("#distrito").val(response[0]['Cod_Dis']);
                                    },
                                    complete: function (data) {
                                        // $("#reniec").html('<i class="fa fa-search"></i>');
                                    }
                                });
                            },
                            complete: function (data) {
                                // $("#reniec").html('<i class="fa fa-search"></i>');
                            }
                        });
                    },
                    complete: function (data) {
                        // $("#reniec").html('<i class="fa fa-search"></i>');
                    }
                });
            }

        }

        function cargarProvincia(cod_pais, cod_dep) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                async: false,
                type: 'POST',
                url: '{{route('provincia')}}',
                dataType: 'JSON',
                "data": {
                    'cod_pais': cod_pais,
                    'cod_dep': cod_dep
                },
                beforeSend: function () {
                    //$("#reniec").html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    provincia = "<option>Seleccione</option>";
                    $.each(response, function (index, value) {
                        provincia = provincia + '<option value="' + response[index]['Cod_Pro'] + '">' + response[index]['Nom_Pro'] + '</option>';
                    });
                    $("#provincia").html(provincia);
                },
                complete: function (data) {
                    // $("#reniec").html('<i class="fa fa-search"></i>');
                }
            });
        }

        function cargarDistrito(cod_pais, cod_dep, cod_pro) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                async: false,
                type: 'POST',
                url: '{{route('distrito')}}',
                dataType: 'JSON',
                "data": {
                    'cod_pais': cod_pais,
                    'cod_dep': cod_dep,
                    'cod_pro': cod_pro
                },
                beforeSend: function () {
                    //$("#reniec").html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    distrito = "<option>Seleccione</option>";
                    $.each(response, function (index, value) {
                        distrito = distrito + '<option value="' + response[index]['Cod_Dis'] + '">' + response[index]['Nom_Dis'] + '</option>';
                    });
                    $("#distrito").html(distrito);
                },
                complete: function (data) {
                    // $("#reniec").html('<i class="fa fa-search"></i>');
                }
            });
        }
    </script>
@endsection