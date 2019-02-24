@extends('layouts.main')
@section('contenido')
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
                            <h2>{{$persona->Nom_CP}}</h2>
                            <p>
                                <strong>R.U.C. :</strong> {{$persona->Num_Doc}}<br>
                                <strong>Dirección:</strong> {{$persona->Dir_CP}}<br>
                                <strong>Cel:</strong> {{$persona->Cel_CP}}<br>
                                <strong>Correo:</strong> {{$persona->Mail_CP}}<br>
                            </p>
                            <p>
                                .
                            </p>
                            <p>
                                <strong>Concepto:</strong> {{$nota->Nom_Con}}<br>
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-5 pull-right">
                            <table class="table cuadro"
                                   style="background-color: #1fb5ad; border-radius: 10px; color: #fff">
                                @if($nota->Cod_Doc == '07')
                                    <tr>
                                        <td align="center" style="border: none;"><b> R.U.C.: 20504068146 <br> NOTA DE
                                                CRÉDITO
                                                <br> ELECTRÓNICA</b><br>
                                            {{$nota->Ser_Doc}} N°
                                            {{$nota->Num_Doc}}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td align="center" style="border: none;"><b> R.U.C.: 20504068146 <br> NOTA DE
                                                DÉDITO
                                                <br> ELECTRÓNICA</b><br>
                                            {{$nota->Ser_Doc}} N°
                                            {{$nota->Num_Doc}}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 inv-label">Fecha de Emisión:</div>
                                <div class="col-md-6 col-sm-6">{{date('d-m-Y', strtotime($nota->Fec_Doc))}}</div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 inv-label">Documento que modifica:</div>
                                <div class="col-md-6 col-sm-6">{{$nota->Tip_Doc_Ref}}: {{$nota->Ser_Doc_Ref}}
                                    - {{$nota->Num_Doc_Ref}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 inv-label">Fecha:</div>
                                <div class="col-md-6 col-sm-6">{{date('d-m-Y', strtotime($nota->Fec_Doc_Ref))}}</div>
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
                            <th class="text-center">Valor Unitario</th>
                            <th class="text-center">Valor Total</th>
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
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">{{$nota->Can_Nota}}</td>
                                <td class="text-center">{{$nota->Cod_Tip_Dscto}}</td>
                                <td>{{$nota->Nom_Con}}</td>
                                <td class="text-center">UND.</td>
                                <td class="text-center">{{$nota->Pre_Nota_MN}} </td>
                                <td class="text-center">{{$nota->Val_Nota_MN}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-8 col-xs-7 payment-method">
                            <h5 style="padding-left: 20px;">SON: {{$nota->Tot_Nota_Letra}}</h5>
                            {{-- <p>1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                             <p>2. Pellentesque tincidunt pulvinar magna quis rhoncus.</p>
                             <p>3. Cras rhoncus risus vitae congue commodo.</p>
                             <br>
                             <h3 class="inv-label itatic">Thank you for your business</h3>--}}
                        </div>
                        <div class="col-md-4 col-xs-5 invoice-block pull-right">
                            <ul class="unstyled amounts">
                                <li>Valor de Venta : S/ {{$nota->Val_Nota_MN}}</li>
                                <li>IGV ({{$nota->Tas_Imp}}%) : S/ {{$nota->Igv_Nota_MN}}</li>
                                <li class="grand-total">Total : S/ {{$nota->Tot_Nota_MN}}</li>
                            </ul>
                        </div>
                        <div class="col-xs-12">
                            <img class="center-block" src="{{ asset('images/CodeBar.jpg') }}" alt="Solvetic"
                                 style="width: 400px; height: 150px;">
                        </div>
                    </div>

                    <div class="text-center invoice-btn">
                        <a href="{{ url('notas/index') }}" class="btn btn-success btn-lg"><i class="fa fa-home"></i></a>
                        <a href="../../Reportes/reportenota/{{$nota->Num_Nota}}" target="_blank"
                           class="btn btn-primary btn-lg"><i class="fa fa-print"></i> Imprimir </a>
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection