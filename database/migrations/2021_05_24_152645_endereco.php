<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos',function (Blueprint $table) {
            $table->id();
            $table->string('logradouro');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('origem');
            $table->int('id_origem');
            $table->char('cep', 9);
            $table->char('genero', 1);
            $table->date('nasc');
            $table->foreignId('beneficiarios_id')->nullable()->onUpdate('cascade')->onDelete('cascade')->constrained();
            $table->foreignId('ongs_id')->nullable()->onUpdate('cascade')->onDelete('cascade')->constrained();
            $table->foreignId('usuarios_id')->nullable()->onUpdate('cascade')->onDelete('cascade')->constrained();
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
        //
    }
}
