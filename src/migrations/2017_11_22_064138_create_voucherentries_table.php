<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVoucherentriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            if(!Schema::hasTable('vouchers')){
                Schema::create('vouchers', function(Blueprint $table) {
                    $table->increments('id');
                    $table->integer('voucher_type_id')->unsigned()->index();
                    $table->foreign('voucher_type_id')->references('id')->on('user_types');

                    $table->integer('user_id')->unsigned()->index();
                    $table->foreign('user_id')->references('id')->on('users');

                    $table->integer('company_id')->unsigned()->index();
                    $table->foreign('company_id')->references('id')->on('companies');

                    $table->integer('office_id')->unsigned()->index();
                    $table->foreign('office_id')->references('id')->on('offices');

                    $table->string('voucher_code');
                    $table->timestamp('voucher_date')->nullable();
                    $table->string('remarks')->nullable();

                    $table->timestamps();
                    $table->softDeletes();
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
        Schema::dropIfExists('vouchers');
    }

}
