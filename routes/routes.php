<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('/login/{provider?}', [
        'uses' => '\Klsandbox\SocialRoute\Http\Controllers\SocialController@getSocialAuth',
        'as' => 'auth.getSocialAuth'
    ]);


    Route::get('/login/callback/{provider?}', [
        'uses' => '\Klsandbox\SocialRoute\Http\Controllers\SocialController@getSocialAuthCallback',
        'as' => 'auth.getSocialAuthCallback'
    ]);

});
