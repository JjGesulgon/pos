<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id')->unsigned();
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');
            $table->bigInteger('corporation_id')->unsigned();
            $table->foreign('corporation_id')
                ->references('id')
                ->on('corporations');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')
                ->references('id')
                ->on('items');
            $table->bigInteger('measuring_mass_id')->unsigned();
            $table->foreign('measuring_mass_id')
                ->references('id')
                ->on('measuring_mass');
            $table->bigInteger('unit_of_measurement_id')->unsigned();
            $table->foreign('unit_of_measurement_id')
                ->references('id')
                ->on('unit_of_measurements');
            $table->bigInteger('sales_item_price_id')->unsigned();
            $table->foreign('sales_item_price_id')
                ->references('id')
                ->on('sales_item_prices');
            $table->bigInteger('quantity')->unsigned();
            $table->json('item_sales_discounts')->nullable();
            $table->json('brand_sales_discounts')->nullable();
            $table->decimal('discount_amount', 20, 2)->unsigned()->nullable();
            $table->json('tax_percent')->nullable();
            $table->decimal('tax_amount', 20, 2)->unsigned()->nullable();
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
        Schema::dropIfExists('transaction_items');
    }
}
