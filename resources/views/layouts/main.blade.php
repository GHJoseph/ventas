<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('images/quiro.ico')}}">

    <title>QUIRO VIDA | Sistema</title>

    <!--Core CSS -->
    <link href="{{asset('bs3/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-reset.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet"/>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="{{asset('js/ie8-responsive-file-warning.js')}}"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet"/>
    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.contextMenu.min.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datepicker/css/datepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-timepicker/css/timepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-colorpicker/css/colorpicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-daterangepicker/daterangepicker-bs3.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('js/bootstrap-datetimepicker/css/datetimepicker.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('js/jquery-multi-select/css/multi-select.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('js/jquery-tags-input/jquery.tagsinput.css')}}"/>

    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
    <link href="{{asset('js/iCheck/skins/minimal/minimal.css')}}" rel="stylesheet">
    <link href="{{asset('js/iCheck/skins/flat/green.css')}}" rel="stylesheet">

    <style>
        .form-control[readonly], .form-control[disabled] {
            background-color: #FFF;
        }

        .panel-footer {
            background-color: #fff;
        }
    </style>
    @yield('stylesheets')
</head>

<body class="full-width">

<section id="container" class="hr-menu">
    <!--header start-->
    <header class="header fixed-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle hr-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="fa fa-bars"></span>
            </button>

            <!--logo start-->
            <!--logo start-->
            <div class="brand ">
                <a href="{{url('/almacen/home')}}" class="logo">
                    <img src="{{asset('images/logo-quirovida.png')}}" alt="">
                </a>
            </div>
            <!--logo end-->
            <!--logo end-->
            <div class="horizontal-menu navbar-collapse collapse ">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><i
                                    class="fa fa-table"></i> Maestros <b
                                    class=" fa fa-angle-down"></b></a>
                        <ul class="dropdown-menu">
                            @if($usuario_opciones[0]->Todos === 1)
                                <li><a href="{{ url('almacen/articulo') }}"><i class="fa fa-tag"></i> Artículos</a></li>
                            @endif
                            @if($usuario_opciones[1]->Todos === 1)
                                <li><a href="{{ url('almacen/servicio') }}"><i class="fa fa-user-md"></i> Servicios</a>
                                </li>
                            @endif
                            @if($usuario_opciones[2]->Todos === 1)
                                <li><a href="{{ url('almacen/cliente') }}"><i class="fa fa-male"></i> Clientes</a></li>
                            @endif
                            @if($usuario_opciones[3]->Todos === 1)
                                <li><a href="{{ url('almacen/paciente') }}"><i class="fa fa-medkit"></i> Pacientes</a>
                                </li>
                            @endif
                            @if($usuario_opciones[4]->Todos === 1)
                                <li><a href="{{ url('almacen/proveedor') }}"><i class="fa fa-male"></i> Proveedores</a>
                                </li>
                            @endif
                            @if($usuario_opciones[5]->Todos === 1)
                                <li><a href="{{ url('almacen/personal') }}"><i class="fa fa-user"></i> Personal</a></li>
                        </ul>
                    </li>

                    @endif
                    @if($usuario_opciones[6]->Todos === 1)
                        <li><a href="{{ url('almacen/agenda') }}"><i class="fa fa-calendar-o"></i> Agenda</a></li>
                    @endif
                    @if($usuario_opciones[7]->Todos === 1 || $usuario_opciones[8]->Todos === 1 || $usuario_opciones[9]->Todos === 1 )
                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><i
                                        class="fa fa-dollar"></i> Ventas <b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                @if($usuario_opciones[7]->Todos === 1)
                                    <li><a href="{{url('almacen/facturacion')}}">Facturación</a></li>
                                @endif
                                @if($usuario_opciones[8]->Todos === 1)
                                    <li><a href="{{ route('notas/index') }}">Notas</a></li>
                                @endif
                                @if($usuario_opciones[9]->Todos === 1)
                                    <li><a href="{{ route('reportes.index') }}">Reportes</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if($usuario_opciones[10]->Todos === 1)
                        <li class="dropdown">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><i
                                        class="fa fa-briefcase"></i> Utilitarios<b
                                        class=" fa fa-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                @if($usuario_opciones[11]->Todos === 1)
                                    <li><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                                @endif
                                @if($usuario_opciones[12]->Todos === 1)
                                    <li><a href="{{ route('roles.index') }}">Perfil de Usuarios</a></li>
                                @endif
                                @if($usuario_opciones[14]->Todos === 1)
                                    <li><a href="buttons.html">Empresa</a></li>
                                @endif
                                @if($usuario_opciones[13]->Todos === 1)
                                    <li><a href="{{route('tipos.index')}}">Tipos de Cambio</a></li>
                                @endif

                            </ul>
                        </li>
                    @endif
                </ul>

            </div>
            <div class="top-nav hr-top-nav">
                <ul class="nav pull-right top-menu">
                    <li>
                        <input type="text" class="form-control search" placeholder=" Buscar">
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        @php
                            $nomusu = $datusu->Nom_Per;
                            $apeusu = $datusu->Pat_Per .' '.$datusu->Mat_Per;
                        @endphp
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="{{asset($datusu->Ruta_Foto)}}" width="40px;">
                            <span class="username">{{ $nomusu.' '.$apeusu }}</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="#"><i class=" fa fa-suitcase"></i>Perfil</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Configuración</a></li>
                            <li><a href="#"><i class="fa fa-bell-o"></i> Notificaciones</a></li>
                            <li><a href="{{ route('logout') }}"><i class="fa fa-key"></i> Salir</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
            </div>

        </div>

    </header>
    <!--header end-->
    <!--sidebar start-->

    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper" style="padding-bottom: 20px;">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                       style="text-decoration: none;">&times;</a>
                    {{ Session::get('success') }}
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                       style="text-decoration: none;">&times;</a>
                    {{ Session::get('error') }}
                </div>
            @endif
            @yield('contenido')
        </section>
    </section>
    <!--main content end-->
    <!--footer start-->
    <!--<footer class="footer-section" style="position: fixed;">
        <div class="text-center">
            SUNAT T.C.C = {{$tipoCambio->Val_Cmp}} - T.C.V = <span id="tc">{{$tipoCambio->Val_Vta}}</span>
            <a href="#" class="go-top">
                <i class="fa fa-angle-up"></i>
            </a>
        </div>
    </footer>-->
    <!--footer end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('bs3/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/hover-dropdown.js')}}"></script>
<script src="{{asset('js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js')}}"></script>
<script src="{{asset('js/jquery.nicescroll.js')}}"></script>
<!--Easy Pie Chart-->
<script src="{{asset('js/easypiechart/jquery.easypiechart.js')}}"></script>
<!--Sparkline Chart-->
<script src="{{asset('js/sparkline/jquery.sparkline.js')}}"></script>
<!--common script init for all pages-->
<script src="{{asset('js/scripts.js')}}"></script>
<!-- Datatables -->
<script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>

<script type="text/javascript" src="{{asset('js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="{{asset('js/sweetalert2.all.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/iCheck/jquery.icheck.js')}}"></script>
<script type="text/javascript" src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
@yield('javascripts')
<script type="text/javascript">
    var table = $('.datatable').DataTable({

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
</script>

</body>
</html>