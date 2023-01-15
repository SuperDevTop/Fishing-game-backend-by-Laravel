<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fish', function (Blueprint $table) {
            $table->integer('ID');
            $table->integer('BassCaught');
            $table->integer('MuskieCaught');
            $table->integer('BlueGillCaught');
            $table->integer('BassTotal');
            $table->integer('MuskieTotal');
            $table->integer('BlueGillTotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fish');
    }
};
