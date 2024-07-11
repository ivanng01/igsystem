<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    ])->group(function(){
    Route::get('/dashboard', function(){
    return view('/dashboard');
    })->name('dashboard');
    Route::resource('students',StudentController::class);
    Route::resource('subjects',SubjectController::class);
    Route::resource('courses',CourseController::class);
    Route::resource('assistances',AssistanceController::class);

    Route::get('/assistances/{student}/edit', [AssistanceController::class, 'edit'])->name('assistances.edit');
    Route::put('/assistances/{student}', [AssistanceController::class, 'update'])->name('assistances.update');

    Route::resource('filters',FilterController::class);
    Route::resource('observations',ObservationController::class);
    Route::get('/observations/create/{student_id}', [ObservationController::class, 'create'])->name('observations.create');
    
    Route::post('reportAsistances',[ReportController::class, 'reportAsistances'])->name('reports.reportAsistances');
    Route::post('reportObservations',[ReportController::class, 'reportObservations'])->name('reports.reportObservations');
    Route::post('reportAlumns',[ReportController::class, 'reportAlumns'])->name('reports.reportAlumns');

});
