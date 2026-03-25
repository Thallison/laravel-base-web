@extends('layouts.default')

@section('page-title', 'Sistemas')

@section('content')

@can('Cadastrar Sistemas')
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Sistema') }}</h5>
    </div>
    <form action="{{ route('seguranca::sistemas.store') }}" method="POST">
        <div class="card-body ">
            @csrf
            <div class="row">
                <div class="col">
                    <label>{{ __('Nome do sistema:') }} <span class="text-danger">*</span></label>
                    <input class="form-control @error('sis_nome') is-invalid @enderror" type="text" name="sis_nome" required  placeholder="{{ __('Nome do sistema:') }}" value="{{ old('sis_nome') }}" />
                    @error('sis_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col">
                    <label>{{ __('Nome do icone:') }}</label>
                    <input class="form-control @error('sis_icone') is-invalid @enderror type="text" name="sis_icone" placeholder="{{ __('Nome do icone:') }}" value="{{ old('sis_icone') }}" />
                    @error('sis_icone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Cadastrar') }}
                <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>
@endcan

<div class="card card-default" >
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Lista de Sistema') }}</h5>
    </div>

    <div class="card-body">
        <div id="" class="">
            <div class="">
                <table class="table"
                    id="gridTable"
                    data-toggle="{{ __(config('bootstraptable.toggle')) }}"
                    data-search="{{ __(config('bootstraptable.search')) }}"
                    data-pagination="{{ __(config('bootstraptable.pagination')) }}"
                    data-page-size="{{ __(config('bootstraptable.page-size')) }}"
                    data-page-list="{{ __(config('bootstraptable.page-list')) }}"
                    data-show-columns="{{ __(config('bootstraptable.show-columns')) }}"
                    data-locale="{{ __(config('app.locale')) }}"
                    data-show-export="{{ __(config('bootstraptable.show-export')) }}"
                    data-export-data-type="{{ __(config('bootstraptable.export-data-type')) }}"
                    data-export-types="{{ __(config('bootstraptable.export-types')) }}"
                    data-show-toggle="{{ __(config('bootstraptable.show-toggle')) }}"
                    data-show-fullscreen="{{ __(config('bootstraptable.show-fullscreen')) }}"
                    data-show-refresh="{{ __(config('bootstraptable.show-refresh')) }}"
                    data-url="{{ route('seguranca::sistemas.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='sis_id'>
                                #
                            </th>
                            <th data-field='sis_nome'>
                                {{ $model->getAttributeLabel('sis_nome') }}
                            </th>
                            <th data-field='sis_icone'>
                                {{ $model->getAttributeLabel('sis_icone') }}
                            </th>
                            
                            @canany(['Editar Sistemas', 'Excluir Sistema'])
                            <th data-formatter="TableActions" class="w-10">
                                {{ __('Ações') }}
                            </th>
                            @endcan
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /*adicionar botões de ações*/
    function TableActions(value, row, index) {

        let editar = excluir = '';
        let id = row['sis_id'];

        let urlEdit = "{{ route('seguranca::sistemas.show', ['sistema' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('seguranca::sistemas.destroy', ['sistema' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        @can('Editar Sistemas')
        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarSis_'+ id +'" data-action="modal-editar-sistema" href="#" data-url="'+urlEdit+'" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        @endcan
        
        @can('Excluir Sistema')
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteSis_'+ id +'" data-action="excluir-sistema" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
                +'<i class="bi bi-trash3-fill"></i>'
                +'</a>';
        @endcan
        
        return [
            '<div class="list-icons">',
            editar,
            excluir,
            '</div>'
        ].join('');

    }
   // document.addEventListener("DOMContentLoaded", function () {
    
       // alert('teste');
    
    //});

    function openEdit(action) {
        let url = action.dataset.url;
        App.modal(url);//abrir modal com o formulário de edição
    }

    function editar(action) {
        /*Submeer formulario do modal*/
        App.submitForm({
            form: 'form[name="editSistema"]',
            modal: '#modal_default',
            table: 'gridTable'
        });
    }

    function excluirSistema(action) {
        App.confirm({
            title: "Excluir sistema",
            message: "Deseja realmente excluir este sistema?",
            url: action.dataset.url,
            table: "gridTable"
        });
    }

     document.addEventListener("click", function(e){
        const action = e.target.closest("[data-action]");

        if(!action) return;
        e.preventDefault();

        const tipo = action.dataset.action;

        switch(tipo){
            case "modal-editar-sistema":
                openEdit(action);
            break;

            case "editar-sistema":
                editar(action);
            break;

            case "excluir-sistema":
                excluirSistema(action);
            break;
        }
    });
</script>
@endpush