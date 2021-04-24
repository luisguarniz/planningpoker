<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhrasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phrases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idkindphrase');
            $table->string('Phrase', 1000);//se le aumenta de 255 a 1000
            $table->timestamps();

            $table->foreign('idkindphrase')
            ->references('id')
            ->on('kindphrases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phrases');
    }
}
