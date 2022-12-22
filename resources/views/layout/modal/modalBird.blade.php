<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Digite abaixo o código gerado pelo aplicativo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-6">
                    <label for="inputAddress">Código</label>
                    <input type="password" inputmode="numeric" class="form-control" id="codigo" name="codigo"
                           placeholder="Informe o bird id"
                           minlength="10" maxlength="10" autofocus>
                </div><br>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="validarBird();" class="btn btn-primary">Autenticar</button>
            </div>
        </div>
    </div>
</div>
