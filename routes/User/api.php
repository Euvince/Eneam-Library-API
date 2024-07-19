<?php

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;
use App\Http\Controllers\API\SupportedMemory\DepositSupportedMemoryController;


// Mémoires soutenus
Route::post(uri : 'deposit-memory', action : DepositSupportedMemoryController::class)
    ->name(name : 'deposit-memory');

Route::patch('download-memory/{supportedMemory}', [SupportedMemoryController::class, 'downloadMemory'])
    ->name(name : 'download-memory')
    ->where(['supportedMemory' => $idRegex]);

Route::patch(uri : '/download-memories', action : [SupportedMemoryController::class, 'downloadMemories'])
    ->name('download-memories');


Route::get('/pdf/{filename}', function ($filename) {
    $path = storage_path('app/public/SupportedMemories/memories/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/epub/{filename}', function ($filename) {
    $path = storage_path('app/public/Articles/articles/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = 'application/epub+zip';

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
