@extends('layouts.main')
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
                @if (count($agendaExiste) != 0)
                <a href="{{url('almacen/agenda')}}"><img src="{{asset('images/agenda.png')}}" class="img-responsive"/></a>
                @else
                <a href="{{ url('almacen/agenda/crearAgenda', ['codEmp' => '01', 'codLoc' => '01', 'usuario' => '01', 'fecha' => '2018']) }}">
                    <img src="{{asset('images/agenda.png')}}" class="img-responsive"/>
                </a>
                @endif
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
                    <a href="{{url('almacen/facturacion')}}"><img src="{{asset('images/ventas.jpg')}}" class="img-responsive"/></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection