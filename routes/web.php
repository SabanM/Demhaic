<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DformController;
use App\Http\Controllers\CodingController;
use App\Http\Controllers\IdentifierController;
use App\Http\Controllers\FactorController;
use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/lang/{lang}', [HomeController::class, 'switchLang'])->name('lang.switch');

Route::get('/legal', [HomeController::class, 'legal'])->name('legal');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/test', [HomeController::class, 'test'])->name('test');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/remove/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');
    
    Route::get('/milestones', [HomeController::class, 'milestones'])->name('milestones');
    Route::post('/milestones/store', [HomeController::class, 'store_milestone'])->name('milestones.store');
    Route::post('/milestones/update', [HomeController::class, 'update_milestone'])->name('milestones.update');
    Route::post('/milestones/edit', [HomeController::class, 'edit_milestone'])->name('milestones.edit');
    Route::delete('/milestones/remove/{id}', [HomeController::class, 'remove_milestone'])->name('milestones.remove');
    Route::post('/milestones/reorder', [HomeController::class, 'reorder_milestone'])->name('milestones.reorder');
    Route::post('/milestones/finish/{id}', [HomeController::class, 'finish_milestone'])->name('milestones.finish');

    Route::get('/obstacles', [HomeController::class, 'obstacles'])->name('obstacles');
    Route::post('/obstacles/store', [HomeController::class, 'store_obstacle'])->name('obstacles.store');
    Route::post('/obstacles/update', [HomeController::class, 'update_obstacle'])->name('obstacles.update');
    Route::post('/obstacles/edit', [HomeController::class, 'edit_obstacle'])->name('obstacles.edit');
    Route::delete('/obstacles/remove/{id}', [HomeController::class, 'remove_obstacle'])->name('obstacles.remove');
    Route::post('/obstacles/finish/{id}', [HomeController::class, 'finish_obstacle'])->name('obstacles.finish');
    Route::post('/obstacles/reorder', [HomeController::class, 'reorder_obstacle'])->name('obstacles.reorder');


    // routes refresh data
    Route::get('/milestones/data', [HomeController::class, 'fetchMilestonesData'])->name('milestones.data');
    Route::get('/obstacles/data', [HomeController::class, 'fetchObstaclesData'])->name('obstacles.data');
    Route::get('/fuels/data', [HomeController::class, 'fetchFuelsData'])->name('fuels.data');


    Route::get('/fuels', [HomeController::class, 'fuels'])->name('fuels');
    Route::post('/fuels/store', [HomeController::class, 'store_fuel'])->name('fuels.store');
    Route::post('/fuels/edit', [HomeController::class, 'edit_fuel'])->name('fuels.edit');
    Route::delete('/fuels/remove/{id}', [HomeController::class, 'remove_fuel'])->name('fuels.remove');
    Route::post('/fuels/reorder', [HomeController::class, 'reorder_fuel'])->name('fuels.reorder');

    Route::get('/thesismap', [HomeController::class, 'thesismap'])->name('thesismap');

    Route::get('/diaries', [DiaryController::class, 'index'])->name('diaries');
    Route::get('/diaries/edit/{id}', [DiaryController::class, 'edit'])->name('diaries.edit');
    Route::put('/diaries/update/{id}', [DiaryController::class, 'update'])->name('diaries.update');
    Route::delete('/diaries/{id}', [DiaryController::class, 'destroy'])->name('diaries.destroy');

    Route::get('/reflections', [DiaryController::class, 'index_reflections'])->name('reflections');
    Route::get('/reflections/edit/{id}', [DiaryController::class, 'edit'])->name('reflections.edit');
    Route::put('/reflections/update/{id}', [DiaryController::class, 'update'])->name('reflections.update');
    Route::delete('/reflections/{id}', [DiaryController::class, 'destroy'])->name('reflections.destroy');

    Route::get('/progress', [HomeController::class, 'progress'])->name('progress');



    Route::get('/forms', [DformController::class, 'index'])->name('forms.index');
    Route::post('/forms/save', [DformController::class, 'create'])->name('forms.create');
    Route::get('/forms/save/test', [DformController::class, 'createw'])->name('forms.createw');
    // Route for editing a form
    Route::get('forms/{form}/edit', [DformController::class, 'edit'])->name('forms.edit');
    Route::post('forms/{form}/update', [DformController::class, 'update'])->name('forms.update');
    Route::get('forms/{form}/duplicate', [DformController::class, 'duplicate'])->name('forms.duplicate');
    // Route for deleting a form
    Route::delete('forms/{form}', [DformController::class, 'destroy'])->name('forms.destroy');
    Route::post('/forms/{form}/attach-user/{user}', [DformController::class, 'attachUser'])->name('forms.attachUser');
    
    Route::post('/forms/{id}/make-default', [DformController::class, 'makeDefault'])->name('forms.makeDefault');



    Route::get('/factors', [FactorController::class, 'index'])->name('factors.index');
    Route::delete('/factors/{factor}/delete', [FactorController::class, 'destroy'])->name('factors.destroy');
    Route::put('/factors/{factor}/edit', [FactorController::class, 'update'])->name('factors.edit');
    Route::post('/factors/create', [FactorController::class, 'store'])->name('factors.store');


    Route::get('/identifiers', [IdentifierController::class, 'index'])->name('identifiers.index');
    Route::delete('/identifiers/{identifier}/delete', [IdentifierController::class, 'destroy'])->name('identifiers.destroy');
    Route::put('/identifiers/{identifier}/edit', [IdentifierController::class, 'update'])->name('identifiers.edit');
    Route::post('/identifiers/create', [IdentifierController::class, 'store'])->name('identifiers.store');


    Route::post('/entries', [DformController::class, 'store'])->name('entries.store');


    Route::get('/admin/entries', [HomeController::class, 'entries'])->name('entries.index');
  //  Route::get('/admin/entries', [HomeController::class, 'entries'])->name('entries.index');
    Route::get('/admin/entries/export/{type}', [HomeController::class, 'exportEntries'])->name('entries.export');


    Route::get('forms/initial/{form}/complete', [DformController::class, 'initialForm'])->name('forms.initialForm');

    Route::post('/generate-response', [HomeController::class, 'generateResponse'])->name('generateResponse');

    Route::post('/generate-summary', [HomeController::class, 'generateSummary'])->name('generateSummary');
    Route::get('/testLlama/{question}', [HomeController::class, 'testLlama'])->name('testLlama');

    Route::get('/getinsights', [DformController::class, 'insights'])->name('getinsights');

    Route::get('/coding/test', [CodingController::class, 'test'])->name('coding.test');



});


Route::get('/password/reset-security', [PasswordResetController::class, 'resetWithSecurityQuestions'])
    ->name('password.resetWithSecurityQuestions');

Route::get('/password/get-security', [PasswordResetController::class, 'getSecurityQuestions'])
->name('password.getSecurityQuestions');

Route::post('/password/update-password', [PasswordResetController::class, 'updateSecurityQuestions'])->name('updateSecurityQuestions');



require __DIR__.'/auth.php';