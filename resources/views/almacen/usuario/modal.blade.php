<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
     id="modal-delete-{{$usu->Cod_Usu}}">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1fb5ad;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:#fff;">Eliminar Usuario</h4>
            </div>
            <div class="modal-body">
                <p>Realmente desea eliminar al usuario <b>{{$usu->Nom_Usu}}</b> de <b>{{$usu->Nom_Per}}</b></p>
            </div>
            <div class="modal-footer">
                {{ Form::open(array('url' => 'usuarios/' . $usu->Cod_Usu)) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('Eliminar', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>

</div>