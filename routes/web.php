<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\{TeamController,TeamMemberController,RaceController,RaceCheckpointController};
use App\Http\Controllers\{RaceLogController, ReportController};
use App\Http\Middleware\EnsureAdmin; 

Route::get('/', fn () => view('welcome'));

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware('auth')->get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

// Record checkpoint 
Route::get('/logs/create', [\App\Http\Controllers\RaceLogController::class, 'create'])->name('logs.create');
Route::post('/logs', [\App\Http\Controllers\RaceLogController::class, 'store'])->name('logs.store');
Route::get('/logs/next-checkpoint', [\App\Http\Controllers\RaceLogController::class,'next'])->name('logs.next');      // ?race_id=&member_id=
Route::get('/logs/members',        [\App\Http\Controllers\RaceLogController::class,'members'])->name('logs.members');  // ?race_id=

// Admin
Route::middleware(['auth', EnsureAdmin::class])  
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::resource('teams', \App\Http\Controllers\Admin\TeamController::class)->except(['show']);
        Route::resource('members', \App\Http\Controllers\Admin\TeamMemberController::class)->except(['show']);
        Route::resource('races', \App\Http\Controllers\Admin\RaceController::class)->except(['show']);

        Route::get('races/{race}/checkpoints', [\App\Http\Controllers\Admin\RaceCheckpointController::class,'index'])->name('races.checkpoints.index');
        Route::get('races/{race}/checkpoints/create', [\App\Http\Controllers\Admin\RaceCheckpointController::class,'create'])->name('races.checkpoints.create');
        Route::post('races/{race}/checkpoints', [\App\Http\Controllers\Admin\RaceCheckpointController::class,'store'])->name('races.checkpoints.store');
        Route::get('races/{race}/checkpoints/{checkpoint}/edit', [\App\Http\Controllers\Admin\RaceCheckpointController::class,'edit'])->name('races.checkpoints.edit');
        Route::put('races/{race}/checkpoints/{checkpoint}', [\App\Http\Controllers\Admin\RaceCheckpointController::class,'update'])->name('races.checkpoints.update');
        Route::delete('races/{race}/checkpoints/{checkpoint}', [\App\Http\Controllers\Admin\RaceCheckpointController::class,'destroy'])->name('races.checkpoints.destroy');

        Route::get('reports', function () {
    return view('reports.index', ['races' => \App\Models\Race::orderBy('race_name')->get()]);
})->name('reports.index');

// CSV

        Route::get('reports/race/{race}/csv', [\App\Http\Controllers\ReportController::class,'raceCsv'])->name('reports.race.csv');
        Route::get('reports/team/{race}/csv', [\App\Http\Controllers\ReportController::class,'teamCsv'])->name('reports.team.csv');

        Route::get('reports/race/{race}', [\App\Http\Controllers\ReportController::class,'race'])->name('reports.race');
        Route::get('reports/team/{race}', [\App\Http\Controllers\ReportController::class,'team'])->name('reports.team');
    });