<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Quiz;
use App\Http\Controllers\QuizController;


$routes = function () {

    Route::get('/', function () {
        return 1;
    });

    Route::get('/quizzes/categories', [QuizController::class, 'get_categories']);
    Route::get('/quizzes/{id}', [QuizController::class, 'get_quiz_by_id']);
    Route::post('/quizzes', [QuizController::class, 'create_quiz']);
    Route::get('/quizzes/{id}/questions', [QuizController::class, 'get_questions']);
    Route::post('/quizzes:check_answer', [QuizController::class, 'check_answer']);
    Route::post('/quizzes:search', [QuizController::class, 'search_quiz']);
    Route::get('/quizzes/by-category/{category_id}', [QuizController::class, 'search_quiz_by_category']);
    Route::get('/quizzes:random-quizzes', [QuizController::class, 'get_random_quizzes']);
};
Route::prefix("/api/v1")->group($routes);

