<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferenciaRequest;
use App\Services\TransferenciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conta;
use App\Models\Transferencia;

class TransferenciaController extends Controller
{
    protected $transferenciaService;

    public function __construct(TransferenciaService $transferenciaService)
    {
        $this->transferenciaService = $transferenciaService;
    }

    public function index($conta_id){
        $contas = Conta::where('user_id', auth()->id())
                        ->where('conta_id', $conta_id)
                        ->orderBy('conta_id', 'asc')
                        ->get();

        $transferencias = Transferencia::where(function ($query) use ($conta_id) {
                        $query->where('conta_id_recebimento', $conta_id)
                              ->orWhere('conta_id_envio', $conta_id);
                        })
                        ->where('desfeita', false)
                        ->orderBy('transferencia_id', 'asc')
                        ->get();
                        
        return view('Transferencia', ['transferencias' => $transferencias]);
    }

    public function depositar(Request $request){
        $this->limparSessionMessage();
        $conta = Conta::findOrFail($request->id);

        $conta->saldo += $request->input('valor');
        $conta->save();

        $transferencia = Transferencia::create([
            'conta_id_envio' => null,
            'conta_id_recebimento' => $request->id,
            'saldo_transferencia' => $request->input('valor'),
            'user_id_envio' => auth()->id(),
            'user_id_recebimento' => auth()->id(),
        ]);

        return redirect()->route('conta')->with('success', 'Deposito realizado com sucesso!');
    }

    public function transferir(TransferenciaRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->transferenciaService->realizarTransferencia(
                $validated['origem_conta_id'],
                $validated['destino_conta_id'],
                $validated['valor']
            );

            return redirect()->route('conta')
                 ->with('success', 'Transferência realizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('conta')->with('error', $e->getMessage());
        }
    }

    private function limparSessionMessage(){
        session()->forget('error');
        session()->forget('success');
        session()->forget('warning');
    }

    public function exibirTransferencias()
    {
        $transferencias = Transferencia::where('desfeita', false)->get();
        return view('Transferencia', ['transferencias' => $transferencias]);
    }

    public function desfazerTransferencia($id)
    {
        $transferencia = Transferencia::find($id);

        if (!$transferencia || $transferencia->desfeita) {
            return redirect()->route('conta')->with('error', 'Transferência não encontrada ou já desfeita.');
        }

        $contaEnvio = Conta::find($transferencia->conta_id_envio);
        $contaRecebimento = Conta::find($transferencia->conta_id_recebimento);

        if (!$contaRecebimento || !$this->existeSaldoParaDevolucao($contaRecebimento->saldo, $transferencia->saldo_transferencia)) {
            return redirect()->route('conta')->with('error', 'Erro ao desfazer transferência, saldo insuficiente!');
        }

        if ($contaEnvio) {
            $contaEnvio->saldo += $transferencia->saldo_transferencia;
        }
        $contaRecebimento->saldo -= $transferencia->saldo_transferencia;

        $transferencia->update(['desfeita' => true]);
        $contaEnvio?->save();
        $contaRecebimento->save();

        return redirect()->route('conta')->with('success', 'Transferência desfeita com sucesso.');
    }
    
    private function existeSaldoParaDevolucao($saldoContaRecebimento, $valorTransferencia){
        if(($saldoContaRecebimento -= $valorTransferencia) < 0){
            return false;
        }
        return true;
    }

}