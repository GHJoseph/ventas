<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal"> 
    <form action="{{ url('almacen/agenda') }}" method="POST" id="formulario">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #1fb5ad;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                
                    <h4 class="modal-title" style="color:#fff;">Descripción de Cita</h4>                

                </div>            
                <div class="modal-body">

                    <div class="form-group">
                        <label for="paciente">Nombre del paciente</label>
                        <input type="text" name="paciente" class="form-control" placeholder="Ingrese el nombre del paciente">
                    </div>

                    <div class="form-group">
                        <label for="doctor">Nombre del Doctor</label>
                        <select name="doctor" id="doctor" class="form-control">                                                                   
                            <option value="#">Seleccione un doctor</option>
                            @foreach($doctores as $doctor)
                            <option value="{{$doctor->Cod_Per}}">{{$doctor->NOM_COM}}</option>
                            @endforeach
                        </select>                                    
                    </div> 

                    <div class="form-group">
                        <label for="codTerap">Especialidad</label>
                        <select name="CodTerap" id="doctor" class="form-control">                                                                   
                            <option value="#">Seleccione una especialidad</option>                                                                    
                            @foreach($servicios as $servicio)
                            <option value="{{$servicio->Cod_Serv}}">{{$servicio->Nom_Serv}}</option>
                            @endforeach
                        </select>                                    
                    </div> 

                    <div class="form-group">
                        <label for="horaInicio">Hora de Inicio</label>
                        <input name="InicioCita" type="time" min="9:00" max="22:00" id="horaInicio" class="form-control" />                                                         
                    </div>
                    <div class="form-group">                            
                        <label for="horaFin">Hora de Fin</label>
                        <input name="FinalCita" type="time" min="9:00" max="22:00" id="horaFin" class="form-control" /> 
                    </div>
                    <div class="form-group">                            
                        <label for="obsCita">Observación</label>
                        <textarea name="ObsCita" class="form-control" id="obsCita" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-submit">Crear cita</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                   
                </div>            
            </div>
        </div> 
    </form>
</div> 

<script>

var NomColum;
var NomFila;

function calcular(elemento)
{
    NomColum = elemento.id;
    NomFila = elemento.parentNode.id;
}

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
        data: $("#formulario").serialize(),
//        data: {NomColum: NomColum, NomFila: NomFila},
//        data: {paciente: paciente, InicioCita: InicioCita, FinalCita: FinalCita, CodTerap: CodTerap},
        success: function (data) {
//            alert(data.success);
            $("#respuesta").html(data); // Mostrar la respuestas del script PHP.
        }
    });

});
</script>