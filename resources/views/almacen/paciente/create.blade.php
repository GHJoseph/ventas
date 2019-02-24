@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[3]->Ing_Opc === 1)
        <form action="{{ url('almacen/paciente/create/') }}" method="POST" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Nuevo Paciente</b><span id="estado"
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
                                               value="{{ old('CodPac') }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="TipDoc">Tipo Documento</label>
                                        <select name="tipdoc" id="tipdoc" class="form-control">
                                            @foreach($tiposdoc as $tip)
                                                <option value="{{$tip->Cod_Tip_Doc}}">{{$tip->Nom_Tip_Doc}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodPac">N° Documento</label>
                                        <div class="input-group">
                                            <input id="dni_ruc" type="text" name="NumDoc" class="form-control"
                                                   placeholder="Número de documento" value="{{ old('NumDoc')}}"
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
                                        <div data-date-viewmode="years" data-date-format="dd-mm-yyyy"
                                             data-date="" class="input-append date dpYears">
                                            <input name="fecha_nacimiento" id="fecha_nacimiento" type="text" readonly=""
                                                   value="" size="16"
                                                   class="form-control">
                                            <span class="input-group-btn add-on">
                                                <button class="btn btn-primary" type="button"><i
                                                            class="fa fa-calendar"></i></button>
                                              </span>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                         <label for="fecEmi">F. Nacimiento</label>
                                         <input name="fecha_nacimiento" id="fecha_nacimiento" type="date" required
                                                class="form-control" value="{{ old('fecha_nacimiento')}}">
                                     </div>--}}
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="edad">Edad</label>
                                        <input name="edad" id="edad" class="form-control" value="{{ old('edad')}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="NomPac">Nombre</label>
                                        <input type='text' name="NomPac" class="form-control"
                                               placeholder="Nombre del paciente" id="NomPac" value="{{ old('NomPac')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="PatPac">Apellido Paterno</label>
                                        <input type='text' name="PatPac" class="form-control"
                                               placeholder="Apellidos del paciente" id="PatPac"
                                               value="{{ old('PatPac')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="MatPac">Apellido Materno</label>
                                        <input type='text' name="MatPac" class="form-control"
                                               placeholder="Apellidos del paciente" id="MatPac"
                                               value="{{ old('MatPac')}}">
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
                                               value="{{ old('DirPac')}}">
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
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="TelPac">Telefono</label>
                                        <input type='text' name="TelPac" class="form-control"
                                               placeholder="Ingrese su teléfono" id="TelPac" value="{{ old('TelPac')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CelPac">Celular</label>
                                        <input type='text' name="CelPac" class="form-control"
                                               placeholder="Ingrese su celular" id="CelPac" value="{{ old('CelPac')}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="MailPac">Correo Electrónico</label>
                                        <input type='text' name="MailPac" class="form-control"
                                               placeholder="Ingrese su correo electrónico" id="MailPac"
                                               value="{{ old('MailPac')}}">
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
                                    <img id="imagen" class="img-fluid img-responsive img-thumbnail" src=""/>
                                </div>
                                <div class="panel-footer">
                                    <input type="file" name="FotoPac" id="fileToUpload" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                    {{--    <div class="row">
                            <div class="col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: #1fb5ad;">
                                        <h3 class="panel-title" style="color:#fff;"><b> TERAPIA </b></h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-2">
                                                    <label for="terapia">Terapia</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <select name="terapia" id="terapia" class="form-control">
                                                        <option>-- Seleccione un tipo de terapia --</option>
                                                        @foreach($servicios as $servicio)
                                                            <option value="{{$servicio->Cod_Serv}}">{{$servicio->Nom_Serv}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Tipo de Terapia</th>
                                                <th>Cantidad de Terapias</th>
                                                <th>Cantidad de Terapias Consumidas</th>
                                                <th>Monto</th>
                                                <th>
                                                    <a href="{{url('almacen/paciente/create')}}" class="btn btn-primary"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title=" Agregar Articulo"><span
                                                                class="glyphicon glyphicon-plus"></span>
                                                    </a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tfoot>

                                            </tfoot>
                                            <tbody>
                                            <tr>
                                                <td><input type="number" class="form-control" nombre="" id=""></td>
                                                <td><input type="number" class="form-control" nombre="" id=""></td>
                                                <td><input type="number" class="form-control" nombre="" id=""></td>
                                                <td><input type="number" class="form-control" nombre="" id=""></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                </div>

                <div class="panel-footer">
                    <button type="submit" id="Insert" class="btn btn-primary Insertar" title="Grabar"><span
                                class="glyphicon glyphicon-floppy-saved"></span> Registrar
                    </button>
                    <a href="{{ url('almacen/paciente') }}" class="btn btn-success" data-toggle="tooltip"
                       data-placement="top" title="Cancelar"><span
                                class="glyphicon glyphicon-floppy-remove"></span> Cancelar</a>
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
        load_data();
        cargarImagen();
        $("#departamento").on('change', function () {
            cargarProvincia($('#pais').val(), $(this).val());
            $("#distrito").html('');
        });
        $("#provincia").on('change', function () {
            cargarDistrito($('#pais').val(), $("#departamento").val(), $(this).val());
        });

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

        function load_data() {
            $("#reniec").click(function () {
                $("#NomCP").val('');
                $("#ApeCP").val('');
                $("#DirCP").val('');
                var tipo_doc = "";
                var tipo = $("#tipdoc").val();
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
    </script>
@endsection