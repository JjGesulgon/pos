<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('corporation_id')->unsigned();
            $table->foreign('corporation_id')
                ->references('id')
                ->on('corporations')
                ->onDelete('cascade');
            $table->bigInteger('brand_id')->unsigned()->nullable();
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('cascade');
            $table->bigInteger('asset_account_id')->unsigned()->nullable();
            $table->foreign('asset_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
            $table->bigInteger('cost_of_goods_sold_account_id')->unsigned()->nullable();
            $table->foreign('cost_of_goods_sold_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
            $table->bigInteger('sales_account_id')->unsigned()->nullable();
            $table->foreign('sales_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
            $table->bigInteger('expense_account_id')->unsigned()->nullable();
            $table->foreign('expense_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
            $table->bigInteger('item_type_id')->unsigned();
            $table->foreign('item_type_id')
                ->references('id')
                ->on('item_types')
                ->onDelete('cascade');
            $table->bigInteger('item_classification_id')->unsigned();
            $table->foreign('item_classification_id')
                ->references('id')
                ->on('item_classifications')
                ->onDelete('cascade');
            $table->bigInteger('default_unit_of_measurement_id')->unsigned();
            $table->foreign('default_unit_of_measurement_id')
                ->references('id')
                ->on('unit_of_measurements')
                ->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('stock_keeping_unit');
            $table->string('identifier')->nullable();
            $table->json('purchase_discounts')->nullable();
            $table->json('sales_discounts')->nullable();
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
        Schema::dropIfExists('items');
    }
}
