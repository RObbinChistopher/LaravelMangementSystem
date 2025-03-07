<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');


Route::post('/download-service-invoice', [ServiceController::class, 'generatePDF']);
Route::get('/index-voice', [ServiceController::class, 'index']);