<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            if(!Schema::hasTable('offices')){
                Schema::create('offices', function(Blueprint $table) {
                    $table->increments('id');
                    $table->integer('company_id')->unsigned()->index();
                    $table->foreign('company_id')->references('id')->on('companies');
                    $table->integer('branch_code');
                    $table->string('name');
                    $table->string('abbreviation')->nullable();
                    $table->text('address')->nullable();
                    $table->string('phone')->nullable();
                    $table->string('fax')->nullable();
                    $table->string('email')->nullable();
                    $table->string('sales_gl_code')->nullable();
                    $table->string('sales_tax_code')->nullable();
                    $table->string('sed_gl_code')->nullable();
                    $table->string('earning_gl_code')->nullable();

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
        Schema::dropIfExists('offices');
    }

}
