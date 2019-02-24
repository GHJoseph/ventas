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

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> </head>

  <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <style>
          .logo {
            width: 15%;
          }
        </style>
        <div class="row">
          <div class="col-sm-12">
            <h1 class="page-header">
       
         <img class="logo" src="{{ asset('images/logo-quirovida.png') }}" alt="">
           <small class="pull-right"> Fecha: {{date("Y-m-d")}}</small>
        </h1> </div>
          <!-- /.col --> 
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-5 invoice-col"> De<address>
            <strong>Quirovida,  Rehabilitación Integral S.A.C.</strong><br>
           Calle. Las Águilas 263 <br>
            Lima - Perú<br>
            Cel: (804) 123-5432<br>
            Email: info@almasaeedstudio.com
          </address> </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col"> A <address>
            <strong>Señor(es): JOMAN S.A.C</strong><br>
            R.U.C. : 20538533239<br>
            Av Los Salmos- LIMA - LIMA<br>
            Cel: (555) 539-1037<br>
             Moneda : {{$Moneda->Nom_Mon}}
        
          </address> </div>
          <!-- /.col -->


          <div class="col-sm-3 invoice-col">



            <table class="table" border="1">



              @if($resultR->Cod_Doc == '01')
  
                        <tr>
                         <td align="center"><b> R.U.C.: 20504068146 <br> FACTURA DE VENTA
                        <br> ELECTRÓNICA</b><br>
                        {{$resultR->Ser_Doc}} N°
                        {{$resultR->Num_Doc}}
                            </td>
                        </tr>
              @else
                     <tr>
                         <td align="center"><b> R.U.C.: 20504068146 <br> BOLETA DE VENTA
                        <br> ELECTRÓNICA</b><br>
                       {{$resultR->Ser_Doc}} N°
                        {{$resultR->Num_Doc}}
                            </td>
                        </tr>
              @endif
              
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- Table row -->
        <div class="row">


          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <thead>
                <tr style="border-top: 1px solid #000">
                    <th style="width:7%">Nº</th>
                  <th style="width:10;text-align: center%">Cantidad</th>
                  <th style="width:10%">Codigo</th>
                  <th style="width:40%">Descripción</th>
                  <th style="width:7%">Unidad</th>
                  <th style="width:15%;text-align: right;">Valor Unitario</th>
                  <th style="width:15%;text-align: right;">Valor Total</th>
                </tr>
              </thead>
              @if($resultR->Cod_Mon == 'S')
              
              <tbody>
                @php $i=0; @endphp
                @if($resultVD) @foreach($resultVD as $data)
              @php $i=$i+1; @endphp
                  <tr>
                    <td>{{$i}}</td>
                    <td align="center">{{$data->Can_Art}}</td>
                    <td >{{$data->Cod_Art}}</td>
                    <td>{{$data->Nom_Art}}</td>
                    <td>{{$data->Tip_Und}}</td>
                    <td align="right">{{round($data->Pre_Art_MN,2)}} </td>
                    <td align="right">{{$data->Val_Art_MN}}</td>
                  </tr>
                  @endforeach @endif
              </tbody>
              @else
                     <tbody>
                @if($resultVD) @foreach($resultVD as $data)
                  <tr>
                    <td align="center">{{$data->Can_Art}}</td>
                    <td>{{$data->Cod_Art}}</td>
                    <td>{{$data->Nom_Art}}</td>
                    <td align="center">{{round($data->Pre_Art_ME,2)}} </td>
                    <td align="right">{{$data->Val_Art_ME}}</td>
                  </tr>
                  @endforeach @endif
              </tbody>
              @endif
            </table>
          </div>
          <!-- /.col -->
        </div>
        <br>
        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-7">
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> Representación Impresa de la FACTURA DE VENTA ELECTRÓNICA, consultar documentos visitando la gágina www.facttron.com/20123964579 Autorizado mediante Resolución de Superintendencia N°155-2017/Sunat. </p>
          </div>
          <div class="col-xs-1"></div>

          <div class="col-xs-4">
            <div class="table-responsive">
              <table class="table">
              @if($resultR->Cod_Mon == 'S')
                  <tr>
                    <th style="width:50%">Valor Venta :</th>
                    <td>{{$Moneda->Tip_Mon}}</td>
                    <td align="right">
                        {{$resultR->Val_Vta_MN}}
                    </td> 
                  </tr>
                  <tr>
                    <th>Igv {{$resultR->Tas_Imp}} %:</th>
                    <td>{{$Moneda->Tip_Mon}}</td>
                    <td align="right">
                    {{$resultR->Igv_Vta_MN}}
                    </td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td>S/</td>
                    <td align="right">
                       {{$resultR->Tot_Vta_MN}}
                    </td>
                  </tr>
              @else 
                   <tr>
                    <th style="width:50%">Valor Venta :</th>
                    <td>{{$Moneda->Tip_Mon}}</td>
                    <td align="right">
                        {{$resultR->Val_Vta_ME}}
                    </td> 
                  </tr>
                  <tr>
                    <th>Igv {{$resultR->Tas_Imp}} %:</th>
                    <td>{{$Moneda->Tip_Mon}}</td>
                    <td align="right">
                        {{$resultR->Igv_Vta_ME}}
                    </td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td>S/</td>
                    <td align="right">
                        {{$resultR->Tot_Vta_ME}}
                    </td>
                  </tr>
               @endif
              </table>

            </div>


          </div>
          <!-- /.col -->
        </div>
         <img  height="500%" class="center-block" src="{{ asset('images/CodeBar.jpg') }}" alt="Solvetic">
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>

    <!-- ./wrapper -->
  </body>

  </html>

