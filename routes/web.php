<?php

use App\Http\Controllers\ProjectInvitationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::middleware('auth')->group(function () {
    Route::resource('projects', ProjectController::class)->except(['edit']);

    Route::resource('projects.tasks', ProjectTasksController::class)->only(['store', 'update', 'destroy']);

    Route::post('projects/{project}/invitations', [ProjectInvitationController::class, 'store'])->name('invitations.store');
});



require __DIR__ . '/auth.php';
