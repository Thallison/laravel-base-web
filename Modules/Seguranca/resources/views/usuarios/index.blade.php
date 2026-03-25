@extends('layouts.default')

@section('page-title', 'Usuários')

@section('content')
    
<div class="card card-default" >
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{ __('Lista de Sistema') }}</h5>

        <div class="text-end">
            @can('Cadastrar usuário')
                <a href="{{ route('seguranca::usuarios.create') }}" class="btn btn-info"><i class="bi bi-plus"></i> {{ __('Cadastrar Usuários') }}</a>
            @endcan
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
                    data-url="{{ route('seguranca::usuarios.index') }}"
                    data-side-pagination="{{ __(config('bootstraptable.data-side-pagination')) }}" >
                    <thead>
                        <tr>
                            <th data-field='usr_id' data-sortable="true">
                                {{ $model->getAttributeLabel('usr_id') }}
                            </th>
                            <th data-field='usr_name' data-sortable="true">
                                {{ $model->getAttributeLabel('usr_name') }}
                            </th>
                            <th data-field='usr_login' data-sortable="true">
                                {{ $model->getAttributeLabel('usr_login') }}
                            </th>
                            <th data-field='email' data-sortable="true">
                                {{ $model->getAttributeLabel('email') }}
                            </th>
                            <th data-field='usr_status' data-sortable="true" data-formatter="tipoMensagem">
                                {{ $model->getAttributeLabel('usr_status') }}
                            </th>
                            <th data-field='usr_dt_criacao'>
                                {{ $model->getAttributeLabel('usr_dt_criacao') }}
                            </th>
                            <th data-field='usr_dt_alteracao' data-sortable="true">
                                {{ $model->getAttributeLabel('usr_dt_alteracao') }}
                            </th>
                            <th data-field='usr_dt_ultimo_acesso' data-sortable="true">
                                {{ $model->getAttributeLabel('usr_dt_ultimo_acesso') }}
                            </th>
                            @canany(['Editar usuário', 'Excluir usuário'])
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

    function tipoMensagem (value, row, index)
    {
        let msg;
        switch (value) {
            case 1:
                msg = '<span class="badge bg-success">Ativo</span>';
                break;
            case 0:
                msg = '<span class="badge bg-danger">Inativo</span>';
                break;
            default:
                msg = '<span class="badge"> </span>';
                break;
        }

        return msg;
    }

    /*adicionar botões de ações*/
    function TableActions(value, row, index) {

        let editar = excluir = '';
        let id = row['usr_id'];

        let urlEdit = "{{ route('seguranca::usuarios.edit', ['usuario' => ':id']) }}";
        urlEdit = urlEdit.replace(":id", id);

        let urlDel = "{{ route('seguranca::usuarios.destroy', ['usuario' => ':id']) }}";
        urlDel = urlDel.replace(":id", id);

        @can('Editar usuário')
        editar = '<a class="btn btn-outline-info btn-sm"'
                    +'id="editarUsuario_'+ id +'" href="'+urlEdit+'" title="{{ __('Editar') }}" >'
                +'<i class="bi bi-pencil-square"></i>'
                +'</a> ';
        @endcan
        
        @can('Excluir usuário')
        excluir = '<a class="btn btn-outline-danger btn-sm"'
                    +'data-method="DELETE"'
                    +'id="deleteUsr_'+ id +'" data-action="excluir-usuario" data-table="gridTable" href="#" data-url="'+urlDel+'" title="{{ __('Excluir') }}" >'
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
            form: 'form[name="editSistema"]',
            modal: '#modal_default',
            table: 'gridTable'
        });
    }

    function excluirUsuario(action) {
        App.confirm({
            title: "Excluir Usuário",
            message: "Deseja realmente excluir este usuário?",
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

            case "excluir-usuario":
                excluirUsuario(action);
            break;
        }
    });
</script>
@endpush