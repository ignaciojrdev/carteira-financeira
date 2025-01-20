<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\ContaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransferenciaController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/Login', [LoginController::class, 'index']);
Route::post('/Login', [LoginController::class, 'login'])->name('login');
Route::post('/Logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/Cadastro', [CadastroController::class, 'index']);
Route::post('/Cadastro', [CadastroController::class, 'register'])->name('register.submit');;

Route::get('/Conta', [ContaController::class, 'index'])->middleware('auth')->name('conta');
Route::post('/Conta/Cadastrar', [ContaController::class, 'criar'])->middleware('auth')->name('conta.criar');

Route::post('/Conta/Depositar', [TransferenciaController::class, 'depositar'])->middleware('auth')->name('transferencia.depositar');
Route::post('/Conta/Transferir', [TransferenciaController::class, 'transferir'])->middleware('auth')->name('transferencia.transferir');
Route::get('/Conta/transferencias', [TransferenciaController::class, 'exibirTransferencias'])->middleware('auth')->name('transferencia.transfererir');
Route::get('/Conta/Desfazer/{conta_id}', [TransferenciaController::class, 'index'])->middleware('auth')->name('transferencia.index');
Route::post('/Conta/Desfazer/{conta_id}', [TransferenciaController::class, 'desfazerTransferencia'])->middleware('auth')->name('transferencia.desfazer');