<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if(!Schema::hasTable('companies')){
            Schema::create('companies', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('code');
                $table->string('name');
                $table->string('abbreviation')->nullable();
                $table->text('address')->nullable();
                $table->string('phone')->nullable();
                $table->string('fax')->nullable();
                $table->string('email')->nullable();
                $table->string('sales_tax')->nullable();
                $table->string('registration_no')->nullable();
                $table->integer('ntn')->nullable();
                $table->string('image')->nullable();

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
        Schema::dropIfExists('companies');
    }

}
