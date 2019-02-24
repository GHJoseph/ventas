@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[7]->Ing_Opc === 1)
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <form method="POST" action="{{ route('Submitbutton') }}" id="Formventa">
            @csrf
            <div class="panel panel-default">

                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Nueva Facturación</b></h3>
                </div>
                <div class="panel-body">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b>Clientes</b></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <input type="hidden" id="Tip_CP" name="Tip_CP">
                                <input type="hidden" id="CodCP" name="CodCP">
                                <input type="hidden" id="CodDocCP" name="CodDocCP">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="TipDocCP">T/Doc.</label>
                                        <input type='text' name="txtTipDocCP" class="form-control input-number"
                                               id="txtTipDocCP" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="NumDocCP">N° Documento</label>
                                        <input type='text' name="txtrucDni" class="form-control input-number"
                                               id="txtrucDni" autofocus="true"/>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="cliente">Cliente</label>
                                        <select id="selectcliente" name="selectcliente" class="form-control cliente"
                                                value="{{ old('selectcliente') }}"></select><span
                                                style="color:red"> {{$errors->first('selectcliente')}} </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="TelCP">Teléfono</label>
                                        <input type='text' name="txtfono" class="form-control" id="txtfono"/>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="CelCP">Celular</label>
                                        <input type='text' name="txtcelu" class="form-control" id="txtcelu"/>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="MailCP">Correo</label>
                                        <input type='email' name="txtcorreo" class="form-control" id="txtcorreo"/>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="DirCP">Dirección</label>
                                        <input id="txtdireccion" type='text' name="txtdireccion" class="form-control"
                                               readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b>Ventas</b></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="NumVta">N° de Venta</label>
                                        <input type='text' name="NumVta_imput" Id="NumVta_imput" class="form-control"
                                               id="ndoc" name="ndoc"
                                               value={{$cNumVnt}} disabled/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="TipDoc">Tipo de Documento</label>
                                        <select name="TipDoc" id="TipDoc" class="form-control">
                                            <option>-- Elija un tipo de documento --</option>
                                            @foreach($tipDoc as $doc)
                                                <option value="{{$doc->Cod_Doc}}">{{$doc->Cod_Doc .' '. $doc->Nom_Doc}}</option>
                                            @endforeach
                                        </select><span style="color:red"> {{$errors->first('txtserie')}} </span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="serie">Serie</label>
                                        <input type='text' name="txtserie" class="form-control" id="txtserie"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="numero">Número</label>
                                        <input type='text' name="numero" id="numero" class="form-control" id="ndoc"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fecEmi">Fecha Emisión</label>
                                        <input type='date' name="fecEmi" class="form-control" id="fecEmi"
                                               value="{{ date("Y-m-d") }}"/><span
                                                style="color:red"> {{$errors->first('fecEmi')}} </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tipventa">Tipo de Venta</label>
                                        <select name="tipventa" id="tipventa" class="form-control">
                                            @foreach($ventastipos as $ventastipo)
                                                <option value="{{$ventastipo->Cod_Tip_Vta}}">{{$ventastipo->Nom_Tip_Vta}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tipcobro">Tipo de Cobro</label>
                                        <select name="tipcobro" id="tipcobro" class="form-control">
                                            @foreach($tiposcobros as $tiposcobro)
                                                <option @if($tiposcobro->Cod_Tip_Cob === '01') selected
                                                        @endif value="{{$tiposcobro->Cod_Tip_Cob}}">{{$tiposcobro->Nom_Tip_Cob}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="moneda">Moneda</label>
                                        <select name="moneda_imput" id="moneda_imput" class="form-control">
                                            @foreach($monedas as $moneda)
                                                <option value="{{$moneda->Cod_Mon}}">{{$moneda->Nom_Mon}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div id="tc" class="col-md-1" style="display: none;">
                                    <div class="form-group">
                                        <label for="tc">T.C</label>
                                        <input type='text' name="txtTC" class="form-control" id="txtTC"
                                               value="{{$tipoCambio->Val_Vta}}"/>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="obser">Observación</label>
                                        <input type='text' name="obser" class="form-control" id="ndoc"/>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Detalle</b></h3>
                            </div>
                            <div class="row">
                                <div class="col-xs-1">
                                    <label for="NumVta">Código</label>
                                    <input class="form-control" type="text" id="txtcodprod" name="txtcodprod"/>
                                </div>
                                <div class="col-xs-2">
                                    <label for="NumVta">Producto / Servicio</label>
                                    <select id="selectproduct" name="selectproduct"
                                            class="form-control articulos"></select>
                                </div>
                                <div class="col-xs-1">
                                    <label for="NumVta">Unidad</label>
                                    <input id="txtUnid" name="txtUnid" class="form-control" type="text"/>
                                </div>
                                <div class="col-xs-1">
                                    <label for="NumVta">Cantidad</label>
                                    <input id="txtcant" name="txtcant" class="form-control input-number" type="text"
                                            {{--value="{{ old('txtcant') }}"--}}/>
                                </div>
                                <div class="col-xs-1">
                                    <label for="NumVta">Precio</label>
                                    <div class="input-group">
                                        <!--  <span id="spandinero" class="input-group-addon" id="basic-addon1">S/.</span> -->
                                        <input class="form-control" type="text" id="txtprecio" name="txtprecio"/>
                                    </div>
                                </div>

                                <div class="col-xs-1">
                                    <label for="NumVta">Valor</label>
                                    <input id="txtvalor" name="txtvalor" class="form-control" type="text"/>
                                </div>

                                <div class="col-xs-1">
                                    <label for="NumVta">Igv</label>
                                    <input id="txtIgv" name="txtIgv" class="form-control" type="text"/>
                                </div>


                                <div class="col-xs-1">
                                    <label for="NumVta">Dscto %</label>
                                    <input id="Dscto" name="Dscto" class="form-control" type="text" value="0"/>
                                </div>

                                <div class="col-xs-1">
                                    <label for="NumVta">P.Venta</label>
                                    <input id="pventa" name="pventa" class="form-control" type="text"/>
                                </div>

                                <div class="col-xs-1" id="Monto">
                                    <label for="NumVta">Monto</label>
                                    <input id="txtMonto" name="txtMonto" class="form-control" type="text" readonly/>
                                </div>
                                <input type="hidden" id="tipo" name="tipo">
                                <div class="col-xs-1" style="padding-top: 25px;">
                                    <button type="button" class="btn btn-primary form-control btn-agregar"
                                            id="btn-agregar" name="btn-agregar" value="btn-agregar"><span
                                                class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </div>
                            </div>
                            <table class="table" id="table" style="margin-top: 6px;">
                                <thead style="background-color: #e3f2fd">
                                <tr>
                                    <th class="col-xs-1 text-center">N°</th>
                                    <th class="col-xs-1 text-center">Código</th>
                                    <th class="col-xs-2 text-left">Producto / Servicio</th>
                                    <th class="col-xs-1 text-center">Cantidad</th>
                                    <th class="col-xs-1 text-center">Precio</th>
                                    <th class="col-xs-1 text-center">Valor</th>
                                    <th class="col-xs-1 text-center">Igv</th>
                                    <th class="col-xs-1 text-center">P.Venta</th>
                                    <th class="col-xs-1 text-center">Dscto %</th>
                                    <th class="col-xs-1 text-center">Monto</th>
                                    <th scope="col" style="display: none;">Usuario</th>
                                </tr>
                                </thead>
                                <tbody id="datos">
                                </tbody>
                            </table>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="labelNum">SON:</label>
                                    <input type="text" class="form-control totaltotal" id="txtNumLetra"
                                           name="txtNumLetra" value="" style="text-align: left;"/>

                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                            @php
                                if($subtotalsum == '0'){
                                    $totsum= 0;
                                }else
                                $totsum = number_format($subtotalsum,2);
                            @endphp


                            <!--     <div class="col-md-2">
                    <label for="SubTotal">SubTotal:</label>
                    <input type="text" value= {{$totsum}} name="SubTotal" class="form-control" id="SubTotal" style="text-align: right;" > </div>
                </div> -->

                                <div class="col-md-2">
                                    <label for="valorventa">Valor Venta:</label>
                                    <input type="text" style="text-align: right;" class="form-control totaltotal"
                                           id="vventa" name="vventa" value="{{$totsum}}"/>
                                </div>

                            </div>

                            <div class="col-md-12 ">
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>

                                <div class="col-md-2">
                                    <label for="IGV">IGV: 18%</label>
                                    <input type="text" value="" name="IGV" class="form-control" id="IGV"
                                           style="text-align: right;"/>
                                </div>


                            </div>
                            <div class="col-md-12 ">
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>


                                <div class="col-md-2"><label for="Porcentaje">Porcentaje:</label><input type="text"
                                                                                                        class="form-control"
                                                                                                        value="0"
                                                                                                        id="txtporc"
                                                                                                        name="txtporc"
                                                                                                        style="text-align: right;"/>
                                </div>
                                <div class="col-md-2">
                                    <label for="Descuento">Descuento:</label>
                                    <input type="text" class="form-control" value="0" id="txtdesc" name="txtdesc"
                                           style="text-align: right;"/></div>

                                <div class="col-md-2">
                                    <label for="SubTotal">SubTotal:</label>
                                    <input type="text" style="text-align: right;" class="form-control" id="subtotal"
                                           name="subtotal"/>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2 dolares" style="display: none;">
                                    <label for="convSoles">Monto Dolares:</label>
                                    <input type="text" class="form-control" value=""
                                           id="convDolar" name="convDolar"
                                           style="text-align: right;">
                                </div>
                                <div class="col-md-2 dolares" style="display: none;">
                                    <label for="convSoles">Monto Soles:</label>
                                    <input type="text" class="form-control" value=""
                                           id="convSoles" name="convSoles"
                                           style="text-align: right;" readonly>
                                </div>
                                <div class="col-md-2 dolares" style="display: none;">
                                    <label for="Vuelto">Vuelto:</label>
                                    <input type="text" class="form-control" value=""
                                           id="vuelto" name="vuelto"
                                           style="text-align: right;" readonly>
                                    <label id="lblVuelto" for="" class="label label-danger" style="display: none;">Monto
                                        menor al Total de Venta</label>
                                </div>
                                <div class="col-md-6 hdolares"></div>
                                <div class="col-md-2">
                                    <label for="totalventa">Total Venta</label>
                                    <input type="text" name="totaltotal" class="form-control" id="totaltotal"
                                           style="text-align: right;"/>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" id="Insert" name="Insert" value="Insert" class="btn btn-primary Insert"
                            title="Grabar"><span class="glyphicon glyphicon-floppy-saved"></span> Generar Venta
                    </button>
                    <a href="{{ url('facturacion/cancelar') }}" class="btn btn-success" data-toggle="tooltip"
                       data-placement="top" title="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>
                        Cancelar Venta</a>
                </div>
            </div>
            <!----------------------    MODAL --------------------------------- -->
            <div class="modal fade" id="myModal2" role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #1fb5ad;">
                            <h4 class="modal-title" id="exampleModalLabel" style="color:#fff;">Editar Articulo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <input id="modal_vta" name="modal_vta" type="hidden">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modal_cantidad">N° Item</label>
                                        <input id="modal_item" class="form-control" name="modal_item" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="productos">Producto / Servicio</label>
                                        <select name="productos" id="productos"
                                                class="form-control" style="width: 100%" disabled>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modal_cantidad">Cantidad</label>
                                        <input id="modal_cantidad" name="modal_cantidad" type="text"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modal_precio">Precio</label>
                                        <input id="modal_precio" name="modal_precio" type="text"
                                               class="form-control text-right" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modal_valor">Valor</label>
                                        <input id="modal_valor" name="modal_valor" type="text"
                                               class="form-control text-right" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modal_igv">IGV</label>
                                        <input id="modal_igv" name="modal_igv" type="text"
                                               class="form-control text-right" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modal_precioventa">Precio Venta</label>
                                        <input id="modal_precioventa" name="modal_precioventa" type="text"
                                               class="form-control text-right" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modal_descuento">Descuento %</label>
                                        <input id="modal_descuento" name="modal_descuento" type="text"
                                               class="form-control text-right">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="modal_monto">Monto</label>
                                        <input id="modal_monto" name="modal_monto" type="text"
                                               class="form-control text-right" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnupdate" name="btnupdate" class="btn btn-primary btnupdate">
                                Modificar
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------  FIN  DEL  MODAL--------------------------------------------------  -->
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
            // Inicializar
            dolar();
            calcularDolar();

            //  Esta  Funcion evita que al presionar Enter se ejecute el submit
            function stopRKey(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if ((evt.keyCode == 13) && (node.type == "text")) {
                    return false;
                }
            }

            document.onkeypress = stopRKey;
            $('#txtTC').prop('readonly', true);
            $('#txtUnid').attr("readonly", "readonly");
            $('#txtfono').attr("readonly", "readonly");
            $('#txtcelu').attr("readonly", "readonly");
            $('#txtcorreo').attr("readonly", "readonly");
            $('#txtserie').attr("readonly", "readonly");
            $('#numero').attr("readonly", "readonly");
            $('#txtcodprod').attr("readonly", "readonly");
            $('#txtprecio').attr("readonly", "readonly");
            $('#txtvalor').attr("readonly", "readonly");
            $('#txtIgv').attr("readonly", "readonly");
            $('#pventa').attr("readonly", "readonly");
            $('#txtMonto').attr("readonly", "readonly");
            $('#vventa').attr("readonly", "readonly");
            $('#IGV').attr("readonly", "readonly");
            $('#subtotal').attr("readonly", "readonly");
            $('#totaltotal').attr("readonly", "readonly");
            $('#txtNumLetra').attr("readonly", "readonly");
            limpiar();
            // Cargar Articulos
            $(".articulos").select2({
                language: {
                    inputTooShort: function (args) {
                        return "Buscar articulos";
                    },
                    errorLoading: function () {
                        return "Error buscando articulos";
                    },
                    loadingMore: function () {
                        return "Buscando más resultados";
                    },
                    noResults: function () {
                        return "No se han encontrado resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    }
                },
                placeholder: "Buscar Producto",
                ajax: {
                    url: "{{ route('Buscaproductos') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            prod: params.term
                        };
                    },
                    processResults: function (data, page) {
                        return {
                            results: data.items
                        };
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 2,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            <!--Me  valida solo numeros-->
            $('.input-number').on('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            <!-- Me filtra los productos por combo -->
            $('#selectproduct').on('change', function () {
                var i = this.value.indexOf("-");
                var tipo = this.value.substring(i + 1, i + 2);
                var codigo = this.value.substring(0, i);
                var data = {codprod: codigo, tipo: tipo};
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('MandaDatosProducto') }}",
                    dataType: 'json',
                    data: data,

                }).done(function (data) {
                    if (data[0].precio === null) {
                        $('#pventa').val(0);
                        swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'El producto/servicio seleccionado no tiene precio definido',
                        })

                    } else {
                        if ($('#moneda_imput').val() === 'D') {
                            var precio = data[0].precio / parseFloat($('#txtTC').val());
                            $('#pventa').val(precio.toFixed(2));
                        } else {
                            $('#pventa').val(data[0].precio);
                        }

                    }
                    codart = data[0].cod;
                    strcodart = codart.toString();
                    formatcodart = strcodart.padStart(4, "0000");
                    $('#tipo').val(tipo);
                    $('#txtcodprod').val(formatcodart);
                    $('#txtUnid').val(data[0].tipo);
                    $('#Dscto').val(0);
                    $('#txtcant').val(0);
                    $('#txtcant').focus();
                    calculaMonto();
                }).fail(function () {
                    // alert("Error");
                });
            });

            <!-- Me filtra los Clientes por combo -->
            function formatRepo(repo) {
                if (repo.loading) return repo.text;
                return repo.name;
            }

            function formatRepoSelection(repo) {
                return repo.name || repo.text;
            }

            var busquedaScript = {
                language: {
                    inputTooShort: function (args) {
                        return "Buscar Clientes";
                    },
                    errorLoading: function () {
                        return "Error buscando Clientes";
                    },
                    loadingMore: function () {
                        return "Buscando más resultados";
                    },
                    noResults: function () {
                        return "No se han encontrado resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    }
                },
                placeholder: "Buscar Clientes",
                ajax: {
                    url: "{{ route('BuscaClientes') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            clien: params.term
                        };
                    },
                    processResults: function (data, page) {
                        return {
                            results: data.items
                        };
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 2,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            };
            $(".cliente").select2(busquedaScript);
            $('#selectcliente').on('change', function () {
                var i = this.value.indexOf("-");
                var tip_CP = this.value.substring(i + 1, i + 2);
                var codigo = this.value.substring(0, i);
                var data = {codclient: codigo, tipo: tip_CP};
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('MandaDatosClientes') }}",
                    dataType: 'json',
                    data: data,

                }).done(function (data) {
                    console.log(data);
                    $('#Tip_CP').val(tip_CP);
                    $('#CodCP').val(data.paciente[0].Cod_CP);
                    $("#CodDocCP").val(data.paciente[0].Cod_Doc_CP);
                    $("#txtTipDocCP").val(data.paciente[0].Tip_Doc_CP);
                    $('#txtrucDni').val(data.paciente[0].Num_Doc_CP);
                    $('#txtfono').val(data.paciente[0].Tel_CP);
                    $('#txtcelu').val(data.paciente[0].Cel_CP);
                    $('#txtcorreo').val(data.paciente[0].Mail_CP);
                    $('#txtdireccion').val(data.paciente[0].Dir_CP);
                    //$('#lbldireccion').html(data[0].Dir_CP);
                    // alert(data[0].Tel_Cp);
                    // console.log(data);

                }).fail(function () {
                    // alert("Error");
                });
            });
            <!-- Me filtra los productos del modal por combo -->
            $('#productos').select2({
                language: {
                    inputTooShort: function (args) {
                        return "Buscar producto/ servicio";
                    },
                    errorLoading: function () {
                        return "Error buscando";
                    },
                    loadingMore: function () {
                        return "Buscando más resultados";
                    },
                    noResults: function () {
                        return "No se han encontrado resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    }
                },
                placeholder: "Buscar Producto/Servicio",
                ajax: {
                    url: "{{ route('Buscaproductos') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            prod: params.term
                        };
                    },
                    processResults: function (data, page) {
                        return {
                            results: data.items
                        };
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 2,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            $('#productos').on('change', function () {
                var i = this.value.indexOf("-");
                var tipo = this.value.substring(i + 1, i + 2);
                var codigo = this.value.substring(0, i);
                var data = {codprod: codigo, tipo: tipo};
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('MandaDatosProducto') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) {
                    $('#modal_precioventa').val(data[0].precio);
                    $('#modal_cantidad').focus();
                    calcular();
                }).fail(function () {
                    // alert("Error");
                });
            });
            <!--  Me manda los datos al seleccionar tipodeDocumento -->
            $('#TipDoc').on('change', function () {
                var data = {codfact: this.value};
                // var data =this.value  ;
                //  alert(data);
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('MandaDatosTipoFactura') }}",
                    dataType: 'json',
                    data: data,

                }).done(function (data) {
                    numDoc = data[0].Num_Doc;
                    SerDoc = data[0].Ser_Doc;
                    MaxNumero = parseInt(numDoc) + 1;
                    strMaxNumero = MaxNumero.toString();

                    $('#txtserie').val(SerDoc);
                    $('#numero').val(strMaxNumero.padStart(6, "000000"));
                    console.log(data);
                }).fail(function () {
                });
            });
            //Se ejecuta al abrir el modal para edicion de item
            $(document).on('click', '.modificarbtn', function () {
                $('#myModal2').modal('show');
                var $row = $(this).closest("tr");    // Find the row
                var $text = $row.find(".nr").text(); // Find the text
                var $canttext = $row.find(".cantcol").text(); // Find the text
                var codArt = $row.find('.codArt').text();
                var producto = $row.find(".valart").text(); // Find the text
                var $preciotext = $row.find(".prevent").text(); // Find the text
                var precio = $row.find('.valprecio').text();
                var valor = $row.find('.valor').text();
                var igv = $row.find('.igv').text();
                var descuento = $row.find('.descuento').text();
                var monto = $row.find('.monto').text();
                var vta = $row.find('.item_vta').text();

                $('#modal_item').val($text);
                $('#modal_cantidad').val($canttext);
                $('#productos').html('<option value=' + codArt + '>' + producto + '</option>');
                $('#modal_precioventa').val($preciotext);
                $('#modal_precio').val(precio);
                $('#modal_valor').val(valor);
                $('#modal_igv').val(igv);
                $('#modal_descuento').val(descuento);
                $('#modal_monto').val(monto);
                $('#modal_vta').val(vta);
            });
            $(document).on('click', '.btnupdate', function () {
                modal_vta = $('#modal_vta').val();
                modal_item = $('#modal_item').val();
                modal_cantidad = $('#modal_cantidad').val();
                modal_producto = ($('#productos').val()).substring(0, 4);
                modal_precio = $('#modal_precio').val();
                modal_valor = $('#modal_valor').val();
                modal_igv = $('#modal_igv').val();
                modal_precioventa = $('#modal_precioventa').val();
                modal_descuento = $('#modal_descuento').val();
                modal_monto = $('#modal_monto').val();
                var prod = $('#productos').select2('data');
                modal_nomProducto = prod[0].name;
                if (typeof modal_nomProducto === "undefined") {
                    modal_nomProducto = $('#productos').text();
                }
                var data = {
                    modal_vta,
                    modal_item,
                    modal_cantidad,
                    modal_producto,
                    modal_precio,
                    modal_valor,
                    modal_igv,
                    modal_precioventa,
                    modal_descuento,
                    modal_monto,
                    modal_nomProducto
                };
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('updatemodaldetalletemp') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) { //200
                    $('#datos').empty();
                    cargatabla();
                    CalculaTotVent();
                    $('#myModal2').modal('toggle');
                    // window.location.reload(true);
                }).fail(function () { ///aqca
                    // alert("Error");
                });
                // alert('Hola');
            });
            // Eliminar item
            $(document).on('click', '.eliminarbtn', function () {
                var item = $(this).attr('data-item');
                var data = {itemdetTemp: item};
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('EliminarDetalleTemporal') }}",
                    data: data,
                }).done(function (data) { //200
                    $('#datos').empty();
                    cargatabla();
                    CalculaTotVent();
                    devuelvenumeroletra();
                }).fail(function () { ///aqca
                });
            });
            // Agregar Item
            $(document).on('click', '.btn-agregar', function () {
                var form = $('#Formventa');
                var data = form.serialize();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: "{{ route('GrabaDetallesVentaTemp') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) {
                    $('#datos').empty();
                    cargatabla();
                    $('#selectproduct').val('');
                    $('#txtcant').val('');
                    $('#txtprecio').val('');
                    $('#txtvalor').val('');
                    $('#txtIgv').val('');
                    $('#pventa').val('');
                    $('#txtMonto').val('');
                    $('#Dscto').val('');
                }).fail(function () {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Verifique que todos los campos esten llenos por favor!',
                    });
                });
            });

            //Carga la tabla
            function cargatabla() {
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('Devuelvesdatosdetalletemp') }}",
                    dataType: 'json',
                }).done(function (data) {
                    var valor = 0;
                    var igv = 0;
                    $.each(data['datosvenDetTemp'], function (index, value) {
                        var dst = (value.Dst_Art === null ? '0' : value.Dst_Art);
                        if ($('#moneda_imput').val() === 'D') {
                            valor = valor + parseFloat(value.Val_Art_ME);
                            igv = igv + parseFloat(value.Igv_Art_ME);
                            var markup = "<tr><td class='item_vta' style='display: none;'>" + value.Item_Vnt + "</td><th scope='row' class='nr text-center'>" + (index + 1) + "</th><td class='text-center codArt'>" + value.Cod_Art + "</td><td id ='valart' class='valart'>" + value.Nom_Art + "</td><td id ='cantcol' class='cantcol text-center'>" + value.Can_Art + "</td><td id ='valprecio' class='valprecio text-right'>" + parseFloat(value.Pre_Art_ME).toFixed(2) + "</td><td class='text-right valor'>" + parseFloat(value.Val_Art_ME).toFixed(2) + "</td><td class='text-right igv'>" + parseFloat(value.Igv_Art_ME).toFixed(2) + "</td><td id ='prevent' class='prevent text-right'>" + parseFloat(value.Pre_Vnt_ME).toFixed(2) + "</td><td class='descuento text-right'>" + dst + "</td><td class='text-right monto'>" + parseFloat(value.Vta_Art_ME) + "</td><td class='text-center'><button class='btn btn-primary modificarbtn' id='btnModificar' name='btnModificar'type='button'><span class='glyphicon glyphicon-pencil'></span></button></td><td><button class='btn btn-danger eliminarbtn' id='btnEliminar' name='btnEliminar' type='button' data-item = '" + value.Item_Vnt + "'><span class='glyphicon glyphicon-trash'></span></button></td></tr>";
                        } else {
                            valor = valor + parseFloat(value.Val_Art_MN);
                            igv = igv + parseFloat(value.Igv_Art_MN);
                            var markup = "<tr><td class='item_vta' style='display: none;'>" + value.Item_Vnt + "</td><th scope='row' class='nr text-center'>" + (index + 1) + "</th><td class='text-center codArt'>" + value.Cod_Art + "</td><td id ='valart' class='valart'>" + value.Nom_Art + "</td><td id ='cantcol' class='cantcol text-center'>" + value.Can_Art + "</td><td id ='valprecio' class='valprecio text-right'>" + parseFloat(value.Pre_Art_MN).toFixed(2) + "</td><td class='text-right valor'>" + parseFloat(value.Val_Art_MN).toFixed(2) + "</td><td class='text-right igv'>" + parseFloat(value.Igv_Art_MN).toFixed(2) + "</td><td id ='prevent' class='prevent text-right'>" + parseFloat(value.Pre_Vnt_MN).toFixed(2) + "</td><td class='descuento text-right'>" + dst + "</td><td class='text-right monto'>" + parseFloat(value.Vta_Art_MN) + "</td><td class='text-center'><button class='btn btn-primary modificarbtn' id='btnModificar' name='btnModificar'type='button'><span class='glyphicon glyphicon-pencil'></span></button></td><td><button class='btn btn-danger eliminarbtn' id='btnEliminar' name='btnEliminar' type='button' data-item = '" + value.Item_Vnt + "'><span class='glyphicon glyphicon-trash'></span></button></td></tr>";
                        }
                        $('#datos').append(markup);
                    });
                    subtotal = igv + valor;
                    $('#vventa').val(valor.toFixed(2));
                    $('#IGV').val(igv.toFixed(2));
                    $('#subtotal').val(subtotal.toFixed(2));
                    CalculaTotVent();

                }).fail(function () {
                    // alert("Error");
                });
            };
            function vuelto(){
                if($('#convDolar').val()!==''){
                    var tc = parseFloat($('#txtTC').val());
                    var monto = parseFloat($('#convDolar').val());
                    var monto_convertido = tc * monto;
                    if ($('#moneda_imput').val() === 'D') {
                        var total_venta = parseFloat($('#totaltotal').val()) * tc;
                    } else {
                        var total_venta = $('#totaltotal').val();
                    }

                    var vuelto = parseFloat(monto_convertido - total_venta);
                    $('#convSoles').val(monto_convertido.toFixed(2));
                    if (vuelto < 0) {
                        $('#vuelto').val('');
                        $('#lblVuelto').show('slow');
                    } else {
                        $('#vuelto').val(vuelto.toFixed(2));
                        $('#lblVuelto').hide('slow');
                    }
                }
            }
            //Me  calcula el valor si digito en cantidad y/o descuento item
            $('#txtcant').on("keyup", function (e) {
                console.log($(this).val());
                debugger;
                if ($('#txtcant').val() !== '') {
                    calculaMonto();
                } else {
                    $('#txtprecio').val(0);
                    $('#txtvalor').val(0);
                    $('#txtIgv').val(0);
                    $('#txtMonto').val(0);
                }
            });
            $("#Dscto").on('keyup', function (e) {
                if ($('#Dscto').val() !== '') {
                    calculaMonto()
                }
            });

            function calculaMonto() {
                if ($('#txtcant').val() !== '' && $('#Dscto').val() !== '') {
                    precioVenta = $('#pventa').val();
                    cantidad = $('#txtcant').val();
                    Monto = parseFloat(precioVenta) * parseFloat(cantidad);
                    Descuento = Monto * (parseFloat($('#Dscto').val()) / 100);
                    MontoDescuento = Monto - Descuento;
                    Valor = MontoDescuento / 1.18;
                    igv = MontoDescuento - Valor;
                    if (parseInt($('#txtcant').val()) !== 0) {
                        precio = Valor.toFixed(2) / cantidad;
                    } else {
                        precio = 0;
                    }
                    $('#txtMonto').val(MontoDescuento.toFixed(2));
                    $('#txtvalor').val(Valor.toFixed(2));
                    $('#txtIgv').val(igv.toFixed(2));
                    $('#txtprecio').val(precio.toFixed(2));
                } else {
                    $('#txtprecio').val(0);
                    $('#txtvalor').val(0);
                    $('#txtIgv').val(0);
                    $('#txtMonto').val(0);
                }

            }

            //Devuelve el numero en letras
            function devuelvenumeroletra() {
                var data = {total: $("#totaltotal").val(), nomoneda: $("#moneda_imput option:selected").text()};
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('devuelveNumeroaLetras') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) { //200
                    $("#txtNumLetra").val(data.numletra);
                }).fail(function () { ///aqca
                    // alert("Error");
                });
            }

            //Calculo de Descuento Global
            $('#txtdesc').on("keyup", function (e) {
                subtotal = parseFloat($('#subtotal').val());
                descuento = parseFloat($(this).val() === '' ? 0 : $(this).val());
                total = subtotal - descuento;
                porcentaje = (descuento / subtotal) * 100;
                $("#txtporc").val(porcentaje.toFixed(2));
                $('#totaltotal').val(total.toFixed(2));
                calcularTotal();
            });
            $('#txtporc').on("keyup", function (e) {
                subtotal = parseFloat($('#subtotal').val());
                porcentaje = parseFloat($(this).val() === '' ? 0 : $(this).val()) / 100;
                descuento = porcentaje * subtotal;
                total = subtotal - descuento;
                $('#totaltotal').val(total.toFixed(2));
                $('#txtdesc').val(descuento.toFixed(2));
                calcularTotal();
            });

            //Calcula el total de la venta
            function CalculaTotVent() {
                vventa = parseFloat($('#vventa').val());
                igv = parseFloat($('#IGV').val());
                if ($('#txtdesc').val() !== '') {
                    descuento = parseFloat($('#txtdesc').val());
                } else {
                    descuento = 0;
                }
                total = (vventa + igv) - descuento;
                $('#totaltotal').val(total.toFixed(2));
                devuelvenumeroletra();
            }

            function calcularTotal() {
                var totalventa = $('#totaltotal').val();
                var igv = totalventa - (totalventa / 1.18);
                var valor = totalventa - igv;
                $('#vventa').val(valor.toFixed(2));
                $('#IGV').val(igv.toFixed(2));
                devuelvenumeroletra();
            }

            // Buscar por dni y/o ruc
            $('#txtrucDni').on("keypress", function (e) {
                if (e.keyCode === 13) {
                    var data = {cliente: $("#txtrucDni").val()};

                    // alert($("#selectcliente").val());
                    $.ajax({
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('BuscaClientexDocumento') }}",
                        dataType: 'json',
                        data: data,
                    }).done(function (data) { //200
                        // alert(data.paciente[0].Cod_CP);
                        var $example = $("#selectcliente").select2();
                        $example.select2('destroy');
                        $example.append($('<option>', { //agrego los valores que obtengo de una base de datos
                            value: data.paciente[0].Cod_CP,
                            text: data.paciente[0].Nom_CP,
                            selected: true
                        }));
                        console.log(data);
                        $example.select2(busquedaScript);
                        $("#Tip_CP").val(data.tip_CP);
                        $('#CodCP').val(data.paciente[0].Cod_CP);
                        $("#CodDocCP").val(data.paciente[0].Cod_Doc_CP);
                        $("#txtTipDocCP").val(data.paciente[0].Tip_Doc_CP);
                        $('#txtfono').val(data.paciente[0].Tel_CP);
                        $('#txtcelu').val(data.paciente[0].Cel_CP);
                        $('#txtcorreo').val(data.paciente[0].Mail_CP);
                        $('#txtdireccion').val(data.paciente[0].Dir_CP);

                    }).fail(function () { ///aqca
                        // alert("Error");
                    });
                }

            });

            // limpir inputs
            function limpiar() {
                $('#txtNumLetra').val('');
                $('#vventa').val('');
                $('#IGV').val('');
                $('#txtporc').val('');
                $('#txtdesc').val('');
                $('#subtotal').val('0.00');
                $('#totaltotal').val('0.00');
            }

            //Calcula el descuento e IGV de la edicion del item en el modal
            $('#modal_cantidad').on('keyup', function () {
                calcular();
            });
            $('#modal_descuento').on('keyup', function () {
                calcular();
            });

            function calcular() {
                var cantidad = ($('#modal_cantidad').val() == '') ? 0 : parseInt(($('#modal_cantidad').val()));
                var precioventa = parseFloat($('#modal_precioventa').val());
                var descuento = ($('#modal_descuento').val() == '') ? 0 : parseFloat(($('#modal_descuento').val())) / 100;
                var precio = (precioventa / 1.18).toFixed(2);
                var monto = cantidad * precioventa;
                var monto_desc = monto - (monto * descuento);
                var igv = monto_desc - (monto_desc / 1.18);
                var valor = monto_desc - igv;

                $('#modal_monto').val(monto_desc.toFixed(2));
                $('#modal_igv').val(igv.toFixed(2));
                $('#modal_precio').val(precio);
                $('#modal_valor').val(valor.toFixed(2));
            }

            function dolar() {
                $('#moneda_imput').on('change', function () {
                    var codigo = $('#moneda_imput').val();
                    var tc = parseFloat($('#txtTC').val());
                    if (codigo === 'D') {
                        $('#tc').show();
                        $('.dolares').show();
                        $('.hdolares').hide();
                        if ($('#pventa').val() !== '') {
                            var precio_venta = parseFloat($('#pventa').val()) / tc;
                            $('#pventa').val(precio_venta.toFixed(2));
                        }
                    } else {
                        $('#tc').hide();
                        $('.dolares').hide();
                        $('.hdolares').show();
                        if ($('#pventa').val() !== '') {
                            var precio_venta = parseFloat($('#pventa').val()) * tc;
                            $('#pventa').val(precio_venta.toFixed(2));
                        }
                    }
                    calculaMonto();
                    $('#datos').html('');
                    cargatabla();
                });
            }

            function calcularDolar() {
                $('#convDolar').on('keyup', function () {
                    if ($(this).val().trim() !== '') {
                        var tc = parseFloat($('#txtTC').val());
                        var monto = parseFloat($(this).val());
                        var monto_convertido = tc * monto;
                        if ($('#moneda_imput').val() === 'D') {
                            var total_venta = parseFloat($('#totaltotal').val()) * tc;
                        } else {
                            var total_venta = $('#totaltotal').val();
                        }

                        var vuelto = parseFloat(monto_convertido - total_venta);
                        $('#convSoles').val(monto_convertido.toFixed(2));
                        if (vuelto < 0) {
                            $('#vuelto').val('');
                            $('#lblVuelto').show('slow');
                        } else {
                            $('#vuelto').val(vuelto.toFixed(2));
                            $('#lblVuelto').hide('slow');
                        }

                    }

                });
            }
        });
    </script>
@endsection


