<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('corporation_id')->unsigned();
            $table->foreign('corporation_id')
                ->references('id')
                ->on('corporations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('contact_type_id')->unsigned();
            $table->foreign('contact_type_id')
                ->references('id')
                ->on('contact_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('business_type')->nullable();
            $table->string('company')->nullable();
            $table->string('company_address')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('city');
            $table->string('province');
            $table->string('address', 2000);
            $table->string('zip_code')->default('6100');
            $table->string('tin_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->decimal('credit_limit', 20, 2)->nullable();
            $table->enum('payment_term', ['1', '2', '3', '4', '5', '6']);
            $table->bigInteger('mode_of_payment_id')->unsigned();
            $table->foreign('mode_of_payment_id')
                ->references('id')
                ->on('mode_of_payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('contacts');
    }
}
