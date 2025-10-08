<?php

use App\Http\Controllers\connexion;
use App\Http\Controllers\Menu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\user_serviceController as user_service;
use App\Http\Controllers\logController  as logs;
use App\Http\Controllers\serviceController  as service;
use App\Http\Controllers\depenseController  as depense;
use App\Http\Controllers\pdfController  as pdf;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;

//use Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/',  [connexion::class, 'identification'])->name('identification');

// Ensemble de route concernant l'authentification

Route::get('connexion', [connexion::class, 'connexion'])->name('connexion');
Route::get('identification', [connexion::class, 'identification'])->name('identification');
Route::post('verification', [connexion::class, 't_verification'])->name('verification');
Route::post('validation_inscription', [connexion::class, 'validation_inscription'])->name('validation_inscription');
Route::get('deconnexion', [connexion::class, 'deconnexion'])->name('deconnexion');
Route::get('inscription', [connexion::class, 'inscription'])->name('inscription');
Route::get('reset_password', [connexion::class, 'reset_password'])->name('reset_password');

Route::get('/abonnement', [SubscriptionController::class, 'index'])->name('subscription.page');
Route::get('/upgrade', [SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
Route::get('/upgrade/pro', [SubscriptionController::class, 'pro'])->name('subscription.pro');
Route::post('/pay/{plan}', [SubscriptionController::class, 'pay'])->name('subscription.pay');


Route::middleware(['auth'])->group(function () {

    // Free plan 

    Route::get('administrator', [Menu::class, 'administrator'])->name('administrator');
    Route::get('nouvelleDepense', [depense::class, 'nouvelle_depense'])->name('nouvelleDepense');
    Route::get('historique_depense/{service_id}', [depense::class, 'historique_depense'])->name('historique_depense');
    Route::get('afficherService', [service::class, 'index'])->name('afficherService');
    Route::get('editService/{service_id}', [service::class, 'editService'])->name('editService');
    Route::post('update_service', [service::class, 'update_service'])->name('update_service');
    Route::post('add_service', [service::class, 'update_service'])->name('add_service');

    Route::post('submit_depense', [depense::class, 'submit_depense'])->name('submit_depense');
    Route::post('updateBudget', [service::class, 'updateBudget'])->name('updateBudget');
    Route::get('edit_depense/{service_id}', [depense::class, 'edit_depense'])->name('edit_depense');
    Route::controller(logs::class)->group(function () {
        Route::get('log_super', 'log_super')->name('log_super');
    });

    Route::middleware(['check.plan'])->group(function () {
    Route::resource('profiles', ProfileController::class);
    Route::post('nouveauService', [service::class, 'nouveauService'])->name('nouveauService');
    Route::get('DocsTelecharger/{depense_id}', [depense::class, 'DocsTelecharger'])->name('DocsTelecharger');
    Route::get('user_menu', [Menu::class, 'user_menu'])->name('user_menu');
    Route::put('update_depense', [depense::class, 'update_depense'])->name('update_depense');
    Route::get('etat_service_pdf/{service_id}', [pdf::class, 'etat_service_pdf'])->name('etat_service_pdf');
    Route::get('etat_global_pdf', [pdf::class, 'etat_global_pdf'])->name('etat_global_pdf');
       
    //////////////////////   Users service   //////////////////////
    Route::post('nouvelUser', [user_service::class, 'nouvelUser'])->name('nouvelUser');
    Route::post('updateUser', [user_service::class, 'updateUser'])->name('updateUser');
    Route::post('destroyUser', [user_service::class, 'destroyUser'])->name('destroyUser');
    Route::post('ActivateOrdesactivateUser', [user_service::class, 'ActivateOrdesactivateUser'])->name('ActivateOrdesactivateUser');
    
    Route::get('userlist',[user_service::class, 'userlist'])->name('userlist');
    Route::get('updateUser_/{id}', [user_service::class, 'updateUser_'])->name('updateUser_');
    Route::get('formUser', [user_service::class, 'formUser'])->name('formUser');
});
 

     ///////////////////////////////////////////////////////////////////

    ////////////////   Logs   //////////////////////

    ///////////////////////////////////////////////////////////////////

    

});
