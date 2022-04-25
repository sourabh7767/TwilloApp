<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('original_name')->nullable();
            $table->string('size')->nullable();
            $table->integer('model_id');
            $table->string('model_type');
            $table->integer('status')->default(1);
            $table->integer('type')->default(0)->comment("0 => image, 1 => video,2=>pdf,3=>other");;
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
