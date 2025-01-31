<?php

use App\Http\Controllers\connexion;
use App\Http\Controllers\Menu;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\projet_Controller;
use App\Http\Controllers\Transactions\PaymentController as paiement; 
use App\Http\Controllers\admin\user_serviceController as user_service; 
use App\Http\Controllers\logController  as logs;
use App\Http\Controllers\serviceController  as service;
use App\Http\Controllers\depenseController  as depense;
use App\Http\Controllers\pdfController  as pdf;
use App\Http\Controllers\ProfileController;

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


Route::middleware(['auth'])->group(function () {
   

    Route::resource('profiles', ProfileController::class);
   
    Route::get('administrator', [Menu::class, 'administrator'])->name('administrator');
    Route::get('nouvelleDepense', [depense::class, 'nouvelle_depense'])->name('nouvelleDepense');
    Route::get('DocsTelecharger/{depense_id}', [depense::class, 'DocsTelecharger'])->name('DocsTelecharger');
    Route::get('user_menu', [Menu::class, 'user_menu'])->name('user_menu');

    Route::get('historique_depense/{service_id}', [depense::class, 'historique_depense'])->name('historique_depense');
    Route::post('submit_depense', [depense::class, 'submit_depense'])->name('submit_depense');

    Route::post('nouveauService', [service::class, 'nouveauService'])->name('nouveauService');
    Route::post('updateBudget', [service::class, 'updateBudget'])->name('updateBudget');


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

    ///////////////////////////////////////////////////////////////////

    //////////////////////   administration   //////////////////////

    ///////////////////////////////////////////////////////////////////

    Route::post('paid_om_momo', [projet_Controller::class, 'paid_om_momo'])->name('paid_om_momo');
    Route::post('redaction_soumission', [projet_Controller::class, 'redaction_soumission'])->name('redaction_soumission');
    Route::post('update_redaction', [projet_Controller::class, 'update_redaction'])->name('update_redaction');
    Route::get('update_view_redation/{work_id}',[projet_Controller::class, 'encrypting_view_redaction'])->name('update_view_redation');
    Route::get('encrypted_update_view_redation/{encryptedID}', [projet_Controller::class, 'update_view_redation'])->name('encrypted_update_view_redation');
    Route::get('form_paiement/{work_id}',[projet_Controller::class, 'encrypting_form_paiement'])->name('form_paiement');
    Route::get('encrypted_form_paiement/{encryptedID}', [projet_Controller::class, 'form_paiement'])->name('encrypted_form_paiement');
    
    
    ///////////////////////////////////////////////////////////////////

    ////////////////   Transaction   //////////////////////

    ///////////////////////////////////////////////////////////////////

    Route::controller(paiement::class)->group(function () {
        Route::get('addCredit', 'addCredit')->name('addCredit');
        Route::get('AddCreditAdmin/{Idclient}', 'AddCreditAdmin')->name('AddCreditAdmin');
        Route::get('historique_transaction', 'historique_transaction')->name('historique_transaction');
        Route::post('buyCredit', 'buyCredit')->name('buyCredit');
        Route::post('paiementCompteMytaswork', 'paiementCompteMytaswork')->name('paiementCompteMytaswork');
        Route::post('DeleteProjet', 'DeleteProjet')->name('DeleteProjet');
        Route::post('SubmitCreditAdmin', 'SubmitCreditAdmin')->name('SubmitCreditAdmin');
    });


     ///////////////////////////////////////////////////////////////////

    ////////////////   Logs   //////////////////////

    ///////////////////////////////////////////////////////////////////

    Route::controller(logs::class)->group(function () {
        Route::get('log_super', 'log_super')->name('log_super');
    });

});