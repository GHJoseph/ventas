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
                        <select name="tipAgenda" id="tipAgenda" class="form-control"> 
                            @foreach($tipos as $tipo)                                        
                            <option value="{{$tipo->Cod_Tip_Agen}}">{{$tipo->Nom_Tip_Agen}}</option>                                         
                            @endforeach
                        </select>                                    
                    </div> 
            </div>
            <div class="modal-footer">
                <a href=""><button type="button" class="btn btn-danger">Elegir</button></a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                   
            </div>            
        </div>
    </div>         