<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->char('type', 1);
            $table->integer('sequence');
            $table->date('date');
            $table->string('description');
            $table->integer('bank_id')->unsigned()->nullable();
            $table->integer('check_number')->nullable();
            $table->date('check_date')->nullable();
            $table->string('beneficiary')->nullable();
            $table->string('img')->nullable();
            $table->boolean('wants_sync')->default(false);
            $table->boolean('synced')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
