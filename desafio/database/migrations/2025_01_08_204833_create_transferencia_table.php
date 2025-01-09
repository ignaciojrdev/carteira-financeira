<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('transferencia', function (Blueprint $table) {
            $table->id('transferencia_id');
            $table->unsignedBigInteger('conta_id_envio')->nullable();
            $table->unsignedBigInteger('conta_id_recebimento');
            $table->unsignedBigInteger('user_id_envio')->nullable();
            $table->unsignedBigInteger('user_id_recebimento');
            $table->decimal('saldo_transferencia', 10, 2);
            $table->timestamps();
            $table->boolean('desfeita')->default(false); 
        
            // Definindo as chaves estrangeiras
            $table->foreign('conta_id_envio')->references('conta_id')->on('conta')->onDelete('cascade')->nullable();
            $table->foreign('conta_id_recebimento')->references('conta_id')->on('conta')->onDelete('cascade');
            $table->foreign('user_id_envio')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_recebimento')->references('id')->on('users')->onDelete('cascade');
        });
        
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferencia');
    }
};
