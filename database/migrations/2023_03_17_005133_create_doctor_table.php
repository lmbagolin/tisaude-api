<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('crm', 20);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('doctor_has_specialty', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('speciality_id');

            $table->foreign('doctor_id')->references('id')->on('doctor');
            $table->foreign('speciality_id')->references('id')->on('specialty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_has_specialty');
        Schema::dropIfExists('doctor');
    }
}
