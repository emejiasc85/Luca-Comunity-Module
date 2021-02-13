<?php

Route::namespace('v1')->prefix('v1')->group(function()
{   

    Route::middleware(['auth:sanctum'])->group( function(){
        Route::apiResource('/users', UserController::class);
        Route::apiResource('/school-levels', SchoolLevelController::class);
        Route::apiResource('/school-grades', SchoolGradeController::class);
        Route::apiResource('/courses', CourseController::class);
    });

});