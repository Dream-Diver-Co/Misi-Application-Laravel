<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id')->nullable();
            // $table->dateTime('start_date')->nullable();
            // $table->dateTime('end_date')->nullable();
            $table->text('dates')->nullable();
            $table->text('start_time')->nullable();
            $table->text('end_time')->nullable();

            $table->foreign('therapist_id')->references('id')->on('therapists')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_schedules');
    }
}
