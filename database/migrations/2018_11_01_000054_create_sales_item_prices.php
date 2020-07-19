<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesItemPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_item_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('corporation_id')->unsigned();
            $table->foreign('corporation_id')
                ->references('id')
                ->on('corporations')
                ->onDelete('cascade');
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
            $table->decimal('price', 20, 2);
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
        Schema::dropIfExists('sales_item_prices');
    }
}
