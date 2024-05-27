<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\calcController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AdminController;
// Route::get('/', function () {
//     return view('calc');
// });
Route::get('/',[calcController::class,'index']);
Route::get('calc',[calcController::class,'index']);
// Route::get('pay',[calcController::class,'pay']);
Route::get('cost',[calcController::class,'showcost']);
Route::post('search',[calcController::class,'search']);
Route::get('search', function () {
    return view('search');
});
Route::get('login', function () {
    return view('login');
});
Route::post('login',[LogController::class,'login']);

Route::get('pay', [calcController::class,'showpay']);
Route::get('paybill', [calcController::class,'pay']);
Route::post('calc',[calcController::class,'calc']);
Route::post('login',[LogController::class,'login']);
Route::post('register',[LogController::class,'register']);
Route::get('register', function () {
    return view('register');
});
Route::get('logout',[LogController::class,'logout']);
Route::get('admin', function () {
    return view('home_admin');
});
Route::post('pay',[calcController::class,'pay']);
Route::get('customer',[AdminController::class,'customer']);
Route::get('changerole',[AdminController::class,'changerole']);
Route::get('deletecus',[AdminController::class,'deletecus']);
Route::get('kwh',[AdminController::class,'showcuskwh']);
Route::post('updatekwh',[AdminController::class,'updatekwh']);
Route::get('showcost',[AdminController::class,'showcost']);
Route::post('updatecost',[AdminController::class,'updatecost']);
Route::get('bill',[AdminController::class,'showbill']);
Route::get('closebill',[AdminController::class,'closebill']);
Route::get('noti',[AdminController::class,'noti']);