<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::middleware('auth:sanctum')->get('/auth-user', function (Request $request) {
    return $request->user();
});



Route::get('/check-mbstring', function () {
    if (extension_loaded('mbstring')) {
        return 'Mbstring is installed and loaded.';
    } else {
        return 'Mbstring is not installed.';
    }
});

Route::get('/check-imagick', function () {
    if (extension_loaded('imagick')) {
        return 'Imagick is installed and loaded.';
    } else {
        return 'Imagick is not installed.';
    }
});

Route::get('/check-ghostscript', function () {
    $output = null;
    $retval = null;
    exec('gswin64c --version', $output, $retval);
    if ($retval == 0) {
        return 'Ghostscript is installed: ' . implode(' ', $output);
    } else {
        return 'Ghostscript is not installed.';
    }
});

