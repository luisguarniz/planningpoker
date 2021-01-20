<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotingsessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votingsessions', function (Blueprint $table) {
            $table->uuid('VotingSessionCode')->primary();
            $table->uuid('RoomID');
            $table->boolean('IsActive');
            $table->timestamps();

            $table->foreign('RoomID')
            ->references('RoomID')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votingsessions');
    }
}
