<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta;
use App\Models\Transferencia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class ContaController extends Controller
{
    public function index(){
        $contas = Conta::where('user_id', auth()->id())->orderBy('conta_id', 'asc')->get();
        return view('conta', ['contas' => $contas, 'transferencias' => []]);
    }

    public function criar(){
        $this->limparSessionMessage();
        $conta = Conta::create([
            'user_id' => auth()->id(),
            'saldo' => 0,
        ]);

        return redirect()->route('conta');
    }
    
    private function limparSessionMessage(){
        session()->forget('error');
        session()->forget('success');
        session()->forget('warning');
    }
}
