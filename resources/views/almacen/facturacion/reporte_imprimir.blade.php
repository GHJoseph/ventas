<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="{{asset('images/quiro.ico')}}">

    <title>QUIRO VIDA | Sistema</title>

    <!--Core CSS -->
    <link href="{{asset('bs3/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-reset.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.css')}}" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet"/>
</head>
<body class="full-width">
        <section class="wrapper">
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <div class="panel-body invoice">
                            <div class="invoice-header">
                                <div class="invoice-title col-md-3 col-xs-2">
                                    <img src="{{ asset('images/logo-quirovida.png') }}" alt="">
                                </div>
                                <div class="invoice-info col-md-9 col-xs-10">
                                    <div class="">
                                        <div class="col-md-8 col-sm-8 pull-right">
                                            <p class="pull-right">Cel: (804) 123-5432 <br>
                                                Email: info@almasaeedstudio.com</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 pull-right">
                                            <p class="pull-right">Calle. Las Águilas 263 <br>
                                                Lima - Perú</p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="row invoice-to">
                                <div class="col-md-8 col-sm-7 pull-left">
                                    <h4>Cliente:</h4>
                                    <h4><b>{{$persona->Nom_CP}}</b></h4>
                                    <p>
                                        <strong>R.U.C. :</strong> {{$persona->Num_Doc}}<br>
                                        <strong>Dirección:</strong> {{$persona->Dir_CP}}<br>
                                        <strong>Cel:</strong> {{$persona->Cel_CP}}<br>
                                        <strong>Correo:</strong> {{$persona->Mail_CP}}<br>
                                    </p>
                                </div>
                                <div class="col-md-4 col-sm-5 pull-right">
                                    <table class="table cuadro"
                                           style="background-color: #1fb5ad; border-radius: 10px; color: #fff">
                                        @if($resultR->Cod_Doc == '01')
                                            <tr>
                                                <td align="center" style="border: none;"><b> R.U.C.: 20504068146
                                                        <br>
                                                        FACTURA DE VENTA
                                                        <br> ELECTRÓNICA</b><br>
                                                    {{$resultR->Ser_Doc}} N°
                                                    {{$resultR->Num_Doc}}
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td align="center" style="border: none;"><b> R.U.C.: 20504068146
                                                        <br> BOLETA
                                                        DE VENTA
                                                        <br> ELECTRÓNICA</b><br>
                                                    {{$resultR->Ser_Doc}} N°
                                                    {{$resultR->Num_Doc}}
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 inv-label">Fecha de Emisión:</div>
                                        <div class="col-md-8 col-sm-8">{{date('d-m-Y', strtotime($resultR->Fec_Doc))}}</div>
                                    </div>
                                    {{--<br>
                                    <div class="row">
                                        <div class="col-md-12 inv-label">
                                            <h3>TOTAL DUE</h3>
                                        </div>
                                        <div class="col-md-12">
                                            <h1 class="amnt-value">$ 3120.00</h1>
                                        </div>
                                    </div>--}}


                                </div>
                            </div>
                            <table class="table table-invoice">
                                <thead>
                                <tr>
                                    <th class="text-center">N°</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Código</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Unidad</th>
                                    <th class="text-center">Precio de Venta</th>
                                    <th class="text-center">Precio Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($resultVD as $i => $detalle)
                                    <tr>
                                        <td class="text-center">{{$i+1}}</td>
                                        <td class="text-center">{{$detalle->Can_Art}}</td>
                                        <td class="text-center">{{$detalle->Cod_Art}}</td>
                                        <td>{{$detalle->Nom_Art}}</td>
                                        <td class="text-center">{{$detalle->Tip_Und}}</td>
                                        <td class="text-center">{{$detalle->Pre_Vnt_MN}} </td>
                                        <td class="text-center">{{$detalle->Vta_Art_MN}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-8 col-xs-7 payment-method">
                                    <h5 style="padding-left: 20px;">SON: {{$resultR->Tot_Vta_Letra}}</h5>
                                    {{-- <p>1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                     <p>2. Pellentesque tincidunt pulvinar magna quis rhoncus.</p>
                                     <p>3. Cras rhoncus risus vitae congue commodo.</p>
                                     <br>
                                     <h3 class="inv-label itatic">Thank you for your business</h3>--}}
                                </div>
                                <div class="col-md-4 col-xs-5 invoice-block pull-right">
                                    <ul class="unstyled amounts">
                                        @if($resultR->Cod_Doc == '01')
                                            <li>Valor de Venta : S/ {{$resultR->Val_Vta_MN}}</li>
                                            <li>IGV ({{$resultR->Tas_Imp}}%) : S/ {{$resultR->Igv_Vta_MN}}</li>
                                        @endif
                                        <li class="grand-total">Total : S/ {{$resultR->Tot_Vta_MN}}</li>
                                    </ul>
                                </div>
                                <div class="col-xs-12">
                                    <img class="center-block" src="{{ asset('images/CodeBar.jpg') }}" alt="Solvetic"
                                         style="width: 400px; height: 150px;">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
        </section>
</body>
</html>