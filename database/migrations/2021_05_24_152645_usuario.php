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
        Schema::create('usuarios',function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('celular');
            $table->string('email');
            $table->string('senha');
            $table->string('img_dir');
            $table->string('cgc');
            $table->date('nasc');
            $table->char('genero', 1);
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
