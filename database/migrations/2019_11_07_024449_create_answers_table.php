<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('flashcard_id');
            $table->tinyInteger('type_id');
            $table->unsignedBigInteger('right_answer_option_id');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();

            $table->foreign('flashcard_id')
                ->references('id')
                ->on('flashcards')
                ->onUpdate('cascade');

            $table->foreign('right_answer_option_id')
                ->references('id')
                ->on('answer_options')
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
        Schema::dropIfExists('answers');
    }
}
