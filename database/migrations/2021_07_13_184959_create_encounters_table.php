<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encounters', function (Blueprint $table) {
            $table->id();
            $table->integer('u_id');
            $table->integer('p_id');
            $table->string('ftv_or_rtv');
            $table->float('height');
            $table->float('weight');
            $table->float('bmi');
            $table->integer('bp');
            $table->integer('temp');
            $table->integer('rr');
            $table->text('complaints');
            $table->string('diagnosis');
            $table->string('treatment_plan');
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
        Schema::dropIfExists('encounters');
    }
}
