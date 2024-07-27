<?php

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

use App\Http\Controllers\API\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;
use App\Http\Controllers\API\SupportedMemory\DepositSupportedMemoryController;


// Mémoires soutenus
Route::group([/* 'middleware' => ["auth:sanctum", "verified", "permission:Consulter un Mémoire"] */], function () use($idRegex) {
    Route::get(uri : 'supportedMemory', action : [SupportedMemoryController::class, 'index'])
    ->name(name : 'supportedMemory.index');

    Route::patch(uri : '/download-memories', action : [SupportedMemoryController::class, 'downloadMemories'])
        ->name('download-memories');
});

Route::post(uri : 'deposit-memory', action : DepositSupportedMemoryController::class)
    ->name(name : 'deposit-memory')
    ->middleware(['auth:sanctum', 'verified', 'Déposer un Mémoire']);

Route::patch('download-memory/{supportedMemory}', [SupportedMemoryController::class, 'downloadMemory'])
    ->name(name : 'download-memory')
    ->where(['supportedMemory' => $idRegex])
    /* ->middleware(['auth:sanctum', 'verified', 'Télécharger un Mémoire']) */;


// Pour les fichiers
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


// Articles
Route::group([/* 'middleware' => ["auth:sanctum", "verified", "permission:Consulter un Livre"] */], function () use($idRegex) {
    Route::get(uri : 'article', action : [ArticleController::class, 'index'])
    ->name(name : 'article.index');
});
