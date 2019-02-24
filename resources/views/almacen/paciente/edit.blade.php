@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[3]->Mod_Opc === 1)
        <form action="{{ url('almacen/paciente/edit/') }}" method="POST" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Actualización del Paciente</b><span id="estado"
                                                                                                       class="pull-right"></span>
                    </h3>
                </div>
                <div class="panel-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="CodPac">Código</label>
                                        <input type='number' name="CodPac" class="form-control " id="CodPac"
                                               value="{{ $pac->Cod_Pac }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="MailPac">Tipo Documento</label>
                                        <select name="CodDoc" id="tipoDocumento" class="form-control">
                                            @foreach($tiposdoc as $tip)
                                                <option @if($tip->Cod_Tip_Doc === $pac->Cod_Doc) selected
                                                        @endif value="{{$tip->Cod_Tip_Doc}}">{{$tip->Nom_Tip_Doc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodPac">N° Documento</label>
                                        <div class="input-group">
                                            <input id="dni_ruc" type="text" name="NumDoc" class="form-control"
                                                   placeholder="Número de documento" value="{{ $pac->Num_Doc }}"
                                                   required>
                                            <span class="input-group-btn">
                                    <button id="reniec" type="button" class="btn btn-primary"><i
                                                class="fa fa-search"></i>
                                    </button>
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fecEmi">F. Nacimiento</label>
                                        <div data-date-viewmode="years" data-date="" class="input-append date">
                                            <input name="fecha_nacimiento" id="fecha_nacimiento" type="text" readonly=""
                                                   value="{{date('d/m/Y', strtotime($pac->Fec_Nac_Pac))}}"
                                                   size="16"
                                                   class="form-control" data-fecha="{{$pac->Fec_Nac_Pac}}">
                                            <span class="input-group-btn add-on">
                                                <button class="btn btn-primary" type="button"><i
                                                            class="fa fa-calendar"></i></button>
                                              </span>
                                        </div>
                                        {{--<input name="fecha_nacimiento" id="fecha_nacimiento" type="date"
                                               required
                                               class="form-control" value="{{ $pac->Fec_Nac_Pac}}"
                                               placeholder="Sucursal">--}}

                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="edad">Edad</label>
                                        <input name="edad" id="edad" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="NomPac">Nombre</label>
                                        <input type='text' name="NomPac" class="form-control"
                                               placeholder="Nombre del paciente" id="NomPac"
                                               value="{{$pac->Nom_Pac}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="PatPac">Apellido Paterno</label>
                                        <input type='text' name="PatPac" class="form-control"
                                               placeholder="Apellidos del paciente" id="PatPac"
                                               value="{{$pac->Pat_Pac}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="MatPac">Apellido Materno</label>
                                        <input type='text' name="MatPac" class="form-control"
                                               placeholder="Apellidos del paciente" id="MatPac"
                                               value="{{$pac->Mat_Pac}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="control-label" for="radios"
                                                       style="text-align: center;">Sexo</label>
                                            </div>
                                            <div class="col-md-12"
                                                 style="border-style: double;height: 33px;border-width: 1px; border-color: #d2d6de;">
                                                @if($pac->Sexo_Pac === 'M')
                                                    <label class="col-md-5 radio-inline" for="radios-0"
                                                           style="padding-top : 5px;">
                                                        <input type="radio" name="radios" id="radios-0" value="M"
                                                               checked="checked">
                                                        Masculino
                                                    </label>
                                                    <label class="col-md-6 radio-inline" for="radios-1"
                                                           style="padding-top : 5px;">
                                                        <input type="radio" name="radios" id="radios-1" value="F">
                                                        Femenino
                                                    </label>
                                                @else
                                                    <label class="col-md-5 radio-inline" for="radios-0"
                                                           style="padding-top : 5px;">
                                                        <input type="radio" name="radios" id="radios-0" value="M">
                                                        Masculino
                                                    </label>
                                                    <label class="col-md-6 radio-inline" for="radios-1"
                                                           style="padding-top : 5px;">
                                                        <input type="radio" name="radios" id="radios-1" value="F"
                                                               checked="checked">
                                                        Femenino
                                                    </label>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="DirPac">Dirección</label>
                                        <input type='text' name="DirPac" class="form-control"
                                               placeholder="Ingrese su dirección" id="DirPac"
                                               value="{{$pac->Dir_Pac}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodPais">País</label>
                                        <select name="CodPais" id="pais" class="form-control">
                                            @foreach($paises as $pais)
                                                <option @if($pais->Cod_Pais === $pac->Cod_Pais) selected
                                                        @endif value="{{$pais->Cod_Pais}}">{{$pais->Nom_Pais}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodDep">Departamento</label>
                                        <select name="CodDep" id="departamento" class="form-control">
                                            @foreach($departamento as $dep)
                                                <option @if($dep->Cod_Dep === $pac->Cod_Dep) selected
                                                        @endif value="{{$dep->Cod_Dep}}">{{$dep->Nom_Dep}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodPro">Provincia</label>
                                        <select name="CodPro" id="provincia" class="form-control">
                                            @foreach($provincia as $pro)
                                                <option @if($pro->Cod_Pro === $pac->Cod_Pro) selected
                                                        @endif value="{{$pro->Cod_Pro}}">{{$pro->Nom_Pro}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodDis">Distrito</label>
                                        <select name="CodDis" id="distrito" class="form-control">
                                            @foreach($distrito as $dist)
                                                <option @if($dist->Cod_Dis === $pac->Cod_Dis) selected
                                                        @endif value="{{$dist->Cod_Dis}}">{{$dist->Nom_Dis}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="TelPac">Telefono</label>
                                        <input type='text' name="TelPac" class="form-control"
                                               placeholder="Ingrese su teléfono" id="TelPac"
                                               value="{{$pac->Tel_Pac}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CelPac">Celular</label>
                                        <input type='text' name="CelPac" class="form-control"
                                               placeholder="Ingrese su celular" id="CelPac"
                                               value="{{$pac->Cel_Pac}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="MailPac">Correo Electrónico</label>
                                        <input type='text' name="MailPac" class="form-control"
                                               placeholder="Ingrese su correo electrónico" id="MailPac"
                                               value="{{$pac->Mail_Pac}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: #1fb5ad;">
                                    <h3 class="panel-title" style="color: #fff">Fotografía</h3>
                                </div>
                                <div class="panel-body" style="height: 190px;">
                                    <img id="imagen" class="img-fluid img-thumbnail img-responsive"
                                         src="{{asset($pac->Ruta_Foto)}}"/>
                                </div>
                                <div class="panel-footer">
                                    <input type="file" name="FotoPac" id="fileToUpload" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" id="Insert" class="btn btn-primary Insertar" title="Grabar"><span
                                class="glyphicon glyphicon-floppy-saved"></span> Actualizar
                    </button>
                    <a href="{{ url('almacen/paciente') }}" class="btn btn-success" data-toggle="tooltip"
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
            $("#fecha_nacimiento").change(function () {
                var fecha = $(this).val();
                var hoy = new Date();
                var cumpleanos = new Date(fecha.split("/").reverse().join("-"));
                var edad = hoy.getFullYear() - cumpleanos.getFullYear();
                var m = hoy.getMonth() - cumpleanos.getMonth();
                if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                    edad--;
                }
                $("#edad").val(edad);
            })
                .datepicker({
                    format: 'dd/mm/yyyy',
                    autoclose: true
                });
            load_data();

            cargarImagen();
            calcularEdad();

            function calcularEdad() {
                var fecha = $('#fecha_nacimiento').attr('data-fecha');
                var hoy = new Date();
                //date('d/m/Y', strtotime($pac->Fec_Nac_Pac))
                var cumpleanos = new Date(fecha);
                var edad = hoy.getFullYear() - cumpleanos.getFullYear();
                var m = hoy.getMonth() - cumpleanos.getMonth();
                if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                    edad--;
                }
                $("#edad").val(edad);
            }

            $("#departamento").on('change', function () {
                cargarProvincia($('#pais').val(), $(this).val());
                $("#distrito").html('');
            });
            $("#provincia").on('change', function () {
                cargarDistrito($("#departamento").val(), $(this).val());
            });

            function load_data() {
                $("#reniec").click(function () {
                    $("#NomPac").val('');
                    $("#ApePac").val('');
                    $("#DirPac").val('');
                    var tipo_doc = "";
                    var tipo = $("#tipoDocumento").val();
                    var numero = $("#dni_ruc").val();
                    if (tipo !== '' && numero !== '') {
                        tipo_doc = "OTRO";
                        if (tipo === "01") {
                            tipo_doc = "DNI";
                        }
                        if (tipo === "06") {
                            tipo_doc = "RUC";
                        }
                        $("#CodDoc").val(tipo_doc);

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
                                    console.log(response);
                                    if (response['success']) {
                                        $.each(response, function (index, value) {
                                            if (tipo === "01") {
                                                $("#NomPac").val(value['nombre']);
                                                $("#PatPac").val(value['paterno']);
                                                $("#MatPac").val(value['materno']);
                                                $("#DirPac").val(value['direccion']);
                                                $('#estado').html('');
                                            } else {
                                                $("#NomPac").val(value['razon_social']);
                                                $("#DirPac").val(value['direccion']);
                                                $("#PatPac").val('');
                                                $("#MatPac").val('');
                                                if (value['estado'] === 'ACTIVO') {
                                                    $('#estado').html('<span class="label label-success">' + value['estado'] + '</span>');
                                                } else {
                                                    $('#estado').html('<span class="label label-danger">' + value['estado'] + '</span>');
                                                }

                                            }
                                        });
                                        if (response['item']['departamento']) {
                                            departamento(response['item']['departamento'], response['item']['provincia'], response['item']['distrito']);
                                        }
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
                        var select = "selected";
                        var select2 = "";
                        provincia = "<option>Seleccione</option>";
                        $.each(response, function (index, value) {
                            if (response[index]['Cod_Pro'] == $("input[name=provinciaaux]").val()) {
                                provincia = provincia + '<option selected value="' + response[index]['Cod_Pro'] + '">' + response[index]['Nom_Pro'] + '</option>';
                            }
                            else {
                                provincia = provincia + '<option value="' + response[index]['Cod_Pro'] + '">' + response[index]['Nom_Pro'] + '</option>';
                            }

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
                        var select = "selected";
                        var select2 = "";
                        distrito = "<option>Seleccione</option>";
                        $.each(response, function (index, value) {
                            if (response[index]['Cod_Dis'] == $("input[name=distritoaux]").val()) {
                                distrito = distrito + '<option selected value="' + response[index]['Cod_Dis'] + '">' + response[index]['Nom_Dis'] + '</option>';
                            }
                            else {
                                distrito = distrito + '<option value="' + response[index]['Cod_Dis'] + '">' + response[index]['Nom_Dis'] + '</option>';
                            }

                        });
                        $("#distrito").html(distrito);
                    },
                    complete: function (data) {
                        // $("#reniec").html('<i class="fa fa-search"></i>');
                    }
                });
            }

            function cargarImagen() {
                $("#fileToUpload").change(function () {
                    readurl(this);
                });

                function readurl(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("#imagen").attr("src", e.target.result);
                        };
                        reader.readAsDataURL(input.files[0])
                    }
                }
            }


        });
    </script>
@endsection