<?php

use App\Http\Controllers\Api\v1\AnswerDislikeController;
use App\Http\Controllers\Api\v1\AnswerLikeController;
use App\Http\Controllers\Api\v1\QuestionDislikeController;
use App\Http\Controllers\Api\v1\QuestionFavoriteController;
use App\Http\Controllers\Api\v1\QuestionFollowController;
use App\Http\Controllers\Api\v1\QuestionLikeController;

Route::namespace('v1')->prefix('v1')->group(function()
{   
    Route::post('/login', LoginController::class);

    Route::middleware(['auth:sanctum'])->group( function(){
        Route::apiResource('/genders', GenderController::class);
        Route::apiResource('/users', UserController::class);
        Route::apiResource('/school-levels', SchoolLevelController::class);
        Route::apiResource('/school-grades', SchoolGradeController::class);
        Route::apiResource('/courses', CourseController::class);
        Route::apiResource('/course-assignments', CourseAssignmentController::class);
        Route::apiResource('/questions', QuestionController::class);
        Route::apiResource('question/{question}/answers', AnswerController::class);
        Route::post('question/{question}/likes', [QuestionLikeController::class, 'store']);
        Route::post('answer/{answer}/likes', [AnswerLikeController::class, 'store']);
        Route::post('answer/{answer}/dislikes', [AnswerDislikeController::class, 'store']);
        Route::post('question/{question}/dislikes', [QuestionDislikeController::class, 'store']);
        Route::post('question/{question}/favorites', [QuestionFavoriteController::class, 'store']);
        Route::post('question/{question}/follows', [QuestionFollowController::class, 'store']);
    });

});