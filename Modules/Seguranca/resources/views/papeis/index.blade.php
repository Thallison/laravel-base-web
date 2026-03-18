@extends('layouts.default')

@section('page-title', 'Funcionalidades')

@section('content')

@if (!$privilegios)
    <div class="alert alert-info alert-styled-left alert-dismissible alert-important">
        <span class="font-weight-semibold">Aviso</span>
            Para cadastrar um papel é necessário ter pelo menos uma funcionalidade com privilégio cadastrado,
        <a href="{{ route('seguranca::funcionalidades.index') }}" class="alert-link">Clique aqui para cadastrar uma funcionalidade.</a>
    </div>
@else

<div class="card card-default" >
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Lista de Grupos') }}</h5>
        <div class="text-end">
            <a href="{{ route('seguranca::papeis.create') }}" class="btn btn-info"><i class="bi bi-plus"></i> {{ __('Cadastrar Grupo') }}</a>
            <a class="list-icons-item" data-action="collapse"></a>
        </div>
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
                    data-url="{{ route('seguranca::papeis.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='papel_id' data-sortable="true">
                                {{ $model->getAttributeLabel('papel_id') }}
                            </th>
                            <th data-field='papel_nome' data-sortable="true">
                                {{ $model->getAttributeLabel('papel_nome') }}
                            </th>
                            <th data-field='created_at' data-sortable="true">
                                {{ $model->getAttributeLabel('papel_dt_criacao') }}
                            </th>
                            <th data-field='updated_at' data-sortable="true">
                                {{ $model->getAttributeLabel('papel_dt_alteracao') }}
                            </th>
                            <th data-formatter="TableActions" class="w-10">
                                {{ __('Ações') }}
                            </th>
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
        let id = row['papel_id'];

        let urlEdit = "{{ route('seguranca::papeis.edit', ['papei' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('seguranca::papeis.destroy', ['papei' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarFunc_'+ id +'" href="'+urlEdit+'" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteFunc_'+ id +'" data-action="excluir-papel" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
                +'<i class="bi bi-trash3-fill"></i>'
                +'</a>';
        
        return [
            '<div class="list-icons">',
            editar,
            excluir,
            '</div>'
        ].join('');

    }

    function excluirPapel(action) {
        App.confirm({
            title: "Excluir grupo",
            message: "Deseja realmente excluir este grupo?",
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
            case "excluir-papel":
                excluirPapel(action);
            break;
        }
    });
</script>
@endpush