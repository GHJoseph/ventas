<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$cliente->Cod_CP}}">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1fb5ad;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:#fff;">Eliminar Cliente</h4>
            </div>
            <div class="modal-body">
                <p>Realmente desea eliminar al cliente <b>{{$cliente->Nom_CP}}</b></p>
            </div>
            <div class="modal-footer">
                <a href="{{ url('almacen/cliente/eliminar', ['CodEmp' => '01', 'CodCP' => $cliente->Cod_CP,'Usuario' => '01', 'Fecha' => '2018-02-22 20:33:22', 'Operacion' => 'E']) }}">
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                   
            </div>
        </div>
    </div>
    
</div>