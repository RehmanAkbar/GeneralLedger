<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uploaded_by_user_id')->unsigned();
            $table->foreign('uploaded_by_user_id')->references('id')->on('users');

            $table->integer('deleted_by_user_id')->unsigned()->nullable();
            $table->foreign('deleted_by_user_id')->references('id')->on('users');

            $table->string('path');
            $table->string('media_type');
            $table->string('original_name')->nullable();
            $table->string('uploadable_type');
            $table->integer('uploadable_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploads');
    }
}
