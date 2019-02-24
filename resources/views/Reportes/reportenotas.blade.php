<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quiro Vida | Centro Quiropractico</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->


    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.min.css') }} ">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body onload="window.print();">
<div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
        <style>
            .logo {
                width: 15%;
            }

            .cuadro > tbody > tr > td {
                border-top: 1px solid #000;
            }
        </style>
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-header">

                    <img class="logo" src="{{ asset('images/logo-quirovida.png') }}" alt="">
                    <small class="pull-right"> Fecha: {{date("Y-m-d")}}</small>
                </h1>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-5 invoice-col"> De
                <address>
                    <strong>Quirovida, Rehabilitación Integral S.A.C.</strong><br>
                    Calle. Las Águilas 263 <br>
                    Lima - Perú<br>
                    Cel: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col"> A
                <address>
                    <strong>{{$persona->Nom_CP}}</strong><br>
                    <strong>R.U.C. :</strong> {{$persona->Num_Doc}} <br>
                    <strong>Dirección:</strong> {{$persona->Dir_CP}}<br>
                    <strong>Cel:</strong> {{$persona->Cel_CP}}<br>
                    {{-- Moneda : {{$Moneda->Nom_Mon}}--}}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
                <table class="table cuadro" border="1" style="background-color: #f5f5f5;">
                    @if($nota->Cod_Doc == '07')
                        <tr>
                            <td align="center"><b> R.U.C.: 20504068146 <br> NOTA DE CRÉDITO
                                    <br> ELECTRÓNICA</b><br>
                                {{$nota->Ser_Doc}} N°
                                {{$nota->Num_Doc}}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td align="center"><b> R.U.C.: 20504068146 <br> NOTA DE DÉDITO
                                    <br> ELECTRÓNICA</b><br>
                                {{$nota->Ser_Doc}} N°
                                {{$nota->Num_Doc}}
                            </td>
                        </tr>
                    @endif
                </table>
                <br>
                <strong>FECHA DE EMISIÓN: </strong> {{$nota->Fec_Doc}}<br>
                <strong>DOCUMENTO QUE MODIFICA: </strong><br>
                {{$nota->Tip_Doc_Ref}}: {{$nota->Ser_Doc_Ref}}-{{$nota->Num_Doc_Ref}}
                <strong>&nbsp;&nbsp; Fecha: </strong> {{date('d-m-Y', strtotime($nota->Fec_Doc_Ref))}}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table">
                    <thead style="background-color:  #e3e3e3;">
                    <tr style="border-top: 1px solid #000">
                        <th style="width:7%">Nº</th>
                        <th style="width: 10%;text-align: center;">Cantidad</th>
                        <th style="width:10%">Código</th>
                        <th style="width:40%">Descripción</th>
                        <th style="width:7%">Unidad</th>
                        <th style="width:15%;text-align: right;">Valor Unitario</th>
                        <th style="width:15%;text-align: right;">Valor Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($nota->Cod_Doc == '07' && $nota->Cod_Tip_Dscto === '001')
                        @foreach($detalle as $i => $det)
                            <tr>
                                <td class="text-center">{{$i+1}}</td>
                                <td class="text-center">{{$det->Can_Art}}</td>
                                <td class="text-center">{{$det->Cod_Art}}</td>
                                <td>{{$det->Nom_Art}}</td>
                                <td class="text-center">{{$det->Tip_Und}}</td>
                                <td class="text-center">{{$det->Pre_Vnt_MN}} </td>
                                <td class="text-center">{{$det->Vta_Art_MN}}</td>
                            </tr>
                        @endforeach
                    @else
                        @php $i=0; @endphp
                        @php $i=$i+1; @endphp
                        <tr style="border-bottom: 1px solid #000;">
                            <td>{{$i}}</td>
                            <td align="center">{{$nota->Can_Nota}}</td>
                            <td>{{$nota->Cod_Tip_Dscto}}</td>
                            <td>{{$nota->Nom_Con}}</td>
                            <td>UND.</td>
                            <td align="right">{{$nota->Pre_Nota_MN}} </td>
                            <td align="right">{{$nota->Val_Nota_MN}}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <br>
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-7">
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> Representación Impresa de la
                    @if($nota->Cod_Doc == '07')
                        NOTA DE CRÉDITO ELECTRÓNICA
                    @else
                        NOTA DE DÉBITO ELECTRÓNICA
                    @endif
                    , consultar documentos visitando la gágina www.facttron.com/20123964579 Autorizado mediante
                    Resolución de Superintendencia N°155-2017/Sunat. </p>
            </div>
            <div class="col-xs-1"></div>

            <div class="col-xs-4">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Valor Venta :</th>
                            <td>S/</td>
                            <td align="right">
                                {{$nota->Val_Nota_MN}}
                            </td>
                        </tr>
                        <tr>
                            <th>Igv {{$nota->Tas_Imp}} %:</th>
                            <td>S/</td>
                            <td align="right">
                                {{$nota->Igv_Nota_MN}}
                            </td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>S/</td>
                            <td align="right">
                                {{$nota->Tot_Nota_MN}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <img class="center-block" src="{{ asset('images/CodeBar.jpg') }}" alt="Solvetic"
             style="width: 400px; height: 150px;">
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<!-- ./wrapper -->
</body>

</html>

