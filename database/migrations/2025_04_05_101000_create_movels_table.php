<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovelsTable extends Migration
{
    public function up()
    {
        Schema::create('movels', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('categoria_id'); // agora relaciona com categorias.id
            $table->integer('estoque');
            $table->decimal('preco', 8, 2); // define precisão e escala
            $table->timestamps();

            // chave estrangeira
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movels');
    }
}
