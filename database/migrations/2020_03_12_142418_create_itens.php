<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->integer('qtd');
            $table->unsignedBigInteger('preco_id');
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('campanha_id');
            $table->unsignedBigInteger('fornecedor_id');

            $table->foreign('preco_id')->references('id')->on('preco_itens');
            $table->foreign('tipo_id')->references('id')->on('tipo_itens');
            $table->foreign('campanha_id')->references('id')->on('campanhas');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens');
    }
}
