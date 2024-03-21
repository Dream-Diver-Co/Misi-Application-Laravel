<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->string('fee');
            $table->time('time');
            $table->string('date');
            $table->string('status');
            $table->string('type');
            $table->string('assigned_therapists')->nullable();
            $table->longText('therapist_comment');
            $table->string('remarks');
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_appointments');
    }
}
