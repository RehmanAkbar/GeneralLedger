<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if(!Schema::hasTable('cities')){
                Schema::create('cities', function(Blueprint $table) {
                    $table->increments('id');
                    $table->integer('country_id')->unsigned()->index();
                    $table->foreign('country_id')->references('id')->on('countries');
                    $table->string('name');
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
        Schema::dropIfExists('cities');
    }

}
