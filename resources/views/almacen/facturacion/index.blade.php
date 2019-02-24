@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[7]->Todos === 1)
        <form action="{{ route('enviadatosfact') }}" method="GET">
            @csrf
            <div class="panel panel-default">

                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <div class="row">
                        <div class="col-md-12" style="line-height: 35px;">
                            <h3 class="panel-title" style="color:#fff; font-size: 16px;"><b><span
                                            class="glyphicon glyphicon-list"
                                            aria-hidden="true">
                            </span> Resumen de Venta de Facturación Electrónica</b>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered dt-responsive" id="tabla">
                        <thead style="background-color: #e3f2fd">
                        <tr>
                            <th class="text-center">N° DE VENTA</th>
                            <th class="text-center">FECHA DE VENTA</th>
                            <th class="text-center">DOC</th>
                            <th class="text-center">SERIE</th>
                            <th class="text-center">NUMERO</th>
                            <th class="text-center">FECHA DE DOC</th>
                            <th class="text-center">CLIENTE</th>
                            <th class="text-center">TOTAL</th>
                            {{-- <th>TOTAL $US</th>--}}
                            <th class="text-center">MONEDA</th>
                            <th class="text-center">PDF</th>
                            <th class="text-center">CDR</th>
                            <th class="text-center">ESTADO SUNAT</th>
                            <th>
                                @if($usuario_opciones[7]->Ing_Opc === 1)
                                    <a href="{{url('almacen/facturacion/create')}}" class="btn btn-primary"
                                       data-toggle="tooltip" data-placement="top" title=" Agregar factura">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </a>
                                @endif
                            </th>
                            <th>
                                <a type="button" class="sunatb btn-primary" data-placement="top" data-toggle="modal"
                                   data-target="#enviarsunat"
                                   title="Envio Sunat">
                                    <img class="sunat" src="{{asset('Imagenes/sunatlogo.png')}}" alt="" height="28px"
                                         width="28px">
                                    </button>
                            </th>
                        </tr>
                        </thead>
                        <style type="text/css">
                            .Pendiente {
                                color: blue;
                                background-color: yellow;
                                border-color: #4cae4c;
                                border-radius: 2px;
                                width: 100%;
                                display: inline-block;
                                padding: 6px 12px;
                                margin-bottom: 0;
                                font-size: 14px;
                                font-weight: 400;
                                line-height: 1.42857143;
                                text-align: center;
                                white-space: nowrap;
                                vertical-align: middle;
                            }
                        </style>

                        <tbody>
                        @foreach($ventas as $venta)
                            <tr>
                                <td class="text-center">{{$venta->Num_Vnt}}</td>
                                <td class="text-center">{{date('d-m-Y', strtotime($venta->Fec_Vnt))}}</td>
                                <td class="text-center">{{$venta->Tip_Doc}}</td>
                                <td class="text-center">{{$venta->Ser_Doc}}</td>
                                <td class="text-center">{{$venta->Num_Doc}}</td>
                                <td class="text-center">{{date('d-m-Y', strtotime($venta->Fec_Doc))}}</td>
                                <td class="text-left">{{$venta->Nom_CP}}</td>
                                @if($venta->Cod_Mon =='D')
                                    <td class="text-right">{{$venta->Tot_Vta_ME}}</td>
                                @else
                                    <td class="text-right">{{$venta->Tot_Vta_MN}}</td>
                                @endif
                                <td class="text-center">{{$venta->Cod_Mon }}</td>
                                <td>
                                    @if($usuario_opciones[7]->Imp_Opc === 1)
                                        <a href="{{route('ventas.reporte',$venta->Num_Vnt)}}"
                                           class="btn btn-danger btn-sm"
                                           data-toggle="tooltip" title="Generar" target="_blank">PDF
                                        </a>
                                    @endif
                                </td>
                                <td></td>
                                <td><p class='Pendiente'>Pendiente</p></td>
                                <td>
                                    @if($usuario_opciones[7]->Mod_Opc === 1)
                                        <a href="../facturacion/edit/{{$venta->Num_Vnt}}" class="btn btn-success btn-sm"
                                           data-toggle="tooltip" data-placement="top" title="Editar Venta"><span
                                                    class="glyphicon glyphicon-edit"></span></a>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <style>
                            .TablaTotales {
                                width: 100%;
                                max-width: 100%;
                                margin-bottom: 0px;
                                padding: 8px;
                            }

                            @import url("http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css");
                            .panel-pricing {
                                -moz-transition: all .3s ease;
                                -o-transition: all .3s ease;
                                -webkit-transition: all .3s ease;
                            }

                            .panel-pricing:hover {
                                box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2);
                            }

                            .panel-pricing .panel-heading {
                                padding: 20px 10px;
                            }

                            .panel-pricing .panel-heading .fa {
                                margin-top: 10px;
                                font-size: 30px;
                            }

                            .panel-pricing .list-group-item {
                                color: #565656;
                                border-bottom: 1px solid rgba(250, 250, 250, 0.5);
                            }

                            .panel-pricing .list-group-item:last-child {
                                border-bottom-right-radius: 0px;
                                border-bottom-left-radius: 0px;
                            }

                            .panel-pricing .list-group-item:first-child {
                                border-top-right-radius: 0px;
                                border-top-left-radius: 0px;
                            }

                            .panel-pricing .panel-body {
                                background-color: #f0f0f0;
                                font-size: 16px;
                                color: #565656;
                                padding: 3px;
                                margin: 0px;
                            }
                        </style>
                        <table class="TablaTotales ">
                            <tr>
                                <td>
                                    <div class="panel panel-success panel-pricing table-hover">
                                        <div class="panel-body text-center">
                                            @php
                                                if (empty($venta)){
                                              $varmes= "";
                                                }else{
                                                         $NumMes=substr($venta->Fec_Doc,-5,2) ;
                                                          switch ($NumMes) {
                                                              case '01':
                                                                  $varmes = 'Enero';
                                                                  break;
                                                              case '02':
                                                                  $varmes = 'Febrero';
                                                                  break;
                                                              case '03':
                                                                  $varmes = 'Marzo';
                                                                  break;
                                                              case '04':
                                                                  $varmes = 'Abril';
                                                                  break;
                                                              case '05':
                                                                  $varmes = 'Mayo';
                                                                  break;
                                                              case '06':
                                                                  $varmes = 'Junio';
                                                                  break;
                                                              case '07':
                                                                  $varmes = 'Julio';
                                                                  break;
                                                              case '08':
                                                                  $varmes = 'Agosto';
                                                                  break;
                                                              case '09':
                                                                  $varmes ='Septiembre';
                                                                  break;
                                                              case '10':
                                                                  $varmes  = 'Octubre';
                                                                  break;
                                                              case '11':
                                                              $varmes = 'Noviembre';
                                                                  break;
                                                              case '12':
                                                              $varmes = 'Diciembre';
                                                                  break;
                                                          }

                                              }
                                            @endphp


                                            <p><strong>Estados</strong></p>
                                        </div>
                                        <ul class="list-group text-center">
                                            <li class="list-group-item"> &nbsp;
                                                <br> <i class="fa fa-check"></i> ACTIVOS
                                                <br> &nbsp;
                                            </li>
                                            <li class="list-group-item">&nbsp;
                                                <br><i class="fa fa-close"></i> ANULADOS
                                                <br> &nbsp;
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="panel panel-success panel-pricing">
                                        <div class="panel-body text-center">
                                            <p><strong>Tipo De Documento</strong></p>
                                        </div>
                                        <ul class="list-group text-center">
                                            <li class="list-group-item">Factura</li>
                                            <li class="list-group-item">Boleta</li>
                                            <li class="list-group-item">Factura</li>
                                            <li class="list-group-item">Boleta</li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="panel panel-success panel-pricing">
                                        <div class="panel-body text-center">
                                            <p><strong>Cantidad</strong></p>
                                        </div>
                                        <ul class="list-group text-center">
                                            <li class="list-group-item">
                                                @php($facturas = 0)
                                                @foreach($ventas as $venta)
                                                    @if($venta->Cod_Doc === '01')
                                                        @php($facturas++)
                                                    @endif
                                                @endforeach
                                                {{$facturas}}
                                            </li>
                                            <li class="list-group-item">
                                                @php($boletas = 0)
                                                @foreach($ventas as $venta)
                                                    @if($venta->Cod_Doc === '03')
                                                        @php($boletas++)
                                                    @endif
                                                @endforeach
                                                {{$boletas}}
                                            </li>
                                            <li class="list-group-item">
                                                @php($facturas_anulados = 0)
                                                @foreach($ventas_anulados as $venta)
                                                    @if($venta->Cod_Doc === '01')
                                                        @php($facturas_anulados++)
                                                    @endif
                                                @endforeach
                                                {{$facturas_anulados}}
                                            </li>
                                            <li class="list-group-item">
                                                @php($boletas_anulados = 0)
                                                @foreach($ventas_anulados as $venta)
                                                    @if($venta->Cod_Doc === '03')
                                                        @php($boletas_anulados++)
                                                    @endif
                                                @endforeach
                                                {{$boletas_anulados}}
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="panel panel-success panel-pricing">
                                        <div class="panel-body text-center">
                                            <p><strong>Totales(S/)</strong></p>
                                        </div>
                                        <ul class="list-group text-center">
                                            <li class="list-group-item">
                                                @php($sumfacturas = 0)
                                                @foreach($ventas as $venta)
                                                    @if($venta->Cod_Doc === '01')
                                                        @php($sumfacturas += $venta->Tot_Vta_MN)
                                                    @endif
                                                @endforeach
                                                {{$sumfacturas}}
                                            </li>
                                            <li class="list-group-item">
                                                @php($sumboletas = 0)
                                                @foreach($ventas as $venta)
                                                    @if($venta->Cod_Doc === '03')
                                                        @php($sumboletas += $venta->Tot_Vta_MN)
                                                    @endif
                                                @endforeach
                                                {{$sumboletas}}
                                            </li>

                                            <li class="list-group-item">
                                                @php($sumfacturas_anulados = 0)
                                                @foreach($ventas_anulados as $venta)
                                                    @if($venta->Cod_Doc === '01')
                                                        @php($sumfacturas_anulados += $venta->Tot_Vta_MN)
                                                    @endif
                                                @endforeach
                                                {{$sumfacturas_anulados}}
                                            </li>
                                            <li class="list-group-item">
                                                @php($sumboletas_anulados = 0)
                                                @foreach($ventas_anulados as $venta)
                                                    @if($venta->Cod_Doc === '03')
                                                        @php($sumboletas_anulados += $venta->Tot_Vta_MN)
                                                    @endif
                                                @endforeach
                                                {{$sumboletas_anulados}}
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="panel panel-success panel-pricing">
                                        <div class="panel-body text-center">
                                            <p><strong>Totales($US)</strong></p>
                                        </div>
                                        <ul class="list-group text-center">
                                            <li class="list-group-item">
                                                @php($sumfacturasME = 0)
                                                @foreach($ventas as $venta)
                                                    @if($venta->Cod_Doc === '01')
                                                        @php($sumfacturasME += $venta->Tot_Vta_ME)
                                                    @endif
                                                @endforeach
                                                {{$sumfacturasME}}
                                            </li>
                                            <li class="list-group-item">
                                                @php($sumboletasME = 0)
                                                @foreach($ventas as $venta)
                                                    @if($venta->Cod_Doc === '03')
                                                        @php($sumboletasME += $venta->Tot_Vta_ME)
                                                    @endif
                                                @endforeach
                                                {{$sumboletasME}}
                                            </li>
                                            <li class="list-group-item">
                                                @php($sumfacturasME_anulados = 0)
                                                @foreach($ventas_anulados as $venta)
                                                    @if($venta->Cod_Doc === '01')
                                                        @php($sumfacturasME_anulados += $venta->Tot_Vta_ME)
                                                    @endif
                                                @endforeach
                                                {{$sumfacturasME_anulados}}
                                            </li>
                                            <li class="list-group-item">
                                                @php($sumboletasME_anulados = 0)
                                                @foreach($ventas_anulados as $venta)
                                                    @if($venta->Cod_Doc === '03')
                                                        @php($sumboletasME_anulados += $venta->Tot_Vta_ME)
                                                    @endif
                                                @endforeach
                                                {{$sumboletasME_anulados}}
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>

            </div>
        </form>
    @else
        <div class="alert alert-info">
            <b><i class="fa fa-warning"></i></b> Usted no tiene acceso a esta opción, comuniquese con el administrador
            para que le dé los permisos necesarios.
        </div>
    @endif
    <!-- Modal -->
    <div id="enviarsunat" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Enviar Sunat</h4>
                </div>
                <div class="modal-body">
                    @if(count($pendientes) >0)
                        <p>Desea enviar el documento {{$pendientes[0]->TIP_DOC}} {{$pendientes[0]->SER_DOC}}
                            -{{$pendientes[0]->NUM_DOC}} de fecha {{date('d-m-Y', strtotime($pendientes[0]->FEC_DOC))}}
                            a SUNAT?</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <a href="{{ route('crear_xml')}}" class="btn btn-success">Enviar</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('javascripts')
    <script type="text/javascript">
        // ----------  Me filtra la tabla por text -------------------
        $(document).ready(function () {
            var table = $('#tabla').DataTable({
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
                "dom": '<"toolbar">frtip'
            });
            $("div.toolbar").html('<div class="col-md-1 col-md-offset-3">\n' +
                '                            <label><span class="glyphicon glyphicon-calendar"\n' +
                '                                                             aria-hidden="true"></span> Periodo:</label>\n' +
                '                        </div>\n' +
                '<div class="col-md-4">\n' +
                '                                    <div class="input-group input-large" data-date-format="dd-mm-yyyy">\n' +
                '                                        <input id="datepickVenta" type="text" class="form-control dpd1" name="fechaInicio" value="{{$inicio}}">\n' +
                '                                        <span class="input-group-addon">A</span>\n' +
                '                                        <input id="datepickVenta2" type="text" class="form-control dpd2" name="fechaFin" value="{{$fin}}" >\n' +
                '                                    </div>\n' +
                '                                </div>' +
                '                        <div class="col-md-1">\n' +
                '                            <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-info"><i class="fa fa-search"></i> Buscar</button>\n' +
                '                        </div>');

            Cargacombomes();

            // Me selecciona por determinado el mes en el combomes
            function Cargacombomes() {
                var d = new Date(),
                    n = d.getMonth();
                mesact = n + 1;
                messtring = mesact.toString();
                formatmes = messtring.padStart(2, "00");
                $("#selectmes").val(formatmes);
            }

            $("#buscar").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#tabla tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            // ---------------  Fin del filtrado  -----------------------------
            var nowTemp = new Date();
            var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
            var checkin = $('.dpd1').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function (date) {
                    console.log(date);
                    return date < now ? 'disabled' : '';
                }
            }).on('changeDate', function (ev) {
                if (ev.date > checkout.date) {
                    console.log('mayor');
                    var newDate = new Date(ev.date);
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            }).data('datepicker');
            var checkout = $('.dpd2').datepicker({
                format: 'dd-mm-yyyy',
                onRender: function (date) {
                    return date <= checkin.date ? 'disabled' : '';
                }
            }).on('changeDate', function (ev) {
                checkout.hide();
            }).data('datepicker');

        });
    </script>
@endsection



