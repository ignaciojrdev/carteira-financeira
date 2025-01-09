<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;

    protected $table = 'transferencia';
    protected $primaryKey = 'transferencia_id';
    protected $fillable = [
        'conta_id_envio',
        'conta_id_recebimento',
        'saldo_transferencia',
        'desfeita',
        'user_id_envio',
        'user_id_recebimento'
    ];

    // Relação de muitos-para-um com a tabela 'conta' (conta de envio)
    public function contaEnvio()
    {
        return $this->belongsTo(Conta::class, 'conta_id_envio');
    }

    // Relação de muitos-para-um com a tabela 'conta' (conta de recebimento)
    public function contaRecebimento()
    {
        return $this->belongsTo(Conta::class, 'conta_id_recebimento');
    }
}
