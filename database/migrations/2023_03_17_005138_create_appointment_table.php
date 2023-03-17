<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pacient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('pacient_health_plan_id')->nullable();

            $table->date('date')->nullable();
            $table->boolean('is_private')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pacient_id')->references('id')->on('pacient');
            $table->foreign('doctor_id')->references('id')->on('doctor');
        });

        Schema::create('appointment_has_procedure', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('procedure_id');

            $table->foreign('appointment_id')->references('id')->on('appointment');
            $table->foreign('procedure_id')->references('id')->on('procedure');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_has_procedure');
        Schema::dropIfExists('appointment');
    }
}
