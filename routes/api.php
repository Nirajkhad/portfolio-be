<?php

use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\GeneralInfoController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;
use Illuminate\Support\Facades\Route;

/**
 * Public API endpoints
 */

// General Info - Portfolio Owner
Route::get('/portfolio', [GeneralInfoController::class, 'show'])
    ->name('portfolio.show');

Route::get('/general-infos', [GeneralInfoController::class, 'index'])
    ->name('general-infos.index');

// Experiences - Work History
Route::prefix('experiences')->group(function () {
    Route::get('/', [ExperienceController::class, 'index'])
        ->name('experiences.index');

    Route::get('/{id}', [ExperienceController::class, 'show'])
        ->name('experiences.show');
});

// Projects - Portfolio Projects
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])
        ->name('projects.index');

    Route::get('/featured', [ProjectController::class, 'featured'])
        ->name('projects.featured');
});

// Skills - Professional Skills
Route::prefix('skills')->group(function () {
    Route::get('/', [SkillController::class, 'index'])
        ->name('skills.index');

    Route::get('/grouped', [SkillController::class, 'grouped'])
        ->name('skills.grouped');
});

// Posts - Blog Posts
Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])
        ->name('posts.index');

    Route::get('/published', [PostController::class, 'published'])
        ->name('posts.published');

    Route::get('/{slug}', [PostController::class, 'show'])
        ->name('posts.show');
});
