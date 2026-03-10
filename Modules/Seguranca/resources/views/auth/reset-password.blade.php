@extends('layouts.auth')

@section('content')
<div class="login-box">
    <div class="login-logo">
    <b>Admin</b>LTE
    </div>
    <!-- /.login-logo -->
    <div class="card">
    @error('error_login')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
    <div class="card-body login-card-body">
        <p class="login-box-msg">Faça login para iniciar sua sessão</p>
        <form action="{{ route('password.update') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}" />
        <div class="input-group mb-3">
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            <input type="email" name="email" class="form-control" @error('email') is-invalid @enderror placeholder="email" />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="input-group mb-3">
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            <input type="password" name="password" class="form-control" @error('password') is-invalid @enderror placeholder="Password" />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="input-group mb-3">
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            <input type="password" name="password_confirmation" class="form-control" @error('password_confirmation') is-invalid @enderror placeholder="Confirmar Password" />
            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <!--begin::Row-->
        <div class="row">
            <!-- /.col -->
            <div class="col-12">
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Resetar Senha</button>
            </div>
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
        </form>
    </div>
    </div>
</div>
@endsection