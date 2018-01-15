<?php

/**
 * Created by Soft Pyramid.
 * User: fakhar
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            if(!Schema::hasTable('account_types')){
                Schema::create('account_types', function(Blueprint $table) {
                    $table->increments('id');
                    $table->string('name');
                    $table->text('description')->nullable();

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
        Schema::dropIfExists('account_types');
    }

}
