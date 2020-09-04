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
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('measuring_mass_id')->unsigned();
            $table->foreign('measuring_mass_id')
                ->references('id')
                ->on('measuring_mass')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('unit_of_measurement_id')->unsigned();
            $table->foreign('unit_of_measurement_id')
                ->references('id')
                ->on('unit_of_measurements')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('sales_item_price_id')->unsigned();
            $table->foreign('sales_item_price_id')
                ->references('id')
                ->on('sales_item_prices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('quantity')->unsigned();
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
