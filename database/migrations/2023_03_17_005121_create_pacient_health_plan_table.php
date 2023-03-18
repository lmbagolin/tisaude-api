<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientHealthPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacient_health_plan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pacient_id');
            $table->unsignedBigInteger('health_plan_id');

            $table->string('contract_id')->nullable();
            $table->date('joined_at')->nullable();
            $table->date('expire_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pacient_id')->references('id')->on('pacient');
            $table->foreign('health_plan_id')->references('id')->on('health_plan');

            $table->unique(['pacient_id', 'health_plan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacient_health_plan');
    }
}
