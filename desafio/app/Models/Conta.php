<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;
    protected $table = 'conta';
    protected $primaryKey = 'conta_id';

    protected $fillable = [
        'user_id',
        'saldo',
    ];

    // Relação de muitos-para-um com a tabela 'users'
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relação de muitos-para-muitos com a tabela 'transferencia' (conta de envio)
    public function transferenciasEnviadas()
    {
        return $this->hasMany(Transferencia::class, 'conta_id_envio');
    }

    // Relação de muitos-para-muitos com a tabela 'transferencia' (conta de recebimento)
    public function transferenciasRecebidas()
    {
        return $this->hasMany(Transferencia::class, 'conta_id_recebimento');
    }
}
