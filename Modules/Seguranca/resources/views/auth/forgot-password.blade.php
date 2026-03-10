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
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('password.email') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            <input type="email" name="email" class="form-control" @error('email') is-invalid @enderror placeholder="email" />
            @error('email')
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
                <button type="submit" class="btn btn-primary">Enviar link reset senha</button>
            </div>
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
        </form>
        <div class="mt-2 text-center">
        <p class="mb-1"><a href="{{ route('login') }}">Voltar ao login</a></p>
        </div>
    </div>
    </div>
</div>
@endsection