<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SupervisorsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Supervisor\SupervisorHomeController;
use App\Http\Controllers\Supervisor\CategoriesController;
use App\Http\Controllers\Supervisor\ProductsController;
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
    Route::post('supervisors/multiple_delete', [SupervisorsController::class,'multiple_delete'])->name('supervisor.multiple_delete');
    Route::get('/supervisors_trashed', [SupervisorsController::class,'trash'])->name('supervisors.trashed');
    Route::get('supervisors/restore/one/{id}', [SupervisorsController::class, 'restore'])->name('supervisors.restore');
    Route::get('supervisors/terminate/one/{id}', [SupervisorsController::class, 'terminate'])->name('supervisors.terminate');

});

//supervisor
Route::group(['middleware' => ['auth:supervisor']], function() {
    Route::get('/supervisor/home', [SupervisorHomeController::class, 'index'])->name('supervisor.home');

    //tasks by supervisor
    Route::resource('categories', CategoriesController::class);
    Route::post('categories/multiple_delete', [CategoriesController::class,'multiple_delete'])->name('categories.multiple_delete');
    Route::get('/categories_trashed', [CategoriesController::class,'trash'])->name('categories.trashed');
    Route::get('categories/restore/one/{id}', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::get('categories/terminate/one/{id}', [CategoriesController::class, 'terminate'])->name('categories.terminate');


    Route::resource('products', ProductsController::class);
    Route::get('products/delete_image/{id}', [ProductsController::class,'delete_image'])->name('product.image.delete');

});

require __DIR__.'/auth.php';
