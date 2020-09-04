<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultSalesItemPriceIdToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->bigInteger('default_sales_item_price_id')
                ->unsigned()
                ->nullable()
                ->after('default_purchase_item_price_id');
            $table->foreign('default_sales_item_price_id')
                ->references('id')
                ->on('sales_item_prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('default_sales_item_price_id');
        });
    }
}
