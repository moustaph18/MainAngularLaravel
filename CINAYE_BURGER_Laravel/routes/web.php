<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BurgersController;
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

//Inscription
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store']);


//Connexion
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'create'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'Login']);



Route::middleware(['auth'])->group(function(){
//Affiche
Route::get('/Liste', [BurgersController::class, 'Liste']);

//Page Ajout Burger
Route::get('/Ajout', [BurgersController::class, 'AjoutPage'])->name('Ajout');
Route::post('/Ajout', [BurgersController::class, 'Ajout'])->name('Ajout');

//Pour la modification d'un burger Modifier/id=2 
Route::get('/Modifier/id={id}', [BurgersController::class, 'ModificationPage']);
Route::post('/Modifier', [BurgersController::class, 'ModificationBurger'])->name('Modifier');

//Pour l'archivement d'un burger /Achivement/id={{$car->id}}
Route::get('/Achivement/id={id}', [BurgersController::class, 'Archiver']);


//Deconnexion
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'Logout'])->name('logout');

});




