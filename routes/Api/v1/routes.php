<?php

use App\Http\Controllers\Api\v1\QuestionLikeController;

Route::namespace('v1')->prefix('v1')->group(function()
{   

    Route::middleware(['auth:sanctum'])->group( function(){
        Route::apiResource('/users', UserController::class);
        Route::apiResource('/school-levels', SchoolLevelController::class);
        Route::apiResource('/school-grades', SchoolGradeController::class);
        Route::apiResource('/courses', CourseController::class);
        Route::apiResource('/course-assignments', CourseAssignmentController::class);
        Route::apiResource('/questions', QuestionController::class);
        Route::apiResource('question/{question}/answers', AnswerController::class);
        Route::post('question/{question}/likes', [QuestionLikeController::class, 'store']);
    });

});