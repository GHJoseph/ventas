@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[5]->Ing_Opc === 1)
    <form action="{{ url('almacen/personal/create/') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #1fb5ad;">
                <h3 class="panel-title" style="color:#fff;"><b>Registro de Nuevo Personal</b><span id="estado"
                                                                                              class="pull-right"></span>
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Datos Personales</b></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    {{--<div class="col-md-2">
                                <div class="form-group">
                                    <label for="CodPer">Código</label>
                                    <input type='text' name="CodPer" class="form-control" id="CodPer" disabled>
                                </div>
                            </div>--}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="hidden" id="TipDoc" name="TipDoc">
                                            <label for="CodDoc">Documento</label>
                                            <select name="CodDoc" id="tipoDocumento" class="form-control"
                                                    value="{{ old('CodDoc') }}">
                                                @foreach($documento as $doc)
                                                    <option value="{{$doc->Cod_Tip_Doc}}">{{$doc->Nom_Tip_Doc}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="CodPac">N° Documento</label>
                                            <div class="input-group">
                                                <input id="dni_ruc" type="text" name="NumDoc" class="form-control input-number"
                                                       placeholder="Número de documento" required  oninvalid="this.setCustomValidity('Introduzca el número de documento')" oninput="setCustomValidity('')" pattern="[0-9]{8,11}" title="solo se acepta números" autofocus="true"
                                                       value="{{ old('NumDoc') }}">
                                                <span class="input-group-btn">
                                    <button id="reniec" type="button" class="btn btn-primary"><i
                                                class="fa fa-search"></i>
                                    </button>
                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="NomPer">Nombres</label>
                                            <input type='text' name="NomPer" class="form-control input-text" id="NomPer" value="{{ old('NomPer') }}"  required oninvalid="this.setCustomValidity('Introduzca el nombre')" oninput="setCustomValidity('')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="PatPer">Apellido Paterno</label>
                                            <input type='text' name="PatPer" class="form-control input-text" id="PatPer"
                                                   value="{{ old('PatPer') }}" required oninvalid="this.setCustomValidity('Introduzca el apellido paterno')" oninput="setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="MatPer">Apellido Materno</label>
                                            <input type='text' name="MatPer" class="form-control input-text" id="MatPer"
                                                   value="{{ old('MatPer') }}" required oninvalid="this.setCustomValidity('Introduzca el materno')" oninput="setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="CodEstCiv">Estado Civil</label>
                                            <select name="CodEstCiv" id="CodEstCiv" class="form-control" required>
                                                @foreach($estCivil as $estCivil)
                                                    <option value="{{$estCivil->Cod_Est_Civ}}">{{$estCivil->Nom_Est_Civ}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="FecNacPer">F. de Nacimiento</label>
                                            <input type='date' name="FecNacPer" class="form-control" id="FecNacPer" value="{{ old('FecNacPer') }}" required  oninvalid="this.setCustomValidity('Introduzca la fecha de nacimiento')" oninput="setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="edad">Edad</label>
                                            <input type='text' value="" name="edad" class="form-control"
                                                   id="edad" value="{{ old('edad') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="DirPer">Dirección</label>
                                            <input type='text' name="DirPer" class="form-control" id="DirPer"
                                                   value="{{ old('DirPer') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-md-12"></div>
                                            <label class="col-md-9 control-label" for="radios"
                                                   style="text-align: center;">Sexo</label>
                                            <div class="col-md-12 text-center"
                                                 style="border-style: double;height: 33px;border-width: 1px; border-color: #d2d6de;">
                                                <label class="radio-inline" for="radios-0"
                                                       style="padding-top : 5px;">
                                                    <input type="radio" name="radios" id="radios-0" value="M"
                                                           checked="checked">
                                                    Masculino
                                                </label>
                                                <label class="radio-inline" for="radios-1"
                                                       style="padding-top : 5px;">
                                                    <input type="radio" name="radios" id="radios-1" value="F">
                                                    Femenino
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Foto</b></h3>
                            </div>
                            <div class="panel-body" style="height: 270px">
                                <img id="imagen" class="img-fluid img-thumbnail" src=""  style="max-height: 256px;"/>
                            </div>
                            <div class="panel-footer">
                                <input type="file" name="FotoPer" id="fileToUpload" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Datos Adicionales</b></h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="RucPer">N. de Ruc</label>
                                            <input type='text' name="RucPer" class="form-control" id="ndoc"
                                                   value="{{ old('RucPer') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="FecIng">Fecha de Ingreso</label>
                                            <input type='date' name="FecIng" class="form-control" id="fecIng"
                                                   value="{{ old('FecIng') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="CodTur">Turno</label>
                                            <select name="CodTur" id="documento" class="form-control">
                                                @foreach($turno as $turno)
                                                    <option value="{{$turno->Cod_Tur}}">{{$turno->Nom_Tur}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="CodCrg">Cargo</label>
                                            <select name="CodCrg" id="Cargo" class="form-control">
                                                @foreach($cargos as $cargo)
                                                    <option value="{{$cargo->Cod_Tip_Crg}}">{{$cargo->Nom_Tip_Crg}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="TelPer">Teléfono</label>
                                            <input type='text' name="TelPer" class="form-control"
                                                   value="{{ old('TelPer') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="CelPer">Celular</label>
                                            <input type='text' name="CelPer" class="form-control"
                                                   value="{{ old('CelPer') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="MailPer">Correo</label>
                                            <input type='text' name="MailPer" class="form-control"
                                                   value="{{ old('MailPer') }}">
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Remuneración</b></h3>
                            </div>
                        </div>
                        <div class="panel-body">
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Vacaciones</b></h3>
                            </div>
                        </div>
                        <div class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" id="Insert" name="Insert" class="btn btn-primary Insertar"
                        title="Grabar"><span
                            class="glyphicon glyphicon-floppy-saved"></span> Registrar
                </button>
                <a href="{{ url('almacen/personal') }}" class="btn btn-success" data-toggle="tooltip"
                   data-placement="top"
                   title="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span> Cancelar</a>
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
         $('.input-number').on('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
         $('.input-text').on('input', function () {
                this.value = this.value.replace(/[^a-zA-Z ]/g, '');
            });
        load_data();
        cargarImagen();
        $("#departamento").on('change', function () {
            cargarProvincia($('#pais').val(), $(this).val());
            $("#distrito").html('');
            console.log($(this).val());
        });
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

                    tipo_doc = "OTRO";

                    if (tipo === "01") {
                        tipo_doc = "DNI";
                    }
                    if (tipo === "06") {
                        tipo_doc = "RUC";
                    }


                    $("#TipDoc").val(tipo_doc);

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
                                    console.log(response)
                                    $.each(response, function (index, value) {
                                        if (tipo === "01") {
                                            $("#NomPer").val(value['nombre']);
                                            $("#PatPer").val(value['paterno']);
                                            $("#MatPer").val(value['materno']);
                                            $("#DirPer").val(value['direccion']);
                                            $('#estado').html('');
                                        } else {
                                            $("#NomPer").val(value['razon_social']);
                                            $("#DirPer").val(value['direccion']);
                                            $("#PatPac").val('');
                                            $("#MatPac").val('');
                                            if (value['estado'] === 'ACTIVO') {
                                                $('#estado').html('<span class="label label-success">' + value['estado'] + '</span>');
                                            } else {
                                                $('#estado').html('<span class="label label-danger">' + value['estado'] + '</span>');
                                            }
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

        $("#FecNacPer").change(function () {
            var fecha = $(this).val();
            var hoy = new Date();
            var cumpleanos = new Date(fecha);
            var edad = hoy.getFullYear() - cumpleanos.getFullYear();
            var m = hoy.getMonth() - cumpleanos.getMonth();
            if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                edad--;
            }
            $("#edad").val(edad);
        });

        function cargarImagen() {
            $("#fileToUpload").change(function () {
                readurl(this);
            });

            function readurl(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#imagen").attr("src", e.target.result);
                    }
                    reader.readAsDataURL(input.files[0])
                }
            }
        }
    </script>
@endsection
