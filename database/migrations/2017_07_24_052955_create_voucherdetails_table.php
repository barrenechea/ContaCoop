<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucherdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voucher_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->integer('identification_id')->unsigned()->nullable();
            $table->integer('doctype_id')->unsigned()->nullable();
            $table->string('doc_number')->nullable();
            $table->string('detail');
            $table->date('date')->nullable();
            $table->integer('debit');
            $table->integer('credit');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('identification_id')->references('id')->on('identifications')->onDelete('cascade');
            $table->foreign('doctype_id')->references('id')->on('doctypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucherdetails');
    }
}
