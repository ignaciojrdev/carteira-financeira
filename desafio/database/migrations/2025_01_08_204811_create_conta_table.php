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
        Schema::create('conta', function (Blueprint $table) {
            $table->id('conta_id');
            $table->decimal('saldo', 10, 2)->default(0);  // Saldo da conta
            $table->unsignedBigInteger('user_id');        // Chave estrangeira para 'users'
            $table->timestamps();
        
            // Definindo a chave estrangeira
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conta');
    }
};
