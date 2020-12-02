<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'verify' => false,
]);

Route::view('users/register', 'auth.user-register')->middleware(['invitation', 'guest']);
Route::view('users/success', 'auth.user-success')->middleware('guest');
Route::view('invitations/success', 'auth.invitation-success')->middleware('guest');

Route::redirect('/', 'login');

Route::get('logout', 'Auth\LoginController@logout');
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('response', 'PaymentController@success');
Route::get('rejected', 'PaymentController@rejected');

Route::get('/{view}', 'SPAController@index')->where('view', '.*')->middleware('auth');
