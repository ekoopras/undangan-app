<?php

use App\Http\Controllers\InvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{slug}', [InvitationController::class, 'show']);
Route::post('/{slug}/wish', [InvitationController::class, 'storeWish'])->name('invitation.wish');
