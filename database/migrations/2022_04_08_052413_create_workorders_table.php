<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorders', function (Blueprint $table) {
            $table->id();
            $table->string("project_no")->nullable();
            $table->string("project_name")->nullable();
            $table->string("customer_id")->nullable();
            $table->string("customer_name")->nullable();
            $table->string("customer_po")->nullable();
            $table->string("contact")->nullable();
            $table->string("manager")->nullable();
            $table->string("leader")->nullable();
            $table->string("sku")->nullable();
            $table->float('price')->default(0.00);
            $table->string('description')->nullable();
            $table->string("project_class")->nullable();
            $table->integer("quantity")->nullable();
            $table->integer("budget")->nullable();
            $table->integer('status')->default(1);
            $table->integer('is_scheduled')->default(0);
            $table->integer('is_cutting_complete')->default(0);
            $table->integer('is_production_complete')->default(0);
            $table->date('due_date')->nullable();
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
        Schema::dropIfExists('workorders');
    }
}
