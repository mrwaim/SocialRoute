<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('/login/{provider?}', [
        'uses' => 'SocialController@getSocialAuth',
        'as' => 'auth.getSocialAuth'
    ]);


    Route::get('/login/callback/{provider?}', [
        'uses' => 'SocialController@getSocialAuthCallback',
        'as' => 'auth.getSocialAuthCallback'
    ]);

});
