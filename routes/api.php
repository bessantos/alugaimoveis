<?php

use App\Http\Controllers\Api\CasasControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('casas', [CasasControllerApi::class, 'index']);
Route::get('casas/{id}', [CasasControllerApi::class, 'show']);
Route::post('loginapi', [CasasControllerApi::class, 'loginapi']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});