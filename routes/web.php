<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationMatriculeController;
use App\Http\Controllers\DemandeAbsenceController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/',function(){
    return view('matricule');
})->name('mat');

Route::post('/search', [VerificationMatriculeController::class, 'search'])->name('search');


// Route::resource('/demande', DemandeAbsenceController::class);

Route::resource('demandes', DemandeAbsenceController::class);

Route::patch('demandes/{id}/status', [DemandeAbsenceController::class, 'updateStatus'])->name('demandes.updateStatus');
Route::patch('demandes/{id}/authorization', [DemandeAbsenceController::class, 'updateAuthorization'])->name('demandes.updateAuthorization');


Route::get('/absences', [DemandeAbsenceController::class, 'listAbsences'])->name('absences.index');


Route::get('/dash',function(){
    return view('Dashbord');
});
