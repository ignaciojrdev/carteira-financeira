<?php

namespace App\Services;

use App\Models\Conta;
use App\Models\Transferencia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TransferenciaService
{
    /**
     * Realiza a transferência entre duas contas.
     *
     * @param  int  $origemContaId
     * @param  int  $destinoContaId
     * @param  float  $valor
     * @throws \Exception
     * @return void
     */
    public function realizarTransferencia(int $origemContaId, int $destinoContaId, float $valor)
    {
        DB::beginTransaction();

        try {
            // Verificar se a conta de origem existe
            $contaOrigem = Conta::findOrFail($origemContaId);

            // Verificar se a conta de destino existe
            $contaDestino = Conta::findOrFail($destinoContaId);

            // Verificar se a conta de origem tem saldo suficiente
            if ($contaOrigem->saldo < $valor) {
                throw new \Exception('Saldo insuficiente para realizar a transferência!');
            }

            // Realizar a transferência (descontar da conta origem e adicionar na conta destino)
            $contaOrigem->saldo -= $valor;
            $contaDestino->saldo += $valor;

            $contaOrigem->save();
            $contaDestino->save();

            // Registrar a transferência
            Transferencia::create([
                'conta_id_envio' => $contaOrigem->conta_id,
                'conta_id_recebimento' => $contaDestino->conta_id,
                'saldo_transferencia' => $valor,
                'user_id_envio' => auth()->id(),
                'user_id_recebimento' => $contaDestino->user_id,
            ]);

            DB::commit();
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            throw new \Exception('Conta não encontrada.');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}