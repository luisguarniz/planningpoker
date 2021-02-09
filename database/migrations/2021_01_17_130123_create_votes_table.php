<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->uuid('VotingSessionCode')->nullable();
            $table->unsignedBigInteger('UserID')->nullable();
            $table->string('vote')->nullable();
            $table->boolean('IsActive')->default('1');

            $table->foreign('VotingSessionCode')
            ->references('VotingSessionCode')->on('votingsessions')
            ->onDelete('set null');

            $table->foreign('UserID')
            ->references('id')->on('users')
            ->onDelete('set null');

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
        Schema::dropIfExists('votes');
    }
}
