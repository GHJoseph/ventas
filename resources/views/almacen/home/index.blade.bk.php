@extends('layouts.admin')
@section('contenido')

<div class="container">

    <div class="page-header">
        <h2 class="title">Bienvenido</h2>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Agenda</b></h3>        
                </div>
                <div class="panel-body">
                    @if (count($agendaExiste) != 0)
                    <a href="{{url('almacen/citas')}}"><img src="{{asset('images/agenda.png')}}" class="img-responsive"/></a>
                    @else
                    <a href="" data-target="#modal" data-toggle="modal"><img src="{{asset('images/agenda.png')}}" class="img-responsive"/></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Pacientes</b></h3>        
                </div>
                <div class="panel-body">
                    <a href="{{url('almacen/paciente')}}"><img src="{{asset('images/pacientes.png')}}" class="img-responsive"/></a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Artículos</b></h3>        
                </div>
                <div class="panel-body">
                    <a href="{{url('almacen/articulo')}}"><img src="{{asset('images/medicamentos.png')}}" class="img-responsive"/></a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #1fb5ad;">
                    <h3 class="panel-title" style="color:#fff;"><b>Ventas</b></h3>        
                </div>
                <div class="panel-body">
                    <img src="{{asset('images/ventas.jpg')}}" class="img-responsive"/>
                </div>
            </div>
        </div>

    </div>

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
                        <a href="{{ url('almacen/home/agendaIntervalo', ['CodTipAgen' => $tipos->Cod_Tip_Agen])}}">                                
                        <button type="submit" class="btn btn-default">Elegir</button>                        
                        </a>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                   
                    </div>            
                </div>
                
            </div>          
    </div>
</div>

@endsection