<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('frontend-user-login', 'UserAPIController@frontendUserLogin');
Route::post('frontend-user-register', 'UserAPIController@frontendUserRegister');

Route::group(['middleware' => ['auth.jwt']], function() {
    Route::resource('articles', 'ArticleAPIController');
});

Route::post('connexion','UserAPIController@login');

Route::resource('statuses', 'statusAPIController');

Route::resource('coaches', 'coachAPIController');

Route::resource('domaines', 'domaineAPIController');

Route::resource('pointages', 'pointageAPIController');

Route::resource('bakelistes', 'bakelisteAPIController');

Route::resource('visiteurs', 'visiteurAPIController');

Route::resource('reportings', 'reportingAPIController');

Route::resource('programmation_horaires', 'programmation_horaireAPIController');

Route::resource('taches', 'tacheAPIController');

Route::resource('task_files', 'task_filesAPIController');

Route::resource('task_urls', 'task_urlAPIController');

Route::resource('using_links', 'using_linksAPIController');

Route::resource('admins', 'adminAPIController');
