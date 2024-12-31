<?php

use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware( 'auth' )->group( function () {
    Route::controller( AccountSettingController::class, )->prefix( 'account/setting' )->name( 'account.setting.' )->group( function () {
        Route::get( '/', 'edit' )->name( 'edit' );
        Route::patch( '/', 'update' )->name( 'update' );
        // Route::delete( '/', 'destroy' )->name( 'destroy' );
    } );
} );


// google login route
Route::get( '/google/redirect', [SocialAuthController::class, 'googleRedirect'] )->name( 'social.google.redirect' );

Route::get( '/google/callback', [SocialAuthController::class, 'googleCallback'] )->name( 'social.google.callback' );

require __DIR__ . '/userroutes.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';