<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->char('po_number');
            $table->char('contact_person');
            $table->char('phone')->nullable();
            $table->text('supplier_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('freight_terms')->nullable();
            $table->text('payment_terms')->nullable();
            $table->dateTimeTz('required_date')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}
