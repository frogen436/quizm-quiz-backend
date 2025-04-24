<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name');
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id('quiz_id');
            $table->string('name');
            $table->foreignId('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->integer('author_id');
            $table->integer('playcount')->default(0);
            $table->timestamps();
        });
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->foreignId('quiz_id')->references('quiz_id')->on('quizzes')->onDelete('cascade');
            $table->string('content');
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->id('answer_id');
            $table->foreignId('question_id')->references('question_id')->on('questions')->onDelete('cascade');
            $table->string('content');
        });

    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('answers');
        Schema::dropIfExists('questions');
    }
};
