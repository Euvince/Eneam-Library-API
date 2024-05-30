<?php

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SupportedMemory\DepositSupportedMemoryController;

Route::post(uri : 'deposit-memory', action : DepositSupportedMemoryController::class);
