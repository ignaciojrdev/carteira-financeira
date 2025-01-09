@extends('layouts.main')

@section('title', 'Transferências Bancárias')

@section('content')
    @if(sizeof($transferencias) == 0)
        <div class="alert alert-info text-center">
            Não existem transferências cadastradas para essa conta.
        </div>
    @else
        <div class="list-group">
            @foreach($transferencias as $transferencia)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    @if(!$transferencia->conta_id_envio)
                        <div>
                            <h5>Deposito</h5>
                            <p><strong>Conta de destino:</strong> {{$transferencia->conta_id_recebimento}}</p>
                            <p><strong>Valor da transferência:</strong> R$ {{ number_format($transferencia->saldo_transferencia, 2, ',', '.') }}</p>
                        </div>
                        <div>
                            <form action="{{ route('transferencia.desfazer', $transferencia->transferencia_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Desfazer</button>
                            </form>
                        </div>
                    @else
                        <div>
                            <h5>Transferência</h5>
                            <p><strong>Conta de origem:</strong> {{ $transferencia->conta_id_envio }}</p>
                            <p><strong>Conta de destino:</strong> {{$transferencia->conta_id_recebimento}}</p>
                            <p><strong>Valor da transferência:</strong> R$ {{ number_format($transferencia->saldo_transferencia, 2, ',', '.') }}</p>
                        </div>
                        <div>
                            <form action="{{ route('transferencia.desfazer', $transferencia->transferencia_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Desfazer</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection

@section('styles')
    <style>
        .list-group-item {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
        }

        .list-group-item:hover {
            background-color: #e9ecef;
        }

        .list-group-item p {
            margin: 5px 0;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
@endsection
