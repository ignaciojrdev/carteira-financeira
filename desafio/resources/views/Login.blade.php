@extends('layouts.main')

@section('title', 'Login')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card" style="width: 100%; max-width: 400px;">
        <div class="card-header text-center">
            <h4>Login</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Exibir erros de validação -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Digite seu e-mail" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Digite sua senha" required>
                </div>

                <!--<div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Lembrar-me</label>
                </div>-->

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
        <div class="card-footer text-center">
            <p>Não tem uma conta? <a href="/Cadastro">Cadastre-se</a></p>
        </div>
    </div>
</div>
@endsection
