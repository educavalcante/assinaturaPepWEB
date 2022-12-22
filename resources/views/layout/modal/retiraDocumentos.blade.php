<div class="modal fade" id="modalretiraDocumentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Caso não reconheça esse documento,informe a justificatíva
                    abaixo !</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group col-md-12" hidden>
                    @csrf
                </div>

                <div class="form-group {{ $errors->has('idDoc')? 'has-error': '' }} col-md-12" hidden>
                    <label for="">idDoc</label>
                    <input type="number" class="form-control" id="idDoc" name="idDoc">
                    @if($errors->has('idDoc'))
                        <span class="help-block">
                            <strong>{{$errors->first('idDoc')}}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('justificativa') ? 'has-error': '' }} col-md-12">
                    <label for="Justificativa">Justificatíva</label>
                    <textarea rows="5" cols="5" type="text" inputmode="text" class="form-control" id="justificativa"
                              name="justificativa" placeholder="Informe a justificativa" maxlength="250"
                    required></textarea>

                        <span class="help-block">
                            <strong>{{$errors->first('justificativa')}}</strong>
                        </span>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="retirarDocs();" class="btn btn-primary">Retirar Documento</button>
            </div>
        </div>
    </div>
</div>
