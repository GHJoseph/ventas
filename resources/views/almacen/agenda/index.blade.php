@extends('layouts.main')
@section('contenido')
    @if($usuario_opciones[6]->Todos === 1)
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <div class="panel panel-default">

            <div class="panel-heading" style="background-color: #1fb5ad;">
                <h3 class="panel-title" style="color:#fff;"><b>CREAR AGENDA</b></h3></br>
                <div class="row">
                    <div class="col-md-2">
                        <button class="btn btn-default"><span class="glyphicon glyphicon-calendar"
                                                              aria-hidden="true"></span> Calendario
                        </button>
                    </div>
                    <div class="col-md-1">
                        <label for="fecha" style="color:#fff;">Fecha</label>
                    </div>
                    <div class="col-md-2">
                        <input type='text' value="09/02/2015" name="fecha1" class="form-control" id="fecha" disabled>
                    </div>
                    <div class="col-md-3">
                        <input type="text" value="LUNES 09 de Febrero de 2015" id="fecha" size="30" class="form-control"
                               disabled>
                    </div>
                    <div class="col-md-1">
                        <label for="doctor" style="color:#fff;">Doctor</label>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="tipAgenda" id="doctor" class="form-control">
                                <option value="#" selected>Seleccione un doctor</option>
                                @foreach($doctores as $doctor)
                                    <option value="{{$doctor->Cod_Per}}">{{$doctor->NOM_COM}}</option>
                                @endforeach
                            </select>
                        </div><!-- /input-group -->
                    </div>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>HORARIO</th>
                    <th>RESULTADO</th>
                    <th>TIPO 1</th>
                    <th>AJUSTE</th>
                    <th>RESULTADO</th>
                    <th>TIPO 2</th>
                    <th>AJUSTE</th>
                    <th>RESULTADO</th>
                    <th>TIPO 3</th>
                    <th>AJUSTE</th>
                    <th>PRECIO</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lapsos as $lapso)
                    <tr id="{{$lapso}}">
                        <td>{{$lapso}}</td>

                        @php ($cita = $citaUtil->getCita($lapso, '1'))
                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)"
                                id="Resultado-Con1">{{ $cita->Nom_Tip_Cita }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Resultado-Con1"></td>
                        @endif

                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)" id="Resultado-Con1">{{ $cita->Nom_Serv }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Tipo-Con1"></td>
                        @endif

                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)" id="Resultado-Con1">{{ $cita->Nom_Com }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Ajuste-Con1"></td>
                        @endif


                        @php ($cita = $citaUtil->getCita($lapso, '2'))
                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)"
                                id="Resultado-Con1">{{ $cita->Nom_Tip_Cita }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Resultado-Con2"></td>
                        @endif

                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)" id="Resultado-Con1">{{ $cita->Nom_Serv }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Tipo-Con2"></td>
                        @endif

                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)" id="Resultado-Con1">{{ $cita->Nom_Com }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Ajuste-Con2"></td>
                        @endif


                        @php ($cita = $citaUtil->getCita($lapso, '3'))
                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)"
                                id="Resultado-Con1">{{ $cita->Nom_Tip_Cita }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Resultado-Con3"></td>
                        @endif

                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)" id="Resultado-Con1">{{ $cita->Nom_Serv }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Tipo-Con3"></td>
                        @endif

                        @if($cita != null)
                            <td data-toggle="modal"
                                data-target="#modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}"
                                role="button" onclick="reCalcular(this)" id="Resultado-Con1">{{ $cita->Nom_Com }}</td>
                        @else
                            <td data-toggle="modal" data-target="#modal" role="button" onclick="calcular(this)"
                                id="Ajuste-Con3"></td>
                        @endif

                        <td class="context-menu-one" id="Precio"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>


            <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #1fb5ad;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" style="color:#fff;">Descripción de Cita</h4>

                        </div>
                        <form action="{{ url('almacen/agenda') }}" method="POST" id="formulario">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="doctor">Nombre del Terapista</label>
                                    <select name="doctor" id="doctor" class="form-control">
                                        <option value="#">Seleccione un doctor</option>
                                        @foreach($doctores as $doctor)
                                            <option value="{{$doctor->Cod_Per}}">{{$doctor->NOM_COM}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="paciente">Nombre del Paciente</label>
                                    <select name="paciente" id="doctor" class="form-control">
                                        <option value="#">Seleccione un paciente</option>
                                        @foreach($pacientes as $paciente)
                                            <option value="{{$paciente->Cod_Pac}}">{{$paciente->Nom_Com}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="panel panel-default">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Terapia</th>
                                            <th>Cantidad de Terapias</th>
                                            <th>Cantidad de Terapias Cita</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><input type="number" class="form-control"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group">
                                    <label for="codServ">Terapia</label>
                                    <select name="CodServ" id="doctor" class="form-control">
                                        <option value="#">Seleccione un tipo de terapia</option>
                                        @foreach($servicios as $servicio)
                                            <option value="{{$servicio->Cod_Serv}}">{{$servicio->Nom_Serv}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="CodTipCita">Tipo de Cita</label>
                                    <select name="CodTipCita" id="doctor" class="form-control">
                                        <option value="#">Seleccione un tipo de cita</option>
                                        @foreach($tiposCita as $tipo)
                                            <option value="{{$tipo->Cod_Tip_Cita}}">{{$tipo->Nom_Tip_Cita}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="horaInicio">Hora de Inicio</label>
                                    <select name="CodTerap" id="doctor" class="form-control">
                                        @foreach($lapsos as $lapso)
                                            <option value="{{$lapso}}">{{$lapso}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="horaFin">Hora de Fin</label>
                                    <select name="CodTerap" id="doctor" class="form-control">
                                        @foreach($lapsos as $lapso)
                                            <option value="{{$lapso}}">{{$lapso}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Recordatorio</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-1"><input type="checkbox" name="recordatorio"></div>
                                            <div class="col-md-11"><input type="email" class="form-control"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-5">
                                                <label class="checkbox-inline"><input type="checkbox"
                                                                                      value="">Atendido</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mensaje">Mensaje</label>
                                    <textarea name="mensaje" class="form-control" id="obsCita" rows="3"></textarea>
                                </div>
                                <input type="hidden" name="idCita" value="0">
                                <input type="hidden" name="modal" value="insertar">

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-submit">Crear cita</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            @foreach($citas as $cita)

                <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
                     id="modal-<?= str_replace(":", "", $cita->Nom_Fila) ?>-{{$cita->Nom_Colum}}">

                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #1fb5ad;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" style="color:#fff;">Descripción de Cita</h4>

                            </div>

                            <form action="{{ url('almacen/agenda') }}" method="POST" id="formulario-actualizar">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="doctor">Nombre del Terapista</label>
                                        <select name="doctor" id="doctor" class="form-control">
                                            <option value="{{$cita->Cod_Med}}">{{$cita->Nom_Doc}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="paciente">Nombre del Paciente</label>
                                        <select name="paciente" id="doctor" class="form-control">
                                            <option value="{{$cita->Cod_Pac}}">{{$cita->Nom_Pac}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="codServ">Terapia</label>
                                        <select name="CodServ" id="doctor" class="form-control">
                                            <option value="{{$cita->Cod_Terap}}">{{$cita->Nom_Serv}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="CodTipCita">Tipo de Cita</label>
                                        <select name="CodTipCita" id="doctor" class="form-control">
                                            @foreach($tiposCita as $tipo)
                                                <option value="{{$tipo->Cod_Tip_Cita}}">{{$tipo->Nom_Tip_Cita}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="consultorio">Numero de Consultorio</label>
                                        <select name="consultorio" id="consultorio" class="form-control">
                                            <option value="{{$cita->Num_Consul}}">
                                                Consultorio {{$cita->Num_Consul}}</option>
                                            <option value="1">Consultorio 1</option>
                                            <option value="2">Consultorio 2</option>
                                            <option value="3">Consultorio 3</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="horaInicio">Hora de Inicio</label>
                                        <select name="horaInicio" id="doctor" class="form-control">
                                            <option value="{{$cita->Nom_Fila}}">{{$cita->Nom_Fila}}</option>
                                            @foreach($lapsos as $lapso)
                                                <option value="{{$lapso}}">{{$lapso}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="horaFin">Hora de Fin</label>
                                        <select name="horaFin" id="doctor" class="form-control">
                                            @foreach($lapsos as $lapso)
                                                <option value="{{$lapso}}">{{$lapso}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Recordatorio</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-1"><input type="checkbox" name="recordatorio"></div>
                                                <div class="col-md-11"><input type="email" class="form-control"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-5">
                                                    <label class="checkbox-inline"><input type="checkbox" value="">Atendido</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mensaje">Mensaje</label>
                                        <textarea name="mensaje" class="form-control" id="obsCita" rows="3"></textarea>
                                    </div>
                                    <input type="hidden" name="idCita" value="{{ $cita->Id_Cita }}">
                                    <input type="hidden" name="modal" value="modificar">

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-submit">Actualizar cita</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endforeach

            <div class="panel-footer">
                <div class="row">
                    <button class="btn btn-primary">Pacientes</button>
                    <button class="btn btn-primary">Llamadas</button>
                    <button class="btn btn-primary">Salir</button>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            <b><i class="fa fa-warning"></i></b> Usted no tiene acceso a esta opción, comuniquese con el administrador
            para que le dé los permisos necesarios.
        </div>
    @endif
@endsection
@section('javascripts')
    <script>

        var columna;
        var fila;
        var col;
        var fil;

        function calcular(elemento) {
            debugger;
            columna = elemento.id.substring(elemento.id.length - 1, elemento.id.length);
            console.log(columna);
            fila = elemento.parentNode.id;
            console.log(fila);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".btn-submit").click(function (e) {

                e.preventDefault();

//    var paciente = $("input[name=paciente]").val();
//    var InicioCita = $("input[name=email]").val();
//    var FinalCita = $("input[name=email]").val();
//    var CodTerap = $("input[name=CodTerap]").val();

                $.ajax({
                    type: 'POST',
                    url: 'agenda',
                    data: $("#formulario").serialize() + "&columna=" + columna + "&fila=" + fila,
//            data: {columna: columna, fila: fila},
//        data: {paciente: paciente, InicioCita: InicioCita, FinalCita: FinalCita, CodTerap: CodTerap},
                    success: function (data) {
//            alert(data.success);
//                $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
                        $('#modal').modal('hide');
                        window.location.reload();
                    }
                });

            });
        }

        function reCalcular(elemento) {
            columna = elemento.id.substring(elemento.id.length - 1, elemento.id.length);
            console.log(columna);
            fila = elemento.parentNode.id;
            console.log(fila);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".btn-submit").click(function (e) {
                e.preventDefault();

//    var paciente = $("input[name=paciente]").val();
//    var InicioCita = $("input[name=email]").val();
//    var FinalCita = $("input[name=email]").val();
//    var CodTerap = $("input[name=CodTerap]").val();

                $.ajax({
                    type: 'POST',
                    url: 'agenda',
                    data: $("#formulario-actualizar").serialize(),
//            data: {columna: columna, fila: fila},
//        data: {paciente: paciente, InicioCita: InicioCita, FinalCita: FinalCita, CodTerap: CodTerap},
                    success: function (data) {
//            alert(data.success);
//                $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
                        //$('#modal').modal('hide');
                        $('#modal-' + fila + '-' + columna).modal('hide');
                        window.location.reload();
                    }
                });

            });
        }

    </script>
@endsection