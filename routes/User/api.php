<?php

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;
use App\Http\Controllers\API\SupportedMemory\DepositSupportedMemoryController;


// Mémoires soutenus
Route::post(uri : 'deposit-memory', action : DepositSupportedMemoryController::class)
    ->name(name : 'deposit-memory');

Route::get('download-memory/{supportedMemory}', [SupportedMemoryController::class, 'downloadMemory'])
    ->name(name : 'download-memory')
    ->where(['supportedMemory' => $idRegex]);

Route::get(uri : '/download-memories', action : [SupportedMemoryController::class, 'downloadMemories'])
    ->name('download-memories');
