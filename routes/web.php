<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiteMetaController;
use App\Http\Controllers\RootController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware'=>['auth']],function(){

    //Dashboad
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/',[BillController::class,'index']);

    //Service
    Route::get('/service/categories',[ServiceController::class,'categories'])->name('categories');
    Route::get('/service/dt-category',[ServiceController::class,'dtCategory']);
    Route::get('/service/new-category',[ServiceController::class,'newCategory']);
    Route::get('/service/new-category/{id}',[ServiceController::class,'newCategory']);

    //Category
    Route::get('/services',[ServiceController::class,'index'])->name('services');
    Route::get('/service/dt-service',[ServiceController::class,'dtService']);
    Route::get('/service/new-service',[ServiceController::class,'newService']);
    Route::get('/service/new-service/{id}',[ServiceController::class,'newService']);

    //Customer
    Route::get('/customers',[CustomerController::class,'index'])->name('customers');
    Route::get('/prospect',[CustomerController::class,'prospect'])->name('prospect');
    Route::get('/customer/dt-customer',[CustomerController::class,'dtCustomer']);
    Route::get('/customer/dt-prospect',[CustomerController::class,'dtProspect']);
    Route::get('/customer/new-customer',[CustomerController::class,'newCustomer']);
    Route::get('/customer/new-customer/{id}',[CustomerController::class,'newCustomer']);

    //Bill
    Route::get('/bills',[BillController::class,'index'])->name('bills');
    Route::get('/bill/dt-proforma',[BillController::class,'dtProforma']);
    Route::get('/bill/dt-canceled',[BillController::class,'dtCanceled']);
    Route::get('/bill/dt-bill',[BillController::class,'dtBill']);
    Route::get('/bill/new-bill',[BillController::class,'newBill'])->name('new-bill');
    Route::get('/bill/new-bill/{id}',[BillController::class,'newBill']);
    Route::get('/bill/new-bill-service',[BillController::class,'newBillService']);
    Route::get('/bill/detail-bill/{id}',[BillController::class,'detailBill']);
    Route::get('/bill/pdf/{id}', [BillController::class, 'billExportPdf']);

    //Agenda
    Route::get('/agenda',[AgendaController::class,'index'])->name('agenda');
    Route::get('/agenda/edit-event-category/{id}',[AgendaController::class,'editEventCategory']);

    //Profile
    Route::get('/user/show-profile/{id}',[UserController::class,'showProfile']);
    Route::get('/user/change-password/{id}',[UserController::class,'changePassword']);
    Route::get('/user/logout', [UserController::class, 'Logout'])->name('logout');
    Route::get('/users',[UserController::class,'index'])->name('users');
    Route::get('/user/dt-user',[UserController::class,'dtUser']);
    Route::get('/user/new-user',[UserController::class,'newUser'])->name('new-user');

    //Site meta
    Route::get('/settings',[SiteMetaController::class,'Settings'])->name('settings');


});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
});

Route::get('/home',[RootController::class,'index'])->name('index');
