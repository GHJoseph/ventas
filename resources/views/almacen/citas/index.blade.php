@extends('layouts.admin')
@section('contenido')

<div class="panel panel-default">

    <div class="panel-heading" style="background-color: #1fb5ad;">
        <h3 class="panel-title" style="color:#fff;"><b>CITAS</b></h3></br>
        <div class="row">            
            <div class="col-md-2">
                <button class="btn btn-default"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Calendario</button>
            </div>
            <div class="col-md-1">
                <label for="fecha">Fecha</label>
            </div>
            <div class="col-md-2">
                <input type='text' value="09/02/2015" name="fecha1" class="form-control" id="fecha" disabled>              
            </div>
            <div class="col-md-3">
                <input type="text" value="LUNES 09 de Febrero de 2015" id="fecha" size="30" class="form-control" disabled>  
            </div>
            <div class="col-md-1">
                <label for="doctor">Doctor</label>                
            </div>
            <div class="col-md-3">    
                <div class="form-group">                                         
                    <select name="tipAgenda" id="doctor" class="form-control">                                                                   
                       <option value="#">Seleccione un doctor</option>                                                                    
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
                <th>TIPO 3</th>
                <th>AJUSTE</th>
                <th>RESULTADO</th>                    
                <th>TIPO 3</th>
                <th>AJUSTE</th>
                <th>PRECIO</th>
            </tr>
        </thead>

        <tbody>
            
            <tr>                
                <td></td>                
                <td class="context-menu-one"></td>                 
                <td data-toggle="modal" data-target="#modal" role="button"></td>
                <td data-toggle="modal" data-target="#modal" role="button"></td>
                <td data-toggle="modal" data-target="#modal" role="button"></td>
                <td data-toggle="modal" data-target="#modal" role="button"></td>
                <td data-toggle="modal" data-target="#modal" role="button"></td>
                <td data-toggle="modal" data-target="#modal" role="button"></td>
                <td data-toggle="modal" data-target="#modal" role="button"></td>
                <td data-toggle="modal" data-target="#modal" role="button"></td>
                <td data-toggle="modal" data-target="#modal" role="button"></td>                
            </tr>
            
        </tbody>
        <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal">    
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
                            <input type="text" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="doctor">Nombre del Doctor</label>
                            <select name="tipAgenda" id="doctor" class="form-control">                                                                   
                                <option value="#">Seleccione un doctor</option>                                                                    
                            </select>                                    
                        </div> 
                        
                         <div class="form-group">
                            <label for="doctor">Especialidad</label>
                            <select name="tipAgenda" id="doctor" class="form-control">                                                                   
                                <option value="#">Seleccione una especialidad</option>                                                                    
                            </select>                                    
                        </div> 

                        <div class="form-group">
                            <label for="horaInicio">Hora de Inicio</label>
                            <input type="time" min="9:00" max="22:00" id="horaInicio" class="form-control" />                                                         
                        </div>
                        <div class="form-group">                            
                            <label for="horaInicio">Hora de Fin</label>
                            <input type="time" min="9:00" max="22:00" id="horaFin" class="form-control" /> 
                        </div>
                        <div class="form-group">                            
                            <label for="obsCita">Observción</label>
                            <textarea class="form-control" id="obsCita" rows="3"></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <a href=""><button type="button" class="btn btn-danger">Elegir</button></a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                   
                    </div>            
                </div>
            </div>  
        </div>
    </table>          
    <div class="panel-footer">
        <div class="row">   
            <button class="btn btn-primary">Pacientes</button>            
            <button class="btn btn-primary">Llamadas</button>            
            <button class="btn btn-primary">Salir</button>            
        </div>
    </div>
</div>

<script>
   $(function() {
        $.contextMenu({
            selector: '.context-menu-one', 
            callback: function(key, options) {
                var m = "clicked: " + key;
                window.console && console.log(m) || alert(m); 
            },
            items: {
                "edit": {name: "Modificar"},
                "cut": {name: "Eliminar"}                
            }
        });

        $('.context-menu-one').on('click', function(e){
            console.log('clicked', this);
        })    
    });
</script>


@endsection