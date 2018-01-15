<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            if(!Schema::hasTable('accounts')){
                Schema::create('accounts', function(Blueprint $table) {
                    $table->increments('id');
                    $table->integer('code');
                    $table->integer('company_id')->unsigned()->index();
                    $table->foreign('company_id')->references('id')->on('companies');
                    $table->integer('office_id')->unsigned()->index();
                    $table->foreign('office_id')->references('id')->on('offices');
                    $table->integer('user_id')->unsigned()->index();
                    $table->foreign('user_id')->references('id')->on('users');
                    $table->tinyInteger('is_parent')->nullable();
                    $table->integer('account_type_id')->nullable();
                    $table->integer('account_group_id')->nullable();
                    $table->string('description');
                    $table->string('contact_person')->nullable();
                    $table->string('phone')->nullable();
                    $table->string('fax')->nullable();
                    $table->string('email')->nullable();
                    $table->string('address_1')->nullable();
                    $table->string('address_2')->nullable();
                    $table->string('address_3')->nullable();
                    $table->string('city_id')->nullable();
                    $table->string('region_id')->nullable();
                    $table->string('gst_no')->nullable();
                    $table->integer('ntn')->nullable();
                    $table->integer('nid_no')->nullable();
                    $table->string('other')->nullable();
                    $table->integer('bank_ac_no')->nullable();
                    $table->integer('open_debit')->nullable();
                    $table->integer('open_credit')->nullable();
                    $table->integer('credit_days')->nullable();
                    $table->integer('nlevel')->nullable();

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
        Schema::dropIfExists('accounts');
    }

}
