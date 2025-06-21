<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AffiliatesInvitationApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/affiliates/invite', [AffiliatesInvitationApiController::class, 'invite'])->name('api.affiliates.invite');
