@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[8]->Mod_Opc === 1)
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <form method="POST" action="" id="Formnota">
            @csrf
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Actualización Nota de Venta</b></h3>
                </div>
                <div class="panel-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b>Cliente</b></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <input type="hidden" id="Tip_CP" name="TipCP" value="{{$nota->Tip_CP}}">
                                <input type="hidden" id="CodCP" name="CodCP" value="{{$nota->Cod_CP}}">
                                <input type="hidden" id="CodDocCP" name="CodDocCP" value="{{$nota->Cod_Doc_CP}}">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="TipDocCP">T/Doc.</label>
                                        <input type='text' name="TipDocCP" class="form-control input-number"
                                               id="TipDocCP" value="{{$nota->Tip_Doc_CP}}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="NumDocCP">N° Documento</label>
                                        <input type='text' name="NumDoc" class="form-control input-number"
                                               id="NumDoc" value="{{$nota->Num_Doc_CP}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cliente">Cliente</label>
                                        <select id="selectcliente" name="selectcliente" class="form-control cliente">
                                            <option value="{{ $nota->Cod_CP}}">{{$persona->nombre }}</option>
                                        </select><span style="color:red"> {{$errors->first('selectcliente')}} </span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="CodPer">Telefono</label>
                                        <input type='text' name="CodTel" class="form-control" id="txtfono"
                                               value="{{$persona->telefono}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="CodPer">Celular</label>
                                        <input type='text' name="CodCel" class="form-control" id="txtcelu"
                                               value="{{$persona->celular}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="CodPer">Correo</label>
                                        <input type='email' name="CodMail" class="form-control" id="txtcorreo"
                                               value="{{$persona->mail}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="Direccion">Dirección</label>
                                        <input id="txtdireccion" type='text' name="CodDir" class="form-control"
                                               value="{{$persona->direccion}}"
                                               readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b>Nota</b></h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="NumVta">N° de Nota</label>
                                        <input type='text' name="NumNota" id="NumNota" class="form-control"
                                               value="{{$nota->Num_Nota}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 divtipdoc">
                                    <div class="form-group">
                                        <label for="TipDoc">Tipo de Documento</label>
                                        <select name="TipDoc" id="TipDoc" class="form-control">
                                            <!--      <option>-- Elija un tipo de documento --</option> -->
                                            @foreach($tipDoc as $doc)
                                                <option @if($doc->Cod_Doc === $nota->Cod_Doc) selected
                                                        @endif value="{{$doc->Cod_Doc}}">{{$doc->Cod_Doc .' '. $doc->Nom_Doc}}</option>
                                            @endforeach
                                        </select><span style="color:red"> {{$errors->first('txtserie')}} </span>

                                    </div>
                                </div>

                                <div class="col-md-2 divdocapli">
                                    <div class="form-group">
                                        <label for="TipDocApli">Documento que Aplica</label>
                                        <select name="TipDocApli" id="TipDocApli" class="form-control">
                                            <option val="0">-- Elija un tipo de documento --</option>
                                            @foreach($TipDocApli as $doc)
                                                <option @if($doc->Cod_Doc === $nota->Cod_Doc_Ref) selected
                                                        @endif  value="{{$doc->Cod_Doc}}">{{$doc->Cod_Doc .' '. $doc->Nom_Doc}}</option>
                                            @endforeach
                                        </select><span style="color:red"> {{$errors->first('txtserie')}} </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="serie">Serie</label>
                                        <input type='text' name="SerDoc" class="form-control" id="txtserie"
                                               value="{{$nota->Ser_Doc}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="numero">Número</label>
                                        <input type='text' name="NumDocNota" id="numero" class="form-control"
                                               value="{{$nota->Num_Doc}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fecEmi">Fecha Emisión</label>
                                        <input type='date' name="FecEmi" class="form-control" id="fecEmi"
                                               value="{{ $nota->Fec_Doc}}"><span
                                                style="color:red"> {{$errors->first('fecEmi')}} </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if($nota->Cod_Doc === '07')
                                    <div class="col-md-3 divdesc">
                                        <div class="form-group">
                                            <label for="moneda">Tipo de Concepto</label>
                                            <select name="TipDesc" id="tipdesc" class="form-control">
                                                @foreach($tipodesc as $Tipodesc)
                                                    <option @if($nota->Cod_Tip_Dscto === $Tipodesc->Cod_Tip_Dscto ) selected
                                                            @endif value="{{$Tipodesc->Cod_Tip_Dscto}}">{{$Tipodesc->Nom_Tip_Dscto}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 divingr" style="display: none;">
                                        <div class="form-group">
                                            <label for="moneda"> Tipo de Concepto</label>
                                            <select id="tipingre" name="TipIngreso" class="form-control">
                                                @foreach($tipoIng as $tipoIng)
                                                    <option value="{{$tipoIng->Cod_Tip_Ing}}">{{$tipoIng->Nom_Tip_Ing}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-3 divdesc" style="display: none;">
                                        <div class="form-group">
                                            <label for="moneda">Tipo de Concepto</label>
                                            <select name="TipDesc" id="tipdesc" class="form-control">
                                                @foreach($tipodesc as $Tipodesc)
                                                    <option @if($nota->Cod_Tip_Dscto === $Tipodesc->Cod_Tip_Dscto ) selected
                                                            @endif value="{{$Tipodesc->Cod_Tip_Dscto}}">{{$Tipodesc->Nom_Tip_Dscto}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 divingr">
                                        <div class="form-group">
                                            <label for="moneda"> Tipo de Concepto</label>
                                            <select id="tipingre" name="TipIngreso" class="form-control">
                                                @foreach($tipoIng as $tipoIng)
                                                    <option value="{{$tipoIng->Cod_Tip_Ing}}">{{$tipoIng->Nom_Tip_Ing}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="moneda">Moneda</label>
                                        <select name="Moneda" id="moneda_imput" class="form-control">
                                            @foreach($monedas as $moneda)
                                                <option @if($moneda->Cod_Mon === $nota->Cod_Mon) selected
                                                        @endif value="{{$moneda->Cod_Mon}}">{{$moneda->Nom_Mon}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if($nota->Tip_Cam === 'D')
                                    <div id="tc" class="col-md-1">
                                        <div class="form-group">
                                            <label for="tc">T.C</label>
                                            <input type='text' name="TipoCambio" class="form-control" id="txtTC"
                                                   value="{{$nota->Tip_Cam}}"></select><span
                                                    style="color:red"> {{$errors->first('tc')}} </span>
                                        </div>
                                    </div>
                                @else
                                    <div id="tc" class="col-md-1" style="display: none;">
                                        <div class="form-group">
                                            <label for="tc">T.C</label>
                                            <input type='text' name="TipoCambio" class="form-control" id="txtTC"
                                                   value="{{$nota->Tip_Cam}}"></select><span
                                                    style="color:red"> {{$errors->first('tc')}} </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="obser">Observación</label>
                                        <input type='text' name="Obs" class="form-control" value="{{$nota->Obs_Nota}}">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b>Detalle</b></h3>
                        </div>
                        <div class="panel panel-body">
                            <div class="row">
                                @if($nota->Cod_Tip_Dscto === '001')
                                    <div class="col-xs-2 tipoConcepto" style="display: none;">
                                        <label for="NumVta">Cantidad</label>
                                        <input id="txtcant" name="Cantidad" class="form-control input-number"
                                               type="number"
                                               value="{{ $nota->Can_Nota  }}" style="text-align: right;"/>
                                    </div>
                                    <div class="col-xs-2 tipoConcepto" style="display: none;">
                                        <label for="NumVta">Precio</label>
                                        <div class="input-group">
                                            <!--  <span id="spandinero" class="input-group-addon" id="basic-addon1">S/.</span> -->
                                            <input class="form-control" type="text" id="txtprecio" name="Precio"
                                                   value="{{$nota->Pre_Nota_MN}}" style="text-align: right;"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 tipoConcepto" style="display: none;">
                                        <label for="NumVta">Valor</label>
                                        <input id="txtvalor" name="Valor" class="form-control" type="text"
                                               value="{{$nota->Val_Nota_MN}}" style="text-align: right;"/>
                                    </div>
                                    <div class="col-xs-2 tipoConcepto" style="display: none;">
                                        <label for="NumVta">Igv</label>
                                        <input id="txtIgv" name="IGV" class="form-control" type="text"
                                               value="{{$nota->Igv_Nota_MN}}" style="text-align: right;"/>
                                    </div>
                                    <div class="col-xs-2 tipoConcepto" style="display: none;">
                                        <label for="NumVta">Monto </label>
                                        <input type="text" id="txtMontoDesc" name="MontoDesc" class="form-control"
                                               value="{{$nota->Tot_Nota_MN}}" style="text-align: right;"/>
                                    </div>
                                @else
                                    <div class="col-xs-2 tipoConcepto">
                                        <label for="NumVta">Cantidad</label>
                                        <input id="txtcant" name="Cantidad" class="form-control input-number"
                                               type="number"
                                               value="{{ $nota->Can_Nota  }}" style="text-align: right;"/>
                                    </div>
                                    <div class="col-xs-2 tipoConcepto">
                                        <label for="NumVta">Precio</label>
                                        <div class="input-group">
                                            <!--  <span id="spandinero" class="input-group-addon" id="basic-addon1">S/.</span> -->
                                            <input class="form-control" type="text" id="txtprecio" name="Precio"
                                                   value="{{$nota->Pre_Nota_MN}}" style="text-align: right;"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 tipoConcepto">
                                        <label for="NumVta">Valor</label>
                                        <input id="txtvalor" name="Valor" class="form-control" type="text"
                                               value="{{$nota->Val_Nota_MN}}" style="text-align: right;"/>
                                    </div>
                                    <div class="col-xs-2 tipoConcepto">
                                        <label for="NumVta">Igv</label>
                                        <input id="txtIgv" name="IGV" class="form-control" type="text"
                                               value="{{$nota->Igv_Nota_MN}}" style="text-align: right;"/>
                                    </div>
                                    <div class="col-xs-2 tipoConcepto">
                                        <label for="NumVta">Monto </label>
                                        <input type="text" id="txtMontoDesc" name="MontoDesc" class="form-control"
                                               value="{{$nota->Tot_Nota_MN}}" style="text-align: right;"/>
                                    </div>
                                @endif
                                <div class="col-xs-12">
                                    <table class="table" id="Table1" name="table1" style="margin-top: 6px;">
                                        <thead style="background-color: #e3f2fd">
                                        <tr>
                                            <th class="text-center" scope="col">Sel</th>
                                            <th class="text-center" scope="col">TIPO</th>
                                            <th class="text-center" scope="col">DOC</th>
                                            <th class="text-center" scope="col">SERIE</th>
                                            <th class="text-center" scope="col">NUMERO</th>
                                            <th class="text-center" scope="col">F.EMISION</th>
                                            <th class="text-center" scope="col">MONEDA</th>
                                            <th class="text-center" scope="col">VAL.DOC</th>
                                            <th class="text-center" scope="col">IGV.DOC</th>
                                            <th class="text-center" scope="col">TOT.DOC</th>
                                            <th class="text-center" scope="col">VER</th>
                                        </tr>
                                        </thead>
                                        <tbody id="datos">
                                        @foreach($detalle as $det)
                                            <tr>
                                                <th class="text-center">
                                                    <input class='checkboxes' type='checkbox' name='checkboxes'
                                                           id='checkboxes' value='{{$det->NUM_VNT}}'
                                                           data-valormn='{{$det->VAL_VTA_MN}}'
                                                           data-igvmn='{{$det->IGV_VTA_MN}}'
                                                           data-totmn='{{$det->TOT_VTA_MN}}'
                                                           data-valorme='{{$det->VAL_VTA_ME}}'
                                                           data-igvme='{{$det->IGV_VTA_ME}}'
                                                           data-totme='{{$det->TOT_VTA_ME}}'
                                                           data-tipdoc='{{$det->TIP_DOC}}'
                                                           data-coddoc='{{$det->COD_DOC}}'
                                                           data-serie='{{$det->SER_DOC}}'
                                                           data-numero='{{$det->NUM_DOC}}'
                                                           data-fecha='{{$det->FEC_DOC}}'
                                                           data-codmon='{{ $det->COD_MON }}'
                                                           data-tipocambio='{{ $det->TIP_CAM }}'
                                                           checked>
                                                </th>
                                                <td id='coddoc' class='text-center coddoc'>{{$det->COD_DOC}}</td>
                                                <td id='valtipo' class='text-center valtipo'>{{$det->TIP_DOC}}</td>
                                                <td id='seriecol' class='text-center seriecol'>{{$det->SER_DOC}}</td>
                                                <td id='numerocol' class='text-center numerocol'>{{$det->NUM_DOC}}</td>
                                                <td id='valfemic' class='text-center valfemic'>
                                                    @php
                                                        $fecha = $det->FEC_DOC;
                           $fecha = substr($fecha,8, 2).'-'.substr($fecha,5, 2).'-'.substr($fecha,0, 4);
                                                    @endphp {{$fecha}}</td>
                                                <td class="text-center">{{$det->COD_MON}}</td>
                                                @if($det->COD_MON === 'D')
                                                    <td class="text-right">{{$det->VAL_VTA_ME}}</td>
                                                    <td class="text-right">{{$det->IGV_VTA_ME}}</td>
                                                    <td class="text-right">{{$det->TOT_VTA_ME}}</td>
                                                @else
                                                    <td class="text-right">{{$det->VAL_VTA_MN}}</td>
                                                    <td class="text-right">{{$det->IGV_VTA_MN}}</td>
                                                    <td class="text-right">{{$det->TOT_VTA_MN}}</td>
                                                @endif

                                                <td class="text-center">
                                                    <button class='btn btn-primary modificarbtn' id='btnModificar'
                                                            data-NumVnt="{{$det->NUM_VNT}}" name='btnModificar'
                                                            type='button'><span
                                                                class='glyphicon glyphicon-search'></span></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!----------------------    MODAL --------------------------------- -->
                                <div class="modal fade fullscreen-modal" id="myModal2" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #1fb5ad;">
                                                <h4 class="modal-title" id="exampleModalLabel" style="color:#fff;">
                                                    Detalle Comprobante</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vTipDocCP">T/Doc.</label>
                                                            <input type='text' name="vTipDocCP"
                                                                   class="form-control input-number"
                                                                   id="vTipDocCP" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vNumDocCP">N° Documento</label>
                                                            <input type='text' name="vNumDocCP"
                                                                   class="form-control input-number"
                                                                   id="vNumDocCP" autofocus="true" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="cliente">Cliente</label>
                                                            <input id="vNomCP" type="text" class="form-control"
                                                                   readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vTelCP">Teléfono</label>
                                                            <input type='text' name="vTelCP" class="form-control"
                                                                   id="vTelCP" readonly/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vCelCP">Celular</label>
                                                            <input type='text' name="vCelCP" class="form-control"
                                                                   id="vCelCP" readonly/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="vMailCP">Correo</label>
                                                            <input type='email' name="vMailCP" class="form-control"
                                                                   id="vMailCP" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="vDirCP">Dirección</label>
                                                            <input id="vDirCP" type='text' name="vDirCP"
                                                                   class="form-control"
                                                                   readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vNumVta">N° de Venta</label>
                                                            <input type='text' name="vNumVta" Id="vNumVta"
                                                                   class="form-control" disabled/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="vTipDoc">Tipo de Documento</label>
                                                            <select name="vTipDoc" id="vTipDoc" class="form-control"
                                                                    disabled>
                                                                <option value="01">01 FACTURA</option>
                                                                <option value="03">03 BOLETA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vSerieDoc">Serie</label>
                                                            <input type='text' name="vSerieDoc" class="form-control"
                                                                   id="vSerieDoc" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vNumDoc">Número</label>
                                                            <input type='text' name="vNumDoc" id="vNumDoc"
                                                                   class="form-control" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="vFecEmi">Fecha Emisión</label>
                                                            <input type='date' name="vFecEmi" class="form-control"
                                                                   id="vFecEmi" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vTipoVenta">Tipo de Venta</label>
                                                            <select name="vTipoVenta" id="vTipoVenta"
                                                                    class="form-control" disabled>
                                                                @foreach($ventastipos as $ventastipo)
                                                                    <option value="{{$ventastipo->Cod_Tip_Vta}}">{{$ventastipo->Nom_Tip_Vta}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vTipoCobro">Tipo de Cobro</label>
                                                            <select name="vTipoCobro" id="vTipoCobro"
                                                                    class="form-control" disabled>
                                                                @foreach($tiposcobros as $tiposcobro)
                                                                    <option value="{{$tiposcobro->Cod_Tip_Cob}}">{{$tiposcobro->Nom_Tip_Cob}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="vMoneda">Moneda</label>
                                                            <select name="vMoneda" id="vMoneda"
                                                                    class="form-control" disabled>
                                                                @foreach($monedas as $moneda)
                                                                    <option value="{{$moneda->Cod_Mon}}">{{$moneda->Nom_Mon}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <label for="vTC">T.C</label>
                                                            <input type='text' name="vTC" class="form-control"
                                                                   id="vTC" readonly/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="vObserv">Observación</label>
                                                            <input type='text' name="vObserv" class="form-control"
                                                                   id="vObserv" readonly/>
                                                        </div>
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
                                                        <th class="col-xs-1 text-center">Dscto</th>
                                                        <th class="col-xs-1 text-center">Monto</th>
                                                        <th scope="col" style="display: none;">Usuario</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="vDatos">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label for="labelNum">SON:</label>
                                        <input type="text" class="form-control totaltotal" id="txtNumLetra"
                                               name="NumLetra" value="{{$nota->Tot_Nota_Letra}}"
                                               style="text-align: left;" readonly>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <label for="c">Valor Venta:</label>
                                        @if($nota->Cod_Mon === 'S')
                                            <input type="text" style="text-align: right;"
                                                   class="form-control totaltotal"
                                                   id="vventa" name="ValorVenta" value="{{$detalle[0]->VAL_VTA_MN}}"
                                                   readonly/>
                                        @else
                                            <input type="text" style="text-align: right;"
                                                   class="form-control totaltotal"
                                                   id="vventa" name="ValorVenta" value="{{$detalle[0]->VAL_VTA_ME}}"
                                                   readonly/>
                                        @endif
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
                                        @if($nota->Cod_Mon === 'S')
                                            <input type="text" value="{{$detalle[0]->IGV_VTA_MN}}" name="IGV"
                                                   class="form-control" id="IGV"
                                                   style="text-align: right;" readonly>
                                        @else
                                            <input type="text" value="{{$detalle[0]->IGV_VTA_MN}}" name="IGV"
                                                   class="form-control" id="IGV"
                                                   style="text-align: right;" readonly>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <label for="totalventa">Total Venta</label>
                                        @if($nota->Cod_Mon === 'S')
                                            <input type="text" name="TotalVenta" class="form-control" id="totaltotal"
                                                   style="text-align: right;" value="{{$detalle[0]->TOT_VTA_MN}}"
                                                   readonly>
                                        @else
                                            <input type="text" name="TotalVenta" class="form-control" id="totaltotal"
                                                   style="text-align: right;" value="{{$detalle[0]->TOT_VTA_ME}}"
                                                   readonly>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" id="Insert" name="Insert" value="Insert"
                            class="btn btn-primary Insert" title="Grabar"><span
                                class="glyphicon glyphicon-floppy-saved"></span> Grabar Nota
                    </button>
                    <a href="{{ url('notas/index') }}" class="btn btn-success" data-toggle="tooltip"
                       data-placement="top" title="Cancelar"><span
                                class="glyphicon glyphicon-floppy-remove"></span> Cancelar </a>
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
        $(document).ready(function () {
            $('#moneda_imput').on('change', function () {
                var codigo = $('#moneda_imput').val();
                var tc = parseFloat($('#txtTC').val());
                if (codigo === 'D') {
                    $('#tc').show();
                    if ($('#pventa').val() !== '') {
                        var precio_venta = parseFloat($('#pventa').val()) / tc;
                        $('#pventa').val(precio_venta.toFixed(2));
                    }
                } else {
                    $('#tc').hide();
                    if ($('#pventa').val() !== '') {
                        var precio_venta = parseFloat($('#pventa').val()) * tc;
                        $('#pventa').val(precio_venta.toFixed(2));
                    }
                }
                checked();
            });

            function checked() {
                var totval = 0;
                var totigv = 0;
                var tot = 0;
                $(".checkboxes:checked").each(function () {
                    console.log($(this).attr('data-codmon'));
                    console.log($('#moneda_imput').val());
                    // var dolar = parseFloat($('#txtTC').val());
                    if ($(this).attr('data-codmon') === 'D') {
                        totval += parseFloat($(this).attr('data-valorme'));
                        totigv += parseFloat($(this).attr('data-igvme'));
                        tot += parseFloat($(this).attr('data-totme'));
                    } else {
                        totval += parseFloat($(this).attr('data-valormn'));
                        totigv += parseFloat($(this).attr('data-igvmn'));
                        tot += parseFloat($(this).attr('data-totmn'));
                    }
                });
                $("#vventa").val((totval).toFixed(2));
                $("#IGV").val((totigv).toFixed(2));
                $("#totaltotal").val((tot).toFixed(2));
                //devuelvenumeroletra();
                //tipoConcepto();
            }

            $('#selectproduct').on('change', function () {
                var data = {codprod: this.value};
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('MandaDatosProducto') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) {
                    $('#pventa').val(data[0].Pre_Vta_MN);
                    codart = data[0].Cod_Art;
                    strcodart = codart.toString();
                    formatcodart = strcodart.padStart(4, "0000");
                    $('#txtcodprod').val(formatcodart);
                    $('#txtUnid').val(data[0].Tip_Und);
                }).fail(function () {
                    // alert("Error");
                });
            });
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
                    $('#Tip_CP').val(tip_CP);
                    $('#CodCP').val(codigo);
                    $('#CodDocCP').val(data.paciente[0].Cod_Doc_CP);
                    $('#TipDocCP').val(data.paciente[0].Tip_Doc_CP);
                    $('#NumDoc').val(data.paciente[0].Num_Doc_CP);
                    $('#txtfono').val(data.paciente[0].Tel_CP);
                    $('#txtcelu').val(data.paciente[0].Cel_CP);
                    $('#txtcorreo').val(data.paciente[0].Mail_CP);
                    $('#txtdireccion').val(data.paciente[0].Dir_CP);
                }).fail(function () {
                    // alert("Error");
                });
            });
            <!-- Me filtra los Clientes por combo -->
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

            function formatRepo(repo) {
                if (repo.loading) return repo.text;
                return repo.name;
            }

            function formatRepoSelection(repo) {
                return repo.name || repo.text;
            }

            <!-- Me filtra los productos por combo -->
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

            function formatRepo(repo) {
                if (repo.loading) return repo.text;
                return repo.name;
            }

            function formatRepoSelection(repo) {
                return repo.name || repo.text;
            }

            $('.input-number').on('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            // Insertamos la Nota de Venta
            $("#Insert").click(function () {
                var arrayNumVnt = [];
                var arrayCodDoc = [];
                var arrayTipDoc = [];
                var arraySerie = [];
                var arrayNumero = [];
                var arrayFecha = [];
                i = 0;
                $(".checkboxes:checked").each(function () {
                    i = i + 1;
                    var objNumVnt = {};
                    var objCodDoc = {};
                    var objTipDoc = {};
                    var objSerie = {};
                    var objNumero = {};
                    var objFecha = {};

                    NumVnt = $(this).val();
                    CodDoc = $(this).attr('data-coddoc');
                    TipDoc = $(this).attr('data-tipdoc');
                    Serie = $(this).attr('data-serie');
                    Numero = $(this).attr('data-numero');
                    Fecha = $(this).attr('data-fecha');

                    /*Asignamos como Valor el contador*/
                    objNumVnt[i] = NumVnt;
                    objCodDoc[i] = CodDoc;
                    objTipDoc[i] = TipDoc;
                    objSerie[i] = Serie;
                    objNumero[i] = Numero;
                    objFecha[i] = Fecha;

                    arrayNumVnt.push(objNumVnt);
                    arrayCodDoc.push(objCodDoc);
                    arrayTipDoc.push(objTipDoc);
                    arraySerie.push(objSerie);
                    arrayNumero.push(objNumero);
                    arrayFecha.push(objFecha);

                });
                var DocRef = {
                    NumVntRef: arrayNumVnt,
                    CodDocRef: arrayCodDoc,
                    TipDocRef: arrayTipDoc,
                    SerieRef: arraySerie,
                    NumeroRef: arrayNumero,
                    FechaRef: arrayFecha,
                };
                Form = $('#Formnota').serialize();
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('updatenotadeventas') }}",
                    dataType: 'json',
                    data: {
                        'DocRef': DocRef,
                        'Form': Form,
                    },
                    success: function (response) {
                        window.location.href = response.page;
                    }
                });
            });

            //Calculo al cargar la pagina
            $('#txtTC').prop('readonly', true);
            $('#txtserie').attr("readonly", "readonly");
            $('#numero').attr("readonly", "readonly");
            $('#txtprecio').attr("readonly", "readonly");
            $('#txtvalor').attr("readonly", "readonly");
            $('#txtIgv').attr("readonly", "readonly");
            $('#vventa').attr("readonly", "readonly");
            $('#IGV').attr("readonly", "readonly");
            $('#totaltotal').attr("readonly", "readonly");
            //        $('#txtNumLetra').attr("readonly","readonly");
            /*$('.divdesc').show();
            $('.divingr').hide();*/
            // devuelvenumeroletra();

            //  Esta  Funcion evita que al presionar Enter se ejecute el submit
            function stopRKey(evt) {
                var evt = (evt) ? evt : ((event) ? event : null);
                var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
                if ((evt.keyCode == 13) && (node.type == "text")) {
                    return false;
                }
            }

            document.onkeypress = stopRKey;

            $(document).on('click', '.btnupdate', function () {
                // alert($('#txtitem').val());
                nroitem = $('#txtitem').val();
                usumodal = $('#txtusu').val();
                cantmodal = $('#txtcantmodal').val();
                artmodal = $('#txtarti').val();
                preciomodal = $('#txtpreciomod').val();
                var data = {nroitem, usumodal, cantmodal, artmodal, preciomodal};

                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('updatemodaldetalletemp') }}",
                    dataType: 'json',
                    data: data,

                }).done(function (data) { //200


                    $('#datos').empty();
                    cargatabla();
                    // CalculaTotVent();

                    // window.location.reload(true);

                }).fail(function () { ///aqca
                    // alert("Error");
                });


                // alert('Hola');
            });

            <!--------------------  Envia datos al Modal ----------------------------->
            $(document).on('click', '.modificarbtn', function () {
                $('#myModal2').modal('show');
                /*var $row = $(this).closest("tr");    // Find the row
                var $text = $row.find(".nr").text(); // Find the text
                var $usertext = $row.find(".usercol").text(); // Find the text
                var $canttext = $row.find(".cantcol").text(); // Find the text
                var $arttext = $row.find(".valart").text(); // Find the text
                var $preciotext = $row.find(".prevent").text(); // Find the text

                $('#txtitem').val($text);
                $('#txtusu').val($usertext);
                $('#txtcantmodal').val($canttext);
                $('#txtarti').val($arttext);
                $('#txtpreciomod').val($preciotext);*/
                var NumVnt = $(this).attr('data-NumVnt');
                var data = {
                    NumVnt: NumVnt
                };
                console.log(data);
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('detalleVenta') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) { //200
                    $('#vNumDocCP').val(data['cabecera']['Num_Doc_CP']);
                    $('#vTipDocCP').val(data['cabecera']['Tip_Doc_CP']);
                    $('#vNomCP').val(data['persona']['Nom_CP']);
                    $('#vTelCP').val(data['persona']['Tel_CP']);
                    $('#vCelCP').val(data['persona']['Cel_CP']);
                    $('#vMailCP').val(data['persona']['Mail_CP']);
                    $('#vDirCP').val(data['persona']['Dir_CP']);

                    $('#vNumVta').val(data['cabecera']['Num_Vnt']);
                    $('#vTipDoc').val(data['cabecera']['Cod_Doc']);
                    $('#vSerieDoc').val(data['cabecera']['Ser_Doc']);
                    $('#vNumDoc').val(data['cabecera']['Num_Doc']);
                    $('#vFecEmi').val(data['cabecera']['Fec_Vnt']);
                    $('#vTipoVenta').val(data['cabecera']['Cod_Tip_Vta']);
                    $('#vTipoCobro').val(data['cabecera']['Cod_Tip_Cob']);
                    $('#vMoneda').val(data['cabecera']['Cod_Mon']);
                    $('#vTC').val(data['cabecera']['Tip_Cam']);
                    $('#vObserv').val(data['cabecera']['Obs_Vnt']);
                    var detalle = '';
                    $.each(data['detalle'], function (index, value) {
                        var descuento = value.Dst_Art === '' ? 0 : value.Dst_Art;
                        descuento = parseFloat(descuento).toFixed(2);
                        detalle = detalle + '<tr>' +
                            '<th class="text-center">' + (index + 1) + '</th>' +
                            '<td class="text-center">' + value.Cod_Art + '</td>' +
                            '<td class="text-left">' + value.Nom_Art + '</td>' +
                            '<td class="text-center">' + value.Can_Art + '</td>' +
                            '<td class="text-right">' + value.Pre_Art_MN.toFixed(2) + '</td>' +
                            '<td class="text-right">' + value.Val_Art_MN.toFixed(2) + '</td>' +
                            '<td class="text-right">' + value.Igv_Art_MN.toFixed(2) + '</td>' +
                            '<td class="text-right">' + value.Pre_Vnt_MN.toFixed(2) + '</td>' +
                            '<td class="text-right">' + descuento + '</td>' +
                            '<td class="text-right">' + value.Vta_Art_MN.toFixed(2) + '</td>' +
                            '</tr>';

                    });

                    $('#vDatos').html(detalle);
                }).fail(function () { ///aqca
                    // alert("Error");
                });
            });

            function calculaMonto() {
                valor = $('#txtMontoDesc').val() / 1.18;
                $('#txtvalor').val(valor.toFixed(2));
                Igv = $('#txtMontoDesc').val() - valor;
                $('#txtIgv').val(Igv.toFixed(2));
                precio = valor / $('#txtcant').val();
                $('#txtprecio').val(precio.toFixed(2));
            }

            //  --- Me  calcula el valor si presiono enter en cantidad --------
            $('#txtMontoDesc').on("keyup", function (e) {
                if ($(this).val().length !== 0) {
                    var total = $('#totaltotal').val();
                    var limite = parseFloat(total);
                    var monto = parseFloat($(this).val());
                    if (monto <= limite) {
                        calculaMonto();
                        devuelvenumeroletranota();
                    } else {
                        swal({
                            type: 'error',
                            title: 'Oops...',
                            text: 'No debe exceder el monto de venta',
                        });
                        $(this).val(limite);
                    }
                } else {
                    $('#txtIgv').val('');
                    $('#txtvalor').val('');
                    $('#txtprecio').val('');
                }
            });
            // --------- Me  filtra el combolist "Tipo de documento "-----------------------
            $("#TipDoc").change(function () {

                if ($("#TipDoc").val() == '07') {
                    $('.divdesc').show();
                    $('.divingr').hide();
                }

                if ($("#TipDoc").val() == '08') {
                    $('.divdesc').hide();
                    $('.divingr').show();
                }


                var data = {TipDocApli: $("#TipDocApli").val(), TipDoc: $("#TipDoc").val()};

                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('retornadatoscombos') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) { //200
                    $("#txtserie").val(data.correlativoNventa[0].Ser_Doc);
                    $("#numero").val(data.correlativoNventa[0].Num_Doc + 1);
                }).fail(function () { ///aqca
                    // alert("Error");
                });
            });
            // --------- Me  filtra el combolist "Documento que aplica"-----------------------
            $("#TipDocApli").change(function () {
                if ($('#selectcliente').val() === null) {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Seleccione un cliente',
                    });
                    $("#TipDocApli").val('0');
                } else {
                    var data = {TipDocApli: $("#TipDocApli").val(), TipDoc: $("#TipDoc").val()};
                    $.ajax({
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('retornadatoscombos') }}",
                        dataType: 'json',
                        data: data,
                    }).done(function (data) { //200
                        $("#txtserie").val(data.correlativoNventa[0].Ser_Doc);
                        maxnota = parseInt(data.correlativoNventa[0].Num_Doc) + 1;
                        strmaxnota = maxnota.toString();
                        nronota = strmaxnota.padStart(10, "0000000000");
                        $("#numero").val(nronota);
                        cargarComprobantes($("#Tip_CP").val(), $("#CodCP").val(), $("#TipDocApli").val());
                    }).fail(function () { ///aqca
                        // alert("Error");
                    });
                }
            });

            function devuelvenumeroletra() {
                var data = {
                    total: parseFloat($("#totaltotal").val()).toFixed(2),
                    nomoneda: $("#moneda_imput option:selected").text()
                };
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('devuelveNumeroaLetras') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) { //200
                    // $('#datos').empty();
                    //  cargatabla();
                    $("#txtNumLetra").val(data.numletra);
                }).fail(function () { ///aqca
                    // alert("Error");
                });
            }

            function devuelvenumeroletranota() {
                var data = {
                    total: parseFloat($("#txtMontoDesc").val()).toFixed(2),
                    nomoneda: $("#moneda_imput option:selected").text()
                };
                console.log(data);
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('devuelveNumeroaLetras') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) { //200
                    // $('#datos').empty();
                    //  cargatabla();
                    $("#txtNumLetra").val(data.numletra);
                }).fail(function () { ///aqca
                    // alert("Error");
                });
            }

            $(document).on('click', '.checkboxes', function () {
                var totval = 0;
                var totigv = 0;
                var tot = 0;

                $(".checkboxes:checked").each(function () {
                    totval += parseFloat($(this).attr('data-valor'));
                    totigv += parseFloat($(this).attr('data-igv'));
                    tot += parseFloat($(this).attr('data-tot'));
                });
                $("#vventa").val((totval).toFixed(2));
                $("#IGV").val((totigv).toFixed(2));
                $("#totaltotal").val((tot).toFixed(2));
                devuelvenumeroletra();
                tipoConcepto();
            });

            $('#txtrucDni').on("keypress", function (e) {
                if (e.keyCode === 13) {
                    var data = {cliente: $("#txtrucDni").val()};
                    $.ajax({
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('BuscaClientexDocumento') }}",
                        dataType: 'json',
                        data: data,
                    }).done(function (data) { //200
                        var $example = $("#selectcliente").select2();
                        $example.select2('destroy');
                        $example.append($('<option>', { //agrego los valores que obtengo de una base de datos
                            value: data.paciente[0].Cod_CP,
                            text: data.paciente[0].Nom_CP,
                            selected: true
                        }));
                        $example.select2(busquedaScript);
                        $('#CodCP').val(data.paciente[0].Cod_CP);
                        $("#tip_CP").val(data.tip_CP);
                        $('#txtfono').val(data.paciente[0].Tel_CP);
                        $('#txtcelu').val(data.paciente[0].Cel_CP);
                        $('#txtcorreo').val(data.paciente[0].Mail_CP);
                        $('#txtdireccion').val(data.paciente[0].Dir_CP);
                    }).fail(function () { ///aqca
                        // alert("Error");
                    });
                }

            });


            function cargarComprobantes(Tip_CP, cod_CP, cod_DOC) {
                var data = {'cod_CP': cod_CP, 'cod_DOC': cod_DOC, 'Tip_CP': Tip_CP};
                $.ajax({
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('ventas.resumen') }}",
                    dataType: 'json',
                    data: data,
                }).done(function (data) { //200
                    $('#datos').empty();
                    $.each(data['ventasresumen'], function (index, value) {
                        if (value.Cod_Mon === 'D') {
                            var check = "<input class='checkboxes' type='checkbox' name='checkboxes' id='checkboxes' value=" + value.Num_Vnt + " data-valor='" + value.Val_Vta_ME + "' data-igv='" + value.Igv_Vta_ME + "'data-tot='" + value.Tot_Vta_ME + "' data-tipdoc='" + value.Tip_Doc + "'data-coddoc='" + value.Cod_Doc + "'data-serie='" + value.Ser_Doc + "'data-numero='" + value.Num_Doc + "' data-fecha='" + value.Fec_Doc + "' data-codmon='" + value.Cod_Mon + "' data-tipocambio='" + value.Tip_Cam + "'>";
                            $.each(data['ventasnotas'], function (index, notas) {
                                if (notas.Cod_Doc_Ref === value.Cod_Doc && notas.Ser_Doc_Ref === value.Ser_Doc && notas.Num_Doc_Ref === value.Num_Doc) {
                                    check = '<label class="label label-primary"><small>' + notas.Nom_Con + '</small></label>';

                                }
                            });
                            var fecha = value.Fec_Doc;
                            fecha = fecha.substring(8, 10) + '-' + fecha.substring(5, 7) + '-' + fecha.substring(0, 4);
                            var markup = "<tr><th class='text-center'>" + check + "</th><td id ='coddoc' class='coddoc text-center' >" + value.Cod_Doc + "</td><td id ='valtipo' class='valtipo text-center'>" + value.Tip_Doc + "</td><td id ='seriecol' class='seriecol text-center'>" + value.Ser_Doc + "</td><td id ='numerocol' class='numerocol text-center'>" + value.Num_Doc + "</td><td id ='valfemic' class='valfemic text-center'>" + fecha + "</td><td class='text-center'>" + value.Nom_Mon + "</td><td class='text-right'>" + value.Val_Vta_ME + "</td><td class='text-right'>" + value.Igv_Vta_ME + "</td><td class='text-right'>" + value.Tot_Vta_ME + "</td><td class='text-center'><button class= 'btn btn-primary modificarbtn' id='btnModificar' name='btnModificar' type='button' data-NumVnt = " + value.Num_Vnt + "><span class='glyphicon glyphicon-search'></span></button></td></td></tr>";
                        } else {
                            var check = "<input class='checkboxes' type='checkbox' name='checkboxes' id='checkboxes' value=" + value.Num_Vnt + " data-valor='" + value.Val_Vta_MN + "' data-igv='" + value.Igv_Vta_MN + "'data-tot='" + value.Tot_Vta_MN + "' data-tipdoc='" + value.Tip_Doc + "'data-coddoc='" + value.Cod_Doc + "'data-serie='" + value.Ser_Doc + "'data-numero='" + value.Num_Doc + "' data-fecha='" + value.Fec_Doc + "' data-codmon='" + value.Cod_Mon + "' data-tipocambio='" + value.Tip_Cam + "'>";
                            $.each(data['ventasnotas'], function (index, notas) {
                                if (notas.Cod_Doc_Ref === value.Cod_Doc && notas.Ser_Doc_Ref === value.Ser_Doc && notas.Num_Doc_Ref === value.Num_Doc) {
                                    check = '<label class="label label-primary"><small>' + notas.Nom_Con + '</small></label>';

                                }
                            });
                            var fecha = value.Fec_Doc;
                            fecha = fecha.substring(8, 10) + '-' + fecha.substring(5, 7) + '-' + fecha.substring(0, 4);
                            var markup = "<tr><th class='text-center'>" + check + "</th><td id ='coddoc' class='coddoc text-center' >" + value.Cod_Doc + "</td><td id ='valtipo' class='valtipo text-center'>" + value.Tip_Doc + "</td><td id ='seriecol' class='seriecol text-center'>" + value.Ser_Doc + "</td><td id ='numerocol' class='numerocol text-center'>" + value.Num_Doc + "</td><td id ='valfemic' class='valfemic text-center'>" + fecha + "</td><td class='text-center'>" + value.Nom_Mon + "</td><td class='text-right'>" + value.Val_Vta_MN + "</td><td class='text-right'>" + value.Igv_Vta_MN + "</td><td class='text-right'>" + value.Tot_Vta_MN + "</td><td class='text-center'><button class= 'btn btn-primary modificarbtn' id='btnModificar' name='btnModificar' type='button' data-NumVnt = " + value.Num_Vnt + "><span class='glyphicon glyphicon-search'></span></button></td></td></tr>";
                        }
                        $('#datos').append(markup);

                    });
                }).fail(function () { ///aqca

                });
            }

            $('#tipdesc').on('change', function () {
                tipoConcepto();
            });

            function tipoConcepto() {
                var tipo = $('#tipdesc').val();
                if (tipo === '001') {
                    $('.tipoConcepto').hide();
                    var totalVenta = $('#totaltotal').val();
                    $('#txtMontoDesc').val(totalVenta);
                    $('#txtcant').val('1');
                    $('#txtIgv').val(0);
                    $('#txtprecio').val(0);
                    $('#txtvalor').val(0);
                    calculaMonto();
                } else {
                    $('.tipoConcepto').show();
                    $('#txtMontoDesc').val('');
                    $('#txtcant').val('');
                    $('#txtIgv').val('');
                    $('#txtprecio').val('');
                    $('#txtvalor').val('');
                }
            }


        });

    </script>
@endsection

