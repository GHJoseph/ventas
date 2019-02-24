<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$serv->Cod_Serv}}">    

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1fb5ad;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:#fff;">Eliminar Servicio</h4>
            </div>
            <div class="modal-body">
                <p>Realmente desea eliminar el servicio <b>{{$serv->Nom_Serv}}</b></p>
            </div>
            <div class="modal-footer">
                <a href="{{ url('almacen/servicio/eliminar', ['CodEmp' => '01', 'CodArt' => $serv->Cod_Serv,'Usuario' => '01', 'Fecha' => '2018-02-22 20:33:22', 'Operacion' => 'E']) }}">
                    <button type="button" class="btn btn-danger">Eliminar</button>
                </a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                   
            </div>
        </div>
    </div>
    
</div>