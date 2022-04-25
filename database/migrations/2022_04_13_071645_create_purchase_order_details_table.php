<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_order_id');
            $table->integer('item_id');
            $table->string('cut_size');
            $table->string('item_no');
            $table->text('description')->nullable();
            $table->string('style')->nullable();
            $table->integer('order_qty')->nullable();
            $table->string('directional')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_details');
    }
}
