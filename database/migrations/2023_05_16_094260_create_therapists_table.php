<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('therapist_type')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('country')->nullable();
            $table->string('residential_address')->nullable();
            $table->string('city_or_state')->nullable();
            $table->string('insurance_number')->nullable();
            // $table->string('status')->nullable();
            $table->string('sex')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('alternative_phone')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('remarks')->nullable();
            $table->string('area')->nullable();
            $table->string('DOB_number')->nullable();
            $table->string('BSN_number')->nullable();
            $table->string('file')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('therapists');
    }
}
