<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$art->Cod_Art}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1fb5ad;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:#fff;">Eliminar Articulo</h4>
            </div>
            <div class="modal-body">
                <p>Realmente desea eliminar el articulo <b>{{$art->Nom_Art}}</b></p>
            </div>
            <div class="modal-footer">
                <a href="{{ url('almacen/articulo/eliminar', ['CodArt' => $art->Cod_Art]) }}"><button type="button" class="btn btn-danger">Eliminar</button></a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                   
            </div>
        </div>
    </div>
</div>