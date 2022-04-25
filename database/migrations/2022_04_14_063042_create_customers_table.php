<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->char('customer_id');
            $table->char('first_name');
            $table->char('last_name')->nullable();
            $table->char('full_name');
            $table->char('email')->nullable();
            $table->char('account_manager_name')->nullable();
            $table->char('account_manager_email')->nullable();
            $table->char('location')->nullable();
            $table->enum('is_thoroughbred_customer', ['Yes', 'No'])->default('No');
            $table->enum('is_mercato_place', ['Yes', 'No'])->default('No');
            $table->char('phone_number_1')->nullable();
            $table->char('phone_number_2')->nullable();
            $table->char('fax')->nullable();
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->text('address_line_3')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->char('postal_code')->nullable();
            $table->string('terms')->nullable();
            $table->string('currency')->nullable();
            $table->enum('enable_write_offs', ['True', 'False'])->default('True');
            $table->double('write_off_limit', 8, 2)->nullable();
            $table->enum('credit_verification', ['True', 'False'])->default('True');
            $table->integer('credit_verification_limit')->nullable();
            $table->char('default_payment_method')->nullable();
            $table->char('tax_zone')->nullable();
            $table->integer('salesperson_id')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
