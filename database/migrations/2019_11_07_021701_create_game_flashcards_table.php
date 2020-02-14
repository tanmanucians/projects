<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameFlashcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_flashcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('flashcard_id');
            $table->unsignedBigInteger('game_id');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            $table->foreign('flashcard_id')
                ->references('id')
                ->on('flashcards')
                ->onUpdate('cascade');

            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_flashcards');
    }
}
