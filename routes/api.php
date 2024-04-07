<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(["prefix" => "/auth"], function () {

});

Route::group(["prefix" => "/categories", "middleware" => "auth:sanctum"], function () {

});

Route::group(["prefix" => "/todos", "middleware" => "auth:sanctum"], function () {

});
