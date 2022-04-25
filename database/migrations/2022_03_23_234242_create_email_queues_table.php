<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_queues', function (Blueprint $table) {
            $table->id();
            $table->string("from_email")->nullable();
            $table->string("to_email")->nullable();
            $table->text("message")->nullable();
            $table->text("subject")->nullable();
            $table->timestamp("date_published")->nullable();
            $table->timestamp("last_attempt")->nullable();
            $table->timestamp("date_sent")->nullable();
            $table->integer("attempts")->nullable();
            $table->integer("status")->default(1)->comment("0=>Not sent","sent");
            $table->integer("type")->default(0)->comment();
            $table->integer("model_id")->nullable();
            $table->string("model_type")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_queues');
    }
}
