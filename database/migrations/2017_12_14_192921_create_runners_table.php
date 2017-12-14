<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRunnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country');
            $table->smallInteger('lane');
            $table->smallInteger('heat');
            $table->float('secondLeg');
            $table->float('firstLeg');
            $table->string('name');
            $table->smallInteger('year');
            $table->timestamps();

            // Indexes
	        $table->index('year');
	        $table->index('firstLeg');
	        $table->index('secondLeg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('runners');
    }
}
