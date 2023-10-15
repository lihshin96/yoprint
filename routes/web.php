<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UploadHistoryController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::controller(ProductController::class)->group(function(){
    Route::post('importCSV/import', 'processCSVFile')->name('importCSV.import');
});

Route::controller(UploadHistoryController::class)->group(function(){
    Route::get('/', 'index')->name('importCSV.index');
    Route::get('importCSV', 'index')->name('importCSV.index');
});

require __DIR__.'/auth.php';
