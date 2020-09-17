<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('welcome');
});


//Verifying if the user has verified email or not.
Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::post('send-email\{id}', 'SendEmailController@sendEmail')->name('sendEmail');

    Route::post('save-draft\{id}', 'SendEmailController@saveToDraft')->name('saveDraft');

    Route::get('sent-emails', 'HomeController@fetchSentEmails')->name('fetchSentEmails');

    Route::get('draft-emails', 'HomeController@fetchDraftEmails')->name('fetchDraftEmails');

    Route::get('important-emails', 'HomeController@fetchImportantEmails')->name('fetchImportantEmails');

    Route::get('trash-emails', 'HomeController@fetchDeletedEmails')->name('fetchDeletedEmails');

    Route::get('delete-email/{email_id}', 'HomeController@deleteEmail')->name('deleteEmail');

    Route::get('restore-email/{id}', 'HomeController@restoreEmail')->name('restoreEmail');

    Route::get('permanent-delete-email/{id}', 'HomeController@permanentDeleteEmail')->name('permanentDeleteEmail');

    Route::get('view-email/{id}', 'HomeController@viewEmail')->name('viewEmail');

    Route::get('send-draft-email/{id}', 'HomeController@sendDraftEmailDataToModal')->name('sendDraftEmailDataToModal');

});
