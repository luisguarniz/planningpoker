<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid('RoomID')->primary();
            $table->uuid('AdminUserCode');
            $table->string('RoomName');
            $table->string('RoomCode');
            $table->timestamps();
            $table->boolean('IsActive')->default('1');

            

            $table->foreign('AdminUserCode')->references('AdminUserCode')->on('users');//se lee: sera llave foranea 'AdminUserCode'
                                                                                      // refenciado del campo 'AdminUserCode' de la tabla 'users'
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
