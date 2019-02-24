@extends('layouts.admin')
@section('contenido')
<div class="row">
  <div class="panel">
   <div class="panel-body">
    <div class="col-md-8">
      <h3>Listado de Categorias <a href="categoria/create"><button class="btn">Nuevo</button></a></h3>
      @include('almacen.categoria.search')
    </div>
    <div class="col-md-12">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <th>Id</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Opciones</th>
        </thead>
        <tbody>
         @foreach($categorias as $cat)
          <tr>
            <td>{{$cat->idcategoria}}</td>
            <td>{{$cat->nombre}}</td>
            <td>{{$cat->descripcion}}</td>
            <td>
              <a href="{{URL::action('CategoriaController@edit',$cat->idcategoria)}}"><button class="btn btn-info">Editar</button></a>
              <a href="" data-target="#modal-delete-{{$cat->idcategoria}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
            </td>
          </tr>
          @include('almacen.categoria.modal')
          
          @endforeach
        </tbody>
      </table>
      {{$categorias->render()}}
    </div>
  </div>
    </div>
  </div>
</div>
@endsection