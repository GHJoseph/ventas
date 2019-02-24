@extends('layouts.admin')
@section('contenido')

<div class="panel panel-primary">
    <a href="" data-target="#modal" data-toggle="modal">
        <button class="btn btn-danger">Ver Día</button>
    </a>
    
    <div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal">    

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1fb5ad;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @if (count($agendas) != 0)
                @foreach($agendas as $agenda)
                <h4 class="modal-title" style="color:#fff;">Agenda {{$agenda->Num_Agen}}</h4>                
                @endforeach
                @else                 
                <h4 class="modal-title" style="color:#fff;">Elegir un tipo de agenda</h4>                
                @endif
            </div>
            @if (count($agendas) != 0)
            <div class="modal-body">
                <a href=""><buttom class="btn btn-primary">Ver agenda</buttom></a>
            </div>
            @else
            <div class="modal-body">
                
                <div class="form-group">
                        <label for="CodRub">Tipos de agenda</label>
                        <select name="tipAgenda" id="tipAgenda" class="form-control"> 
                            @foreach($tipos as $tipo)                                        
                            <option value="{{$tipo->Cod_Tip_Agen}}">{{$tipo->Nom_Tip_Agen}}</option>                                         
                            @endforeach
                        </select>                                    
                    </div> 
            </div>
            <div class="modal-footer">
                <a href="{{ url('almacen/agenda/agendaIntervalo', ['intervalo' => '15']) }}"><button type="button" class="btn btn-danger">Elegir</button></a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                   
            </div>
            @endif
        </div>
    </div>
</div>   
    
</div>

@endsection