<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('codigo');
            $table->integer('fecucode_id')->unsigned()->nullable();
            $table->char('clase', 1);
            $table->integer('nivel');
            $table->char('subcta', 1)->nullable();
            $table->char('ctacte', 1)->nullable();
            $table->char('ctacte2', 1)->nullable();
            $table->char('ctacte3', 1)->nullable();
            $table->char('ctacte4', 1)->nullable();
            $table->char('estado', 1)->nullable();
            $table->char('estado2', 1)->nullable();
            $table->string('nombre')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fecucode_id')->references('id')->on('fecucodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
