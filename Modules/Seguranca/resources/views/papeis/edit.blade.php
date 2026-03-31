@extends('layouts.default')

@section('page-title', 'Grupos de acesso')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card" >
            <div class="card-header header-elements-inline">
                <h5 class="card-title">{{ __('Editar Grupo') }}</h5>
                <div class="text-end">
                    <a href="{{ route('seguranca::papeis.index') }}" class="btn btn-info"><i class="bi bi-arrow-left"></i> {{ __('Listar Grupos') }}</a>
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('seguranca::papeis.update', $dados->papel_id) }}" method="POST" id="formPapel">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class='form-group'>
                                <label class="form-label">{{ __($model->getAttributeLabel('papel_nome')) }} : <span class="text-danger">*</span></label>
                                <input class="form-control @error('papel_nome') is-invalid @enderror" type="text" name="papel_nome" required  placeholder="{{ __($model->getAttributeLabel('papel_nome')) }}" value="{{ $dados->papel_nome }}" />
                                @error('papel_nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="card border-grey"">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">{{ __('Dependências do grupo') }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="nav nav-tabs flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach ($sistemas as $i => $sistema)
                                        @php $selected = $i == 0 ? "true" : "false" @endphp
                                        @php $active = $i == 0 ? 'active' : '' @endphp
                                        <button class="nav-link {{ $active }}" id="tabSis{{ $sistema->sis_id }}" data-bs-toggle="pill" data-bs-target="#tabSis{{ $sistema->sis_id }}" type="button" role="tab" aria-controls="tabSis{{ $sistema->sis_id }}" aria-selected="{{ $selected }}">{{ $sistema->sis_nome }}</button>
                                    @endforeach
                                </div>

                                <div class="tab-content">
                                    @foreach ($sistemas as $i => $sistema)
                                        @php $active = $i == 0 ? 'active' : '' @endphp
                                        @php $show = $i == 0 ? 'show' : '' @endphp
                                        <div class="tab-pane fade {{ $show }} {{ $active }}" id="tabSis{{ $sistema->sis_id }}" role="tabpanel" aria-labelledby="tabSis{{ $sistema->sis_id }}-tab" tabindex="0">
                                            @forelse ($modulosSistema['func'][$sistema->sis_id] as $modulo )
                                            <div class="d-flex flex-column gap-2">
                                            <!-- ITEM 1 -->
                                                <div class=" mb-3">
                                                    <button class="btn btn-secondary w-100 text-start"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapsible-modulo{{ $modulo->mod_id }}" type="button">
                                                    {{ $modulo->mod_nome }}
                                                    </button>

                                                    <div class="collapse mt-1" id="collapsible-modulo{{ $modulo->mod_id }}">
                                                        <div class="card card-body">
                                                        @forelse ($funcPaiModulos['func'][$modulo->mod_id] as $funcPai)
                                                            <div class="d-flex flex-column gap-2">
                                                            <!-- ITEM 1 -->
                                                                <div class="mb-3">
                                                                    <button class="btn btn-secondary w-100 text-start"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#collapsible-funcPai{{ $funcPai->func_id }}" type="button">
                                                                    {{ $funcPai->func_label }}
                                                                    </button>

                                                                    <div class="collapse mt-1" id="collapsible-funcPai{{ $funcPai->func_id }}">
                                                                        <div class="card card-body">
                                                                        @forelse ($funcFilhasN1['func'][$funcPai->func_id] as $func1)
                                                                            <div class="d-flex flex-column gap-2">
                                                                            <!-- funcFilhasN1 -->
                                                                                <div class=" mb-3">
                                                                                    <button class="btn btn-secondary w-100 text-start"
                                                                                            data-bs-toggle="collapse"
                                                                                            data-bs-target="#collapsible-func1{{ $func1->func_id }}" type="button">
                                                                                    {{ $func1->func_label }}
                                                                                    </button>

                                                                                    <div class="collapse mt-1" id="collapsible-func1{{ $func1->func_id }}">
                                                                                        <div class="card card-body">
                                                                                        @forelse ($funcFilhasN2['func'][$func1->func_id] as $func2)
                                                                                            <div class="d-flex flex-column gap-2">
                                                                                            <!-- funcFilhasN2 -->
                                                                                                <div class=" mb-3">
                                                                                                    <button class="btn btn-secondary w-100 text-start"
                                                                                                            data-bs-toggle="collapse"
                                                                                                            data-bs-target="#collapsible-func2{{ $func2->func_id }}" type="button">
                                                                                                    {{ $func2->func_label }}
                                                                                                    </button>

                                                                                                    <div class="collapse mt-1" id="collapsible-func2{{ $func2->func_id }}">
                                                                                                        <div class="card card-body">
                                                                                                        @forelse ($funcFilhasN3['func'][$func2->func_id] as $func3)
                                                                                                            <div class="d-flex flex-column gap-2">
                                                                                                            <!-- funcFilhasN3 -->
                                                                                                                <div class=" mb-3">
                                                                                                                    <button class="btn btn-secondary w-100 text-start"
                                                                                                                            data-bs-toggle="collapse"
                                                                                                                            data-bs-target="#collapsible-func3{{ $func3->func_id }}" type="button">
                                                                                                                    {{ $func3->func_label }}
                                                                                                                    </button>

                                                                                                                    <div class="collapse mt-1" id="collapsible-func3{{ $func3->func_id }}">
                                                                                                                        <div class="card card-body">
                                                                                                                        @forelse ($funcFilhasN4['func'][$func3->func_id] as $func4)
                                                                                                                            <div class="d-flex flex-column gap-2">
                                                                                                                            <!-- funcFilhasN4 -->
                                                                                                                                <div class=" mb-3">
                                                                                                                                    <button class="btn btn-secondary w-100 text-start"
                                                                                                                                            data-bs-toggle="collapse"
                                                                                                                                            data-bs-target="#collapsible-func4{{ $func4->func_id }}" type="button">
                                                                                                                                    {{ $func4->func_label }}
                                                                                                                                    </button>

                                                                                                                                    <div class="collapse mt-1" id="collapsible-func4{{ $func4->func_id }}">
                                                                                                                                        <div class="card card-body">
                                                                                                                                            <ul class="list-group">
                                                                                                                                                @forelse ($funcFilhasN4['priv'][$func3->func_id] as $privilegio)
                                                                                                                                                    <li class="list-group-item">
                                                                                                                                                        <input type="checkbox" class="form-check-input me-1" name="privilegios[]" value="{{ $privilegio->priv_id }}" <?= (isset($subPrivIds) && in_array($privilegio->priv_id, $subPrivIds)) ? 'checked' : '' ?> />
                                                                                                                                                        <label class="form-check-label" for="checkbox-{{ $privilegio->priv_id }}">{{ $privilegio->priv_label }}</label>
                                                                                                                                                    </li>
                                                                                                                                                @empty
                                                                                                                                                    <h6 class='ms-4'> Nenhum privilégio cadastrado a essa funcionalidade.</h6>
                                                                                                                                                @endforelse
                                                                                                                                            </ul>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        @empty
                                                                                                                            <ul class="list-group">
                                                                                                                            @forelse ($funcFilhasN4['priv'][$func3->func_id] as $privilegio)
                                                                                                                                <li class="list-group-item">
                                                                                                                                    <input type="checkbox" class="form-check-input me-1" name="privilegios[]" value="{{ $privilegio->priv_id }}" <?= (isset($subPrivIds) && in_array($privilegio->priv_id, $subPrivIds)) ? 'checked' : '' ?> />
                                                                                                                                    <label class="form-check-label" for="checkbox-{{ $privilegio->priv_id }}">{{ $privilegio->priv_label }}</label>
                                                                                                                                </li>
                                                                                                                            @empty
                                                                                                                                <h6 class='ms-4'> Nenhum privilégio cadastrado a essa funcionalidade.</h6>
                                                                                                                            @endforelse
                                                                                                                            </ul>
                                                                                                                        @endforelse
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        @empty
                                                                                                            <ul class="list-group">
                                                                                                            @forelse ($funcFilhasN3['priv'][$func2->func_id] as $privilegio)
                                                                                                                <li class="list-group-item">
                                                                                                                    <input type="checkbox" class="form-check-input me-1" name="privilegios[]" value="{{ $privilegio->priv_id }}" <?= (isset($subPrivIds) && in_array($privilegio->priv_id, $subPrivIds)) ? 'checked' : '' ?> />
                                                                                                                    <label class="form-check-label" for="checkbox-{{ $privilegio->priv_id }}">{{ $privilegio->priv_label }}</label>
                                                                                                                </li>
                                                                                                            @empty
                                                                                                                <h6 class='ms-4'> Nenhum privilégio cadastrado a essa funcionalidade.</h6>
                                                                                                            @endforelse
                                                                                                            </ul>
                                                                                                        @endforelse
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        <!-- ITEM 1 -->
                                                                                        @empty
                                                                                            <ul class="list-group">
                                                                                            @forelse ($funcFilhasN2['priv'][$func1->func_id] as $privilegio)
                                                                                                <li class="list-group-item">
                                                                                                    <input type="checkbox" class="form-check-input me-1" name="privilegios[]" value="{{ $privilegio->priv_id }}" <?= (isset($subPrivIds) && in_array($privilegio->priv_id, $subPrivIds)) ? 'checked' : '' ?> />
                                                                                                    <label class="form-check-label" for="checkbox-{{ $privilegio->priv_id }}">{{ $privilegio->priv_label }}</label>
                                                                                                </li>
                                                                                            @empty
                                                                                                <h6 class='ms-4'> Nenhum privilégio cadastrado a essa funcionalidade.</h6>
                                                                                            @endforelse
                                                                                            </ul>
                                                                                        @endforelse
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @empty
                                                                            <ul class="list-group">
                                                                            @forelse ($funcFilhasN1['priv'][$funcPai->func_id] as $privilegio)
                                                                                <li class="list-group-item">
                                                                                    <input type="checkbox" class="form-check-input me-1" name="privilegios[]" value="{{ $privilegio->priv_id }}" <?= (isset($subPrivIds) && in_array($privilegio->priv_id, $subPrivIds)) ? 'checked' : '' ?> />
                                                                                    <label class="form-check-label" for="checkbox-{{ $privilegio->priv_id }}">{{ $privilegio->priv_label }}</label>
                                                                                </li>
                                                                            @empty
                                                                                <h6 class='ms-4'> Nenhum privilégio cadastrado a essa funcionalidade.</h6>
                                                                            @endforelse
                                                                            </ul>
                                                                        @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                        <h6 class='ms-4'> Módulo <b>{{ $modulo->mod_nome }}</b> não possui funcionalidade cadastrada.</h6>
                                                        @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @empty
                                                <h6 class='ms-4'> Sistema <b>{{ $sistema->sis_nome }}</b> não possui módulo cadastrado.</h6>
                                            @endforelse
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">{{ __('Editar') }}
                                    <i class="bi bi-floppy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('#formPapel');

        form.addEventListener('submit', (e) => {
            const privs = document.querySelectorAll("input[name='privilegios[]']:checked").length;
            if (!privs) {
                e.preventDefault(); // impede envio
                // substituto do $.alert
                App.message('Marque no mínimo um privilégio.', 'warning');
            }
        });
    });
</script>
@endpush
