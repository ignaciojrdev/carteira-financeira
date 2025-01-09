<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta;
use App\Models\Transferencia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class TransferenciaController extends Controller
{
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

    public function transferir(Request $request)
    {
        $this->limparSessionMessage();
        $user_id_recebimento = null;
        $validated = $request->validate([
            'origem_conta_id' => 'required|exists:conta,conta_id',
            'destino_conta_id' => 'required|exists:conta,conta_id',
            'valor' => 'required|numeric|min:0.01',
            'usuario_codigo' => 'nullable|exists:users,id'
        ], [
            'origem_conta_id.exists' => 'A conta de origem não existe no sistema.',
            'destino_conta_id.exists' => 'A conta de destino não existe no sistema.',
            'valor.required' => 'O valor da transferência é obrigatório.',
            'valor.numeric' => 'O valor da transferência deve ser numérico.',
            'valor.min' => 'O valor da transferência deve ser maior que 0.',
        ]);
        
        if($request->usuario_codigo){
            $contaOrigem = $this->buscarContaUsuarioOrigem($request->origem_conta_id);
            $contaDestino = $this->buscarContaUsuarioDestino($request->usuario_codigo, $request->destino_conta_id);

            if(!$contaDestino){
                return redirect()->route('conta')->with('error', 'O usuário de destino não tem a conta informada.');
            }

            if (($contaOrigem->saldo < $request->valor)) {
                return redirect()->route('conta')->with('error', 'Saldo insuficiente para realizar a transferência!');
            }

            $contaOrigem->saldo -= $request->valor;
            $contaDestino->saldo += $request->valor;
            $user_id_recebimento = $contaDestino->user_id;
            $contaOrigem->save();
            $contaDestino->save();
        }else{
            if($request->origem_conta_id == $request->destino_conta_id){
                return redirect()->route('conta')->with('warning', 'Operação não foi realizada! Não é permitido que a conta de origem seja a mesma de destino.');
            }
    
            $contaOrigem = $this->buscarContaUsuarioOrigem($request->origem_conta_id);
            $contaDestino = $this->buscarContaUsuarioOrigem($request->destino_conta_id);
    
            if (($contaOrigem->saldo < $request->valor)) {
                return redirect()->route('conta')->with('error', 'Saldo insuficiente para realizar a transferência!');
            }
    
            $contaOrigem->saldo -= $request->valor;
            $contaDestino->saldo += $request->valor;
            $user_id_recebimento = auth()->id();
            $contaOrigem->save();
            $contaDestino->save();
        }

        
        $transferencia = Transferencia::create([
            'conta_id_envio' => $request->origem_conta_id,
            'conta_id_recebimento' => $request->destino_conta_id,
            'saldo_transferencia' => $request->valor,
            'user_id_envio' => auth()->id(),
            'user_id_recebimento' => $user_id_recebimento,
        ]);

        return redirect()->route('conta')->with('success', 'Transferência realizada com sucesso.');
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

        if (!$transferencia) {
            return redirect()->back()->with('error', 'Transferência não encontrada.');
        }

        $contaEnvio = Conta::find($transferencia->conta_id_envio);
        $contaRecebimento = Conta::find($transferencia->conta_id_recebimento);

        if (!$contaRecebimento) {
            return redirect()->route('conta')->with('error', 'Erro ao desfazer transferência, saldo insuficiente!');
        }
        if(!$this->existeSaldoParaDevolucao($contaRecebimento->saldo, $transferencia->saldo_transferencia)){
            return redirect()->route('conta')->with('error', 'Erro ao desfazer transferência, saldo insuficiente!');
        }
        
        if($contaEnvio){
            $contaEnvio->saldo += $transferencia->saldo_transferencia;
            $contaRecebimento->saldo -= $transferencia->saldo_transferencia;
            $transferencia->update(['desfeita' => true]);
            $contaEnvio->save();
            $contaRecebimento->save();
        }else{
            $contaRecebimento->saldo -= $transferencia->saldo_transferencia;
            $transferencia->update(['desfeita' => true]);
            $contaRecebimento->save();
        }

        return redirect()->route('conta')->with('success', 'Transferência desfeita com sucesso.');
    }
    
    private function existeSaldoParaDevolucao($saldoContaRecebimento, $valorTransferencia){
        if(($saldoContaRecebimento -= $valorTransferencia) < 0){
            return false;
        }
        return true;
    }

    private function buscarContaUsuarioOrigem($id_origem){
        return Conta::where('conta_id', $id_origem)->where('user_id', auth()->id())->first();
    }

    private function buscarContaUsuarioDestino($user_id_destino, $conta_destino){
        return Conta::where('conta_id', $conta_destino)->where('user_id', $user_id_destino)->first();
    }

}
