<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('corporation_id')->unsigned();
            $table->foreign('corporation_id')
                ->references('id')
                ->on('corporations');
            $table->bigInteger('contact_id')->unsigned();
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->morphs('transactionable_from', 'transactionable_from_index');
            $table->string('number')->unique();
            $table->string('reference_number')->unique();
            $table->decimal('total_amount', 20, 2);
            $table->boolean('is_discountable')->default(0);
            $table->tinyInteger('discount_type')->unsigned()->nullable();
            $table->decimal('discount_percent', 5, 2)->unsigned()->nullable();
            $table->decimal('discount_amount', 20, 2)->unsigned()->nullable();
            $table->boolean('is_taxable')->default(0);
            $table->boolean('is_tax_inclusive')->nullable();
            $table->tinyInteger('tax_type')->unsigned()->nullable();
            $table->decimal('tax_percent', 5, 2)->unsigned()->nullable();
            $table->decimal('tax_amount', 20, 2)->unsigned()->nullable();
            $table->decimal('grand_total_amount', 20, 2);
            $table->decimal('paid_amount', 20, 2)->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
