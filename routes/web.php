<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SupervisorsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Supervisor\SupervisorHomeController;
use App\Http\Controllers\Supervisor\CategoriesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// route for landing page but now for redirect to login ...
Route::get('/', function () {
    return redirect(\route('login'));
});



//admin
Route::group(['middleware' => ['auth:web']], function() {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    //supervisor crud by admin tasks
    Route::resource('supervisors', SupervisorsController::class);
    Route::post('supervisors/change_status', [SupervisorsController::class,'change_status'])->name('supervisor.change_status');
    Route::delete('supervisors/multiple_delete', [SupervisorsController::class,'multiple_delete'])->name('supervisor.multiple_delete');
});

//supervisor
Route::group(['middleware' => ['auth:supervisor']], function() {
    Route::get('/supervisor/home', [SupervisorHomeController::class, 'index'])->name('supervisor.home');
    //supervisor crud by admin tasks
    Route::resource('categories', CategoriesController::class);
//    Route::post('supervisors/change_status', [SupervisorHomeController::class,'change_status'])->name('supervisor.change_status');
});

require __DIR__.'/auth.php';
