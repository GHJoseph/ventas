<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('images/quiro.ico')}}">

    <title>QUIRO VIDA | Sistema</title>

    <link href="{{asset('bs3/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-reset.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.min.css') }} ">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Datatables -->
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.contextMenu.min.css')}}" rel="stylesheet"/>
    <style>
        .form-control[readonly], .form-control[disabled] {
            background-color: #FFF;
        }
    </style>
    @yield('stylesheets')
</head>
<body>
<nav class="navbar navbar-default" style="background-color: white;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-menu"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{url('/almacen/home')}}" class="navbar-brand">
                <img src="{{asset('images/logo-quirovida.png')}}" alt="Quirovida" height="25">
            </a>
        </div>
        <div class="collapse navbar-collapse full-width" id="top-menu">
            <ul class="nav navbar-nav">
                @if($usuario_opciones[0]->Todos === 1)
                    <li><a href="{{ url('almacen/articulo') }}"><i class="fa fa-tag"></i> Artículos</a></li>
                @endif
                @if($usuario_opciones[1]->Todos === 1)
                    <li><a href="{{ url('almacen/servicio') }}"><i class="fa fa-user-md"></i> Servicios</a></li>
                @endif
                @if($usuario_opciones[2]->Todos === 1)
                    <li><a href="{{ url('almacen/cliente') }}"><i class="fa fa-male"></i> Clientes</a></li>
                @endif
                @if($usuario_opciones[3]->Todos === 1)
                    <li><a href="{{ url('almacen/paciente') }}"><i class="fa fa-medkit"></i> Pacientes</a></li>
                @endif
                @if($usuario_opciones[4]->Todos === 1)
                    <li><a href="{{ url('almacen/proveedor') }}"><i class="fa fa-male"></i> Proveedores</a></li>
                @endif
                @if($usuario_opciones[5]->Todos === 1)
                    <li><a href="{{ url('almacen/personal') }}"><i class="fa fa-user"></i> Personal</a></li>
                @endif
                @if($usuario_opciones[6]->Todos === 1)
                    <li><a href="{{ url('almacen/agenda') }}"><i class="fa fa-calendar-check-o"></i> Agenda</a></li>
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
                                <li><a href="buttons.html">Tipos de Cambio</a></li>
                            @endif

                        </ul>
                    </li>
                @endif
                <li class="dropdown">
                    <ul class="dropdown-menu">
                        <li><a href="blank.html">Blank Page</a></li>
                        <li><a href="boxed_page.html">Boxed Page</a></li>
                        <li><a href="profile.html">Profile</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav pull-right top-menu">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="color: #777; margin-top: 4px;">
                        <img alt="" src="{{asset($datusu->Ruta_Foto)}}" class="img-rounded" width="30px;">
                        @php
                            $nomusu = $datusu->Nom_Per;
                            $apeusu = $datusu->Pat_Per .' '.$datusu->Mat_Per;
                        @endphp
                        <span class="username">{{ $nomusu.' '.$apeusu }}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="#"><i class=" fa fa-suitcase"></i> Profile</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                        <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                        <li><a href="{{ route('logout') }}"><i class="fa fa-key"></i> Salir</a></li>
                    </ul>
                </li>
            </ul>
            {{-- <ul class="nav navbar-nav navbar-right">
                 <li class="dropdown dropdown-menu-left">
                     <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                         @php
                             $nomusu = $datusu->Nom_Per;
                             $apeusu = $datusu->Pat_Per .' '.$datusu->Mat_Per;
                         @endphp

                         <span class="username">{{ $nomusu.' '.$apeusu }}</span>
                       --}}{{--  <span class="username">{{ $datusu->Nom_Usu }}</span>--}}{{--
                         <div class="col-md-2">
                             <img alt="" src="{{$datusu->Ruta_Foto}}" class="img-responsive img-rounded" style="width: 20px;">
                             <input id="txtidusu" name="txtidusu" type="text" placeholder=""
                                    class="form-control input-md" value="{{$datusu->Cod_Usu}}" style="display: none">
                         </div>
                         <b class="caret"></b>
                         <ul class="dropdown-menu extended">
                             <li><a href="#"><i class=" fa fa-suitcase"></i> Profile</a></li>
                             <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                             <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                             <li><a href="{{ route('index') }}"><i class="fa fa-key"></i> Salir</a></li>
                         </ul>
                     </a>
                 </li>
             </ul>--}}
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="col-xs-12">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"
                   style="text-decoration: none;">&times;</a>
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::has('danger'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"
                   style="text-decoration: none;">&times;</a>
                {{ Session::get('danger') }}
            </div>
        @endif
    </div>
    @yield('contenido')
</div>

<script src="{{asset('js/jquery-3.1.1.min.js')}}" type="text/javascript"></script>
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
<script src="{{asset('js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/scripts.js')}}" type="text/javascript"></script>
<script src="{{asset('js/sweetalert2.all.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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
