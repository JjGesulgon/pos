<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
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
            $table->morphs('stockable', 'stockable_index');
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
        Schema::dropIfExists('stocks');
    }
}
