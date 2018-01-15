<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            if(!Schema::hasTable('countries')){
                Schema::create('countries', function(Blueprint $table) {
                    $table->increments('id');
                    $table->string('name');
                    $table->string('currency');
                    $table->integer('rate')->nullable();

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
        Schema::dropIfExists('countries');
    }

}
