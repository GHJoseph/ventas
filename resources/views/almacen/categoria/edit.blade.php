@extends('layouts.admin')
@section('contenido')
<div class="panel">
  <div class="panel-body">
    <div class="col-md-6">
      <h3>Editar Categoria:{{$categoria->nombre}}</h3>
      @if(count($errors)>0)
      <div class="alert alert-danger">
        <ul>
         @foreach($errors->all() as $error)
          <li> {{$error}} </li>
          @endforeach
        </ul>
      </div>
      @endif
        {!!Form::model($categoria,['method'=>'PATCH','route'=>['categoria.update',$categoria->idcategoria]])!!}
        {{Form::token()}}
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" class="form-control" value="{{$categoria->nombre}}" placeholder="Nombre..">
        </div>
        <div class="form-group">
          <label for="nombre">Descripción</label>
          <input type="text" name="descripcion" class="form-control" value="{{$categoria->descripcion}}" placeholder="Descripcion..">
        </div>
        <div class="form-group">
          <button class="btn btn-primary" type="submit">Guardar</button>
          <button class="btn btn-danger" type="reset">Cancelar</button>
        </div>
        
        
        {!!Form::Close()!!}

    </div>
  </div>
</div>

@endsection