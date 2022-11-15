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
        Schema::create('failed_covenants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('standard_covenant_id')->unsigned();
            $table->string('failed_covenant');
            $table->string('frequency');
            $table->string('track_seq');
            $table->foreign('standard_covenant_id')->references('id')->on('standard_covenants');
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
        Schema::dropIfExists('failed_covenant');
    }
};
