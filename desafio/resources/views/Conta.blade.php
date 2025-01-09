@extends('layouts.main')

@section('title', 'Conta Bancária')

@section('content')

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Minhas Contas Bancárias</h1>
        
        <form action="{{ route('conta.criar') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-info btn-sm">Cadastrar Nova Conta</button>
        </form>
    </div>

    @if(sizeof($contas) == 0)
        <div class="alert alert-info text-center">
            Não existem contas cadastradas.
        </div>
    @else
        <div class="list-group">
            @foreach($contas as $conta)
                <div class="list-group-item d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Código da Conta: {{ $conta->conta_id }}</h5>
                            <p><strong>Saldo Atual:</strong> R$ {{ number_format($conta->saldo, 2, ',', '.') }}</p>
                        </div>

                        <div>
                            <!-- Botões de Ação -->
                            <button class="btn btn-success btn-sm btn-transferir" data-id="{{ $conta->conta_id }}">Transferir</button>
                            <button class="btn btn-success btn-sm btn-depositar" data-id="{{ $conta->conta_id }}">Depositar</button>
                            <a href="{{ route('transferencia.desfazer', ['conta_id' => $conta->conta_id]) }}" class="btn btn-warning btn-sm">Operações</a>
                        </div>
                    </div>

                    <!-- Formulário de depósito -->
                    <form action="{{ route('transferencia.depositar') }}" method="POST" class="deposito-form" style="display: none;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $conta->conta_id }}">
                        <h4>Depositar R$</h4>
                        <div class="d-flex gap-2">
                            <input type="number" name="valor" placeholder="Informe o valor do depósito" class="form-control form-control-sm" step="0.01" min="0.01" required>
                            <button type="submit" class="btn btn-sm btn-success">Confirmar</button>
                            <button type="button" class="btn btn-sm btn-danger btn-cancelar">Cancelar</button>
                        </div>
                    </form>

                    <!-- Formulário de transferência -->
                    <form action="{{ route('transferencia.transferir', ['conta_id' => $conta->conta_id]) }}" method="POST" class="transferir-form" style="display: none;">
                        @csrf
                        <input type="hidden" name="origem_conta_id" value="{{ $conta->conta_id }}">
                        
                        <h4>Transferir R$</h4>
                        <div class="d-flex gap-2">
                            <input type="number" name="destino_conta_id" placeholder="Código da conta destino" class="form-control form-control-sm" step="1" min="1" required>
                            <input type="number" name="valor" placeholder="Informe o valor da transferência" class="form-control form-control-sm" step="0.01" min="0.01" required>
                            <input type="number" name="usuario_codigo" placeholder="Código do usuário (opcional)" class="form-control form-control-sm" step="1" min="1">
                            <button type="submit" class="btn btn-sm btn-success">Confirmar Transferência</button>
                            <button type="button" class="btn btn-sm btn-danger btn-cancelar">Cancelar</button>
                        </div>
                    </form>

                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    // Mostrar/Esconder o formulário de depósito
    document.querySelectorAll('.btn-depositar').forEach(button => {
        button.addEventListener('click', function () {
            const parent = this.closest('.list-group-item');
            const depositoForm = parent.querySelector('.deposito-form');
            depositoForm.style.display = depositoForm.style.display === 'none' ? 'block' : 'none';
            const transferirForm = parent.querySelector('.transferir-form');
            if (transferirForm) transferirForm.style.display = 'none';
        });
    });

    // Mostrar/Esconder o formulário de transferência
    document.querySelectorAll('.btn-transferir').forEach(button => {
        button.addEventListener('click', function () {
            const parent = this.closest('.list-group-item');
            const transferirForm = parent.querySelector('.transferir-form');
            transferirForm.style.display = transferirForm.style.display === 'none' ? 'block' : 'none';
            const depositoForm = parent.querySelector('.deposito-form');
            if (depositoForm) depositoForm.style.display = 'none';
        });
    });

    // Ação para cancelar e esconder o formulário
    document.querySelectorAll('.btn-cancelar').forEach(button => {
        button.addEventListener('click', function () {
            const parent = this.closest('.list-group-item');
            const depositoForm = parent.querySelector('.deposito-form');
            const transferirForm = parent.querySelector('.transferir-form');
            if (depositoForm) depositoForm.style.display = 'none';
            if (transferirForm) transferirForm.style.display = 'none';
        });
    });

</script>

@endsection
