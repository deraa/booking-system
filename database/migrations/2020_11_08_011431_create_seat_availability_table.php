<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatAvailabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seat_availability', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_point_id');
            $table->unsignedBigInteger('to_point_id');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('seat_id');
            $table->timestamps();

            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
            $table->foreign('from_point_id')->references('id')->on('trip_stop_points')->onDelete('cascade');
            $table->foreign('to_point_id')->references('id')->on('trip_stop_points')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availability');
    }
}
