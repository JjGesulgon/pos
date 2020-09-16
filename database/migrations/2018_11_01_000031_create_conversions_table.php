<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
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
            $table->bigInteger('unit_of_measurement_from_id')->unsigned();
            $table->decimal('from_value', 20, 2);
            $table->foreign('unit_of_measurement_from_id')
                ->references('id')
                ->on('unit_of_measurements')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->bigInteger('unit_of_measurement_to_id')->unsigned();
            $table->decimal('to_value', 20, 2);
            $table->foreign('unit_of_measurement_to_id')
                ->references('id')
                ->on('unit_of_measurements')
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
        Schema::dropIfExists('conversions');
    }
}
