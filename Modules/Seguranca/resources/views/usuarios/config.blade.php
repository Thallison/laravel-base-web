@extends('layouts.default')

@section('page-title', 'Usuários')

@section('content')
    
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Configuração Usuário') }}</h5>
    </div>
    <form action="{{ route('seguranca::usuarios.atualizaSenha') }}" method="POST" name="formUser">
        <div class="card-body ">
            @csrf

            <h6>Alterar senha</h6>
            <hr />

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class='form-group'>
                        <label class="form-label">{{ __('Senha Atual') }} : <span class="text-danger">*</span> </label>
                        <input class="form-control @error('senhaAtual') is-invalid @enderror" type="password" name="senhaAtual" required placeholder="{{ __('Senha Atual') }}" value="" />
                        @error('senhaAtual')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb3">
                <div class="col-md-4">
                    <div class='form-group'>
                        <label class="form-label">{{ __('Nova Senha') }} : <span class="text-danger">*</span> </label>
                        <input class="form-control @error('senha') is-invalid @enderror" type="password" name="senha" required placeholder="{{ __('Nova Senha') }}" value="" />
                        @error('senha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3 align-items-end">
                <div class="col-md-4">
                    <div class='form-group'>
                        <label class="form-label">{{ __('Confirmar Senha') }} : <span class="text-danger">*</span> </label>
                        <input class="form-control @error('repeat_senha') is-invalid @enderror" type="password" name="repeat_senha" required placeholder="{{ __('Confirmar Senha') }}" value="" />
                        @error('repeat_senha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button type="button" class="btn btn-warning gerarPassword">
                            <i class="fa-solid fa-lock"></i>{{ __('Gerar Senha') }}
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Atualizar Senha') }}
                <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.gerarPassword').forEach(btn => {
        btn.addEventListener('click', () => {
            
            const pass = generatePassword(10);

            document.querySelector('input[name="senha"]').value = pass;
            document.querySelector('input[name="repeat_senha"]').value = pass;

            const textoSenha = document.querySelector('.textoSenha');
            textoSenha.innerHTML = `
                <strong class="fw-semibold text-uppercase text-primary">
                    Senha gerada:
                </strong> ${pass}
            `;
            textoSenha.classList.remove('d-none');
        });
    });

    function generatePassword(length) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%';
        return Array.from({ length }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
    }

</script>
@endpush