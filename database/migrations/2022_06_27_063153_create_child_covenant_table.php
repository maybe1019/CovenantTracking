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
        Schema::create('child_covenant', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('covenant_id')->unsigned();
            $table->string('child_covenant');
            $table->string('frequency');
            $table->foreign('covenant_id')->references('id')->on('standard_covenants');
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
        Schema::dropIfExists('child_covenant');
    }
};
