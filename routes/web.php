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
    Route::get(uri : 'users', action : 'getUsers')->name('users.getUsers');
    Route::get(uri : 'users-export', action : 'export')->name('users.export');
    Route::post(uri : 'teachers-import', action : 'import')->name('teachers.import');
    Route::post(uri : 'eneamiens-import', action : 'import')->name('eneamiens.import');
});

/* Route::get('/test', function () {
    $soutenance = \App\Models\Soutenance::find(73);
    $soutenance->update(['number_memories_expected' => $soutenance->number_memories_expected - 1]);
}); */

/* Route::get('generate-img-by-pdf', function () {
    $imagick = new Imagick();
    $imagick->readImage(public_path() . "\pdfs\\file.pdf");
    $imagick->writeImage('converted.jpg', true);
    dd("done");
}); */
