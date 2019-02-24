@extends('layouts.admin')
@section('contenido')

<form action="{{url('almacen/agenda/crearAgenda/')}}" method="POST">
<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal">    

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1fb5ad;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>                
                <h4 class="modal-title" style="color:#fff;">¿Desea crear una agenda?</h4>                

            </div>            
            <div class="modal-body">

                <div class="form-group">
                    <label for="CodRub">Tipos de agenda</label>
                    <select name="CodTipAgen" id="tipAgenda" class="form-control"> 
                        <option value="#">-- Seleccione un tipo de Agenda --</option>                                         
                        @foreach($tiposAgen as $tipos)                                                                                            
                        <option value="{{$tipos->Cod_Tip_Agen}}">{{$tipos->NOM_LIS}}</option>                                                                     
                        @endforeach                                
                    </select>                                    
                </div> 
            </div>
            <div class="modal-footer">                
                <button type="submit" class="btn btn-default">Elegir</button>                                        
                <a href="{{ url('almacen/home')}}">
                    <button type="button" class="btn btn-primary Insertar" title="Registrar"><span class="glyphicon glyphicon-floppy-saved"></span> Cerrar </button> 
                </a>
            </div>            
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>          
</div>
</form>

<script>
    $(document).ready(function ()
    {
        $("#modal").modal("show");
    });
</script>

@endsection