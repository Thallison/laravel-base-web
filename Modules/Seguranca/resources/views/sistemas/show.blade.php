<div id="modal_default" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('seguranca::sistemas.update',  ['sistema' => $dados->sis_id] )}}" name='editSistema' method="POST" class="form-validate-jquery">
                @csrf
                @method('PUT')
                <input type="hidden" name="_dataType" value="json" />
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Editar Sistema') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                </div>

                <div class="modal-body">
                    <div class="bootstrap-duallistbox-container row moveonselect">
                        <div class="box1 col-md-6">
                            <label>{{ __('Nome do sistema:') }} <span class="text-danger">*</span></label>
                            <input class="filter form-control @error('sis_nome') is-invalid @enderror" type="text" name="sis_nome" id="sis_nome" required  placeholder="{{ __('Nome do sistema:') }}" value="{{ $dados->sis_nome }}" />
                            @error('sis_nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="box2 col-md-6">
                            <label>{{ __('Nome do icone:') }}</label>
                            <input class="filter form-control @error('sis_icone') is-invalid @enderror type="text" name="sis_icone" placeholder="{{ __('Nome do icone:') }}" value="{{ $dados->sis_icone }}" />
                            @error('sis_icone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Fechar') }}</button>
                    <button type="button" data-action="editar-sistema" class="btn btn-primary">{{ __('Editar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>