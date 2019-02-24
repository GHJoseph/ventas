<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="QuiroVida">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Quirosys - QuiroVida Centro Quiropráctico</title>

    <!--Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
          integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- Custom styles for this template -->

    <link href="{{asset('login/css/main.css')}}" rel="stylesheet">

    <link href="{{asset('login/css/login.css')}}" rel="stylesheet">


    <script src="{{asset('js/jquery-3.1.1.min.js')}}" type="text/javascript"></script>
    <link href="{{asset('css/jquery.contextMenu.min.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/jquery.contextMenu.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.ui.position.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/bootbox.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.colorbox-min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/spin.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.spin.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.form.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/scripts.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/sweetalert2.all.min.js')}}" type="text/javascript"></script>


</head>

<body>

<div class="authentication">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-r-0">
                <div class="card position">

                    <div class="col-md-12 logo text-center">

                        <img src="{{asset('login/images/logo-qv.png')}}">

                    </div>

                    <!-- <h4 class="l-login">Iniciar sesión</h4> -->

                    <form class="col-md-12" id="sign_in">

                        <div class="form-group">
                            <!-- <label for="country">País</label> -->
                            <select class="custom-select d-block w-100" id="paises" name="paises" required>
                                @foreach($paises as $data)
                                    <option value="{{ $data->Cod_Pais}}">{{ $data->Nom_Pais}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione un país.
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- <label for="state">Departamento</label> -->

                            <select class="custom-select d-block w-100" id="departamentos" name="departamentos"
                                    required>

                                @foreach($departamentos as $data)
                                    <option @if($data->Cod_Dep === '15') selected
                                            @endif value="{{ $data->Cod_Dep}}">{{ $data->Nom_Dep}}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                                Por favor seleccione una sede.
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <!-- <label for="branch">Sede</label> -->
                            <select class="custom-select d-block w-100" id="locales" name="locales" required>
                                @foreach($locales as $data)
                                    <option @if($data->Cod_Loc === '01') selected
                                            @endif value="{{ $data->Cod_Loc}}">{{ $data->Nom_Loc}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione una sede.
                            </div>
                        </div>

                        <div class="form-group wrap-input100">
                            <input class="input100" type="text" name="username" id="username">
                            <span class="focus-input100" data-placeholder="Usuario"></span>
                        </div>

                        <div class="form-group wrap-input100">
                            <input class="input100" type="password" name="pass" id="pass">
                            <span class="focus-input100" data-placeholder="Contraseña"></span>
                        </div>

                        <div class="alert alert-danger">
                            <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
                        </div>
                        <button type="button" class="btn btn-info btn-lg btn_ingresar" id="ingresar" name="ingresar"><i
                                    class="fas fa-sign-in-alt btn_ingresar"></i> Ingresar
                        </button>

                    </form>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 p-l-0">

                <div class="l-detail">

                    <h5 class="position"><i class="fas fa-calendar-alt"></i> <?php
                        setlocale(LC_ALL,"es_ES");
                        echo strftime("%A %d de %B del %Y");
                        ?></h5>

                    <h1 class="position">Bienvenido</h1>
                    <h3 class="position">Ingreso al sistema QuiroSys</h3>
                    <p class="position">Recordamos a todos que el día de 25 de diciembre es feriado por navidad y año
                        nuevo también. Por favor verificar la agenda.</p>

                    <ul class="list-unstyled l-social position">
                        <li><a href="#"><i class="fab fa-facebook-square"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                    <!-- <ul class="list-unstyled l-menu">
                            <li><a href="#">Soporte</a></li>
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">

    $(document).ready(function () {
        $(document).on('click', '.btn_ingresar', function () {
            var data = {
                pais: $('#paises').val(),
                departamento: $('#departamentos').val(),
                local: $('#locales').val(),
                usuario: $('#username').val(),
                clave: $('#pass').val()
            };
            $.ajax({
                method: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ route('validador') }}",
                dataType: 'json',
                data: data,
            }).done(function (data) {
                console.log(data);
                if (data.estado == 1) {

                    // alert('Bienvenido');

                    window.location.href = 'http://localhost/SisVentas2/public/almacen/home';
                } else {

                }
            }).fail(function () {

            });

        });
        $('#departamentos').on('change', function () {
            console.log($(this).val());
            var data = {
                CodDep: $(this).val(),
            };
            console.log(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: '{{route('locales')}}',
                dataType: 'json',
                data: data,
            }).done(function (data) {
                var locales = "";
                $.each(data, function( index, value ) {
                    locales = locales + "<option value='"+value.Cod_Loc+"'>"+value.Nom_Loc+"</option>"
                });
                $('#locales').html(locales);
            }).fail(function () {
            });
        });
        $('.input100').on('change', function () {
            var i = $(this).val();
            if (i.length > 0) {
                $(this).addClass('has-val');
            }else{
                $(this).removeClass('has-val');
            }
        });
    });

</script>

