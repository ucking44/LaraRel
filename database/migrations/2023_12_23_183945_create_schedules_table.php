<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('bus_id')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('starting_point')->nullable();
            $table->string('destination')->nullable();
            $table->date('schedule_date')->nullable();
            $table->time('departure_time')->nullable();
            $table->time('estimated_arrival_time')->nullable();
            $table->double('fare_amount', 25, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bus_id')->references('id')->on('buses')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
