@extends('layouts.default')

@section('page-title', 'Módulos')

@section('content')

@if (!$sistemas)
    <div class="alert alert-info alert-styled-left alert-dismissible alert-important">
        <span class="font-weight-semibold">Aviso</span>
            Para cadastrar um módulo é necessário ter pelo menos um sistema cadastrado,
        <a href="{{ route('seguranca::sistemas.index') }}" class="alert-link">Clique aqui para cadastrar um sistema.</a>
    </div>
@else
  
@can('Cadastrar Módulos') 
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Módulos') }}</h5>
    </div>
    <form action="{{ route('seguranca::modulos.store') }}" method="POST">
        <div class="card-body ">
            @csrf
            <div class="row">
                <div class="col">
                    <label>{{ __('Nome do Módulo:') }} <span class="text-danger">*</span></label>
                    <input class="form-control @error('mod_nome') is-invalid @enderror" type="text" name="mod_nome" required  placeholder="{{ __('Nome do modulo:') }}" value="{{ old('mod_nome') }}" />
                    @error('mod_nome')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col">
                    <label>{{ __('Nome do Sistema:') }} <span class="text-danger">*</span></label>
                    <x-seguranca::select-sistemas
                        :sistemas="$sistemas"
                        :selected="$model->sis_id ?? null"
                        class="filter"
                        required
                    />
                </div>
                <div class="col">
                    <label>{{ __('Nome do icone:') }}</label>
                    <input class="form-control @error('mod_icone') is-invalid @enderror" type="text" name="mod_icone" placeholder="{{ __('Nome do icone:') }}" value="{{ old('mod_icone') }}" />
                    @error('mod_icone')
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
        <h5 class="card-title">{{ __('Lista de Módulos') }}</h5>
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
                    data-url="{{ route('seguranca::modulos.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='mod_id'>
                                #
                            </th>
                            <th data-field='mod_nome'>
                                {{ $model->getAttributeLabel('mod_nome') }}
                            </th>
                            <th data-field='sis_nome'>
                                        {{ $model->getAttributeLabel('sis_nome') }}
                                    </th>
                            <th data-field='mod_icone'>
                                {{ $model->getAttributeLabel('mod_icone') }}
                            </th>
                            @can(['Editar Módulos', 'Excluir Módulos'])
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
@endif
@endsection

@push('scripts')
<script>
    /*adicionar botões de ações*/
    function TableActions(value, row, index) {

        let editar = excluir = '';
        let id = row['mod_id'];

        let urlEdit = "{{ route('seguranca::modulos.show', ['modulo' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('seguranca::modulos.destroy', ['modulo' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        @can('Editar Módulos')
        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarMod_'+ id +'" data-action="modal-editar-modulo" href="#" data-url="'+urlEdit+'" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        @endcan

        @can('Excluir Módulos')
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteMod_'+ id +'" data-action="excluir-modulo" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
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

    function openEdit(action) {
        let url = action.dataset.url;
        App.modal(url);//abrir modal com o formulário de edição
    }

    function editar(action) {
        /*Submeer formulario do modal*/
        App.submitForm({
            form: 'form[name="editModulo"]',
            modal: '#modal_default',
            table: 'gridTable'
        });
    }

    function excluirModulo(action) {
        App.confirm({
            title: "Excluir modulo",
            message: "Deseja realmente excluir este modulo?",
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
            case "modal-editar-modulo":
                openEdit(action);
            break;

            case "editar-modulo":
                editar(action);
            break;

            case "excluir-modulo":
                excluirModulo(action);
            break;
        }
    });
</script>
@endpush