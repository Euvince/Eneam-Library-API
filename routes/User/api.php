<?php

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\Loan\UserLoanController;
use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;
use App\Http\Controllers\API\SupportedMemory\DepositSupportedMemoryController;


// Mémoires soutenus
Route::get(uri : 'supportedMemory', action : [SupportedMemoryController::class, 'index'])
    ->name(name : 'supportedMemory.index')
    /* ->middleware(['auth:sanctum', 'verified', 'Consulter un Mémoire, Gérer les Mémoires Soutenus']) */;

Route::post(uri : 'deposit-memory', action : DepositSupportedMemoryController::class)
    ->name(name : 'deposit-memory')
    /* ->middleware(['auth:sanctum', 'verified', 'Déposer un Mémoire']) */;


Route::group([/* 'middleware' => ["auth:sanctum", "verified", "permission:Télécharger un Mémoire"] */], function () use($idRegex) {
    Route::patch('download-memory/{supportedMemory}', [SupportedMemoryController::class, 'downloadMemory'])
    ->name(name : 'download-memory')
    ->where(['supportedMemory' => $idRegex]);

    Route::patch(uri : '/download-memories', action : [SupportedMemoryController::class, 'downloadMemories'])
        ->name('download-memories');
});

// Articles
Route::get(uri : 'article', action : [ArticleController::class, 'index'])
    ->name(name : 'article.index')
    /* ->middleware(['auth:sanctum', 'verified', 'Consulter un Livre, Gérer les Articles']) */;


// Commentaires
Route::group([/* 'middleware' => ["auth:sanctum", "verified", "permission:Voir les Commentaires"] */], function () use($idRegex) {
    Route::apiResource(name : 'article.comment', controller : CommentController::class);
});
Route::group([/* 'middleware' => ["auth:sanctum", "verified", "permission:Gérer les Commentaires"] */], function () use($idRegex) {
    Route::delete(uri : '/destroy-comments', action : [CommentController::class, 'destroyComments'])
    ->name('destroy-comments');
});


// Emprunts Borrower
Route::group([/* 'middleware' => ["auth:sanctum", "verified", "permission:Prêter un Livre"] */], function () use($idRegex) {
    Route::get(uri : '/can-do-loan-request/{article}', action : [UserLoanController::class, 'canDoLoanRequest'])
    ->name(name : 'can-do-loan-request')
    ->where(['article' => $idRegex]);

    Route::post(uri : '/do-loan-request/{article}', action : [UserLoanController::class, 'doLoanRequest'])
        ->name(name : 'do-loan-request')
        ->where(['article' => $idRegex]);

    Route::get(uri : '/can-reniew-loan-request/{loan}', action : [UserLoanController::class, 'canReniewLoanRequest'])
        ->name(name : 'can-reniew-loan-request')
        ->where(['loan' => $idRegex]);

    Route::patch(uri : '/reniew-loan-request/{loan}', action : [UserLoanController::class, 'reniewLoanRequest'])
        ->name(name : 'reniew-loan-request')
        ->where(['loan' => $idRegex]);

    Route::delete(uri : '/cancel-loan-request/{loan}', action : [UserLoanController::class, 'cancelLoanRequest'])
        ->name(name : 'cancel-loan-request')
        ->where(['loan' => $idRegex]);
});


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
