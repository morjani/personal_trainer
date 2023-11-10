<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Category
Route::post('/ajax/save-category',[AjaxController::class,'saveCategory']);
Route::post('/ajax/delete-category',[AjaxController::class,'deleteCategory']);

//Service
Route::post('/ajax/save-service',[AjaxController::class,'saveService']);
Route::post('/ajax/delete-service',[AjaxController::class,'deleteService']);

//Customer
Route::post('/ajax/save-customer',[AjaxController::class,'saveCustomer']);
Route::post('/ajax/delete-customer',[AjaxController::class,'deleteCustomer']);
Route::get('/ajax/search-city',[AjaxController::class,'searchCity']);


//Bill
Route::get('/ajax/bill-statis',[AjaxController::class,'billStatis']);
Route::get('/ajax/bill-suivi',[AjaxController::class,'billSuivi']);
Route::get('/ajax/search-customer',[AjaxController::class,'searchCustomer']);
Route::get('/ajax/search-service',[AjaxController::class,'searchService']);
Route::get('/ajax/get-service/{id}',[AjaxController::class,'getService']);
Route::post('/ajax/save-bill',[AjaxController::class,'saveBill']);
Route::post('/ajax/valid-proforma',[AjaxController::class,'validProforma']);
Route::post('/ajax/canceled-bill',[AjaxController::class,'canceledBill']);
Route::post('/ajax/delete-bill',[AjaxController::class,'deletedBill']);


//Agenda
Route::post('/ajax/save-event',[AjaxController::class,'saveEvent']);
Route::post('/ajax/delete-event',[AjaxController::class,'deleteEvent']);
Route::post('/ajax/update-event-category',[AjaxController::class,'updateEventCategory']);

//Profile
Route::post('/ajax/save-profile',[AjaxController::class,'saveProfile']);
Route::post('/ajax/update-password',[AjaxController::class,'updatePassword']);
Route::post('/ajax/check-password/{id}',[AjaxController::class,'checkPassword']);
Route::post('/ajax/save-user',[AjaxController::class,'saveUser']);

//Site meta
Route::post('/ajax/save-setting',[AjaxController::class,'saveSetting']);

//Event
Route::get('/ajax/get-event/{id}',[AjaxController::class,'getEvent']);
