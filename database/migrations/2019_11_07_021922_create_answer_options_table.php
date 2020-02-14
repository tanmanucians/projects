<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('flashcard_id');
            $table->text('value');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            $table->foreign('flashcard_id')
                ->references('id')
                ->on('flashcards')
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
        Schema::dropIfExists('answer_options');
    }
}
