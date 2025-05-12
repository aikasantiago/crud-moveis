<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedors', function (Blueprint $table) {
            $table->id(); // ID auto increment
            $table->string('nome'); // Coluna para o nome do fornecedor
            $table->string('email')->nullable(); // Coluna para o email (opcional)
            $table->string('telefone')->nullable(); // Coluna para o telefone (opcional)
            $table->string('endereco')->nullable(); // Coluna para o telefone (opcional)
            $table->timestamps(); // Colunas de created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedors');
    }
}
