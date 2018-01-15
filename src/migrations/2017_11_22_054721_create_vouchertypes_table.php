<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVouchertypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            if(!Schema::hasTable('voucher_types')){

                Schema::create('voucher_types', function(Blueprint $table) {

                    $table->increments('id');
                    $table->integer('company_id')->unsigned()->index();
                    $table->foreign('company_id')->references('id')->on('companies');

                    $table->integer('office_id')->unsigned()->index();
                    $table->foreign('office_id')->references('id')->on('offices');

                    $table->integer('user_id')->unsigned()->index();
                    $table->foreign('user_id')->references('id')->on('users');

                    $table->string('type')->unique();
                    $table->string('description')->nullable();
                    $table->string('prepared_by')->nullable();
                    $table->string('checked_by')->nullable();
                    $table->string('approved_by')->nullable();
                    $table->string('accepted_by')->nullable();

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
        Schema::dropIfExists('voucher_types');
    }

}
