<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherEntriesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('voucher_details')){
            Schema::create('voucher_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('voucher_id')->unsigned()->index();
                $table->foreign('voucher_id')->references('id')->on('vouchers');

                $table->integer('account_id')->unsigned()->index();
                $table->foreign('account_id')->references('id')->on('accounts');

                $table->string('narration')->nullable();
                $table->string('cheque_no');
                $table->integer('debit');
                $table->integer('credit');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_details');
    }
}
