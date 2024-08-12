<?php

use App\Http\Controllers\Auth\AuthentificationControllerApi as AuthAuthentificationControllerApi;
use App\Http\Controllers\BurgerControllerApi;
use App\Http\Controllers\UserControllerApi;
use App\Http\Controllers\AuthentificationControllerApi;
use App\Http\Controllers\CommandeBurgerAnnulerApi;
use App\Http\Controllers\CommandeBurgerApi;
use App\Http\Controllers\CommandeBurgerValideApi;
use App\Http\Controllers\dashboardApi;
use App\Http\Controllers\SommeCommandeApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('Burgers',BurgerControllerApi::class);
Route::apiResource('Commande',CommandeBurgerApi::class);
Route::apiResource('getValideCommande',CommandeBurgerValideApi::class);
Route::apiResource('CommandeAnnule',CommandeBurgerAnnulerApi::class);
Route::apiResource('SommeJournaliere',SommeCommandeApi::class);
// Route::apiResource('User',UserControllerApi::class);
Route::get('users',function(){
    return User::all();
});

Route::group(['namespace' => 'App\Http\Controllers\Auth'], function(){
    Route::post('/login',[AuthAuthentificationControllerApi::class,'login'])->name('api.login');
    // Route::post('/deconnection',[AuthAuthentificationControllerApi::class,'deconnection'])->name('api.login');
    Route::post('/Register',[AuthAuthentificationControllerApi::class,'Register'])->name('api.login');

});

Route::group(['namespace' => 'App\Http\Controllers'], function(){
    Route::get('/getCommandeValideeJourner',[dashboardApi::class,'getCommandeValideJournee'])->name('api.getCommandeValideJournee');
    Route::get('/getCommandeEnAttenteJourner',[dashboardApi::class,'getCommandeEnAttenteJournee']);
    Route::get('/getCommandeAnnuleeJourner',[dashboardApi::class,'getCommandeAnnuleeJournee']);
    Route::get('/getSommeJourner',[dashboardApi::class,'getSommeJournee']);
    Route::get('/sendMAil',[dashboardApi::class,'sendMAil']);
    Route::get('/getChart',[dashboardApi::class,'getChart']);
    Route::get('/getCommandeValideJourneeNonPayer',[dashboardApi::class,'getCommandeValideJourneeNonPayer']);
    Route::put('/ValidateCommande/{id}',[dashboardApi::class,'ValidateCommande']);
    Route::put('/update/{id}',[dashboardApi::class,'update']);
});
