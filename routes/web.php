<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

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

Route::controller(UserController::class)->group(function(){
    Route::get('users', 'getUsers')->name('users.getUsers');
    Route::get('users-export', 'export')->name('users.export');
    Route::post('users-import', 'import')->name('users.import');
});

Route::get('generate-img-by-pdf', function () {
    $imagick = new Imagick();
    $imagick->readImage(public_path() . "\pdfs\\file.pdf");
    $imagick->writeImage('converted.jpg', true);
    dd("done");
});
