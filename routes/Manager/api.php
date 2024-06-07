<?php

use App\Http\Controllers\API\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SoutenanceController;
use App\Http\Resources\Configuration\ConfigurationResource;
use App\Http\Responses\Configuration\SingleConfigurationResponse;
use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;
use App\Http\Controllers\API\Configuration\UpdateConfigurationController;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::group(['prefix' => 'config', 'as' => 'config.'], function () {
    Route::get(
        uri : 'last',
        action : function () : SingleConfigurationResponse {
           /*  dd(\App\Models\Configuration::first()->getAttributes()); */
            return new SingleConfigurationResponse(
                statusCode : 200, allowedMethods : 'PATCH', message : "Configuration de l'année en cours",
                resource : new ConfigurationResource(resource : \App\Models\Configuration::appConfig())
            );
        }
    )->name(name : 'last');

    Route::group(['prefix' => 'update', 'as' => 'update.'], function () {
        Route::patch(uri : 'school-name', action : UpdateConfigurationController::class)->name(name : 'school-name');
        Route::patch(uri : 'school-acronym', action : UpdateConfigurationController::class)->name(name : 'school-acronym');
        Route::patch(uri : 'school-city', action : UpdateConfigurationController::class)->name(name : 'school-city');
        Route::patch(uri : 'archivist-full-name', action : UpdateConfigurationController::class)->name(name : 'archivist-full-name');
        Route::patch(uri : 'eneamien-subscribe-amount', action : UpdateConfigurationController::class)->name(name : 'eneamien-subscribe-amount');
        Route::patch(uri : 'extern-subscribe-amount', action : UpdateConfigurationController::class)->name(name : 'extern-subscribe-amount');
        Route::patch(uri : 'subscription-expiration-delay', action : UpdateConfigurationController::class)->name(name : 'subscription-expiration-delay');
        Route::patch(uri : 'student-debt-amount', action : UpdateConfigurationController::class)->name(name : 'student-debt-amount');
        Route::patch(uri : 'teacher-debt-amount', action : UpdateConfigurationController::class)->name(name : 'teacher-debt-amount');
        Route::patch(uri : 'student-loan-delay', action : UpdateConfigurationController::class)->name(name : 'student-loan-delay');
        Route::patch(uri : 'teacher-loan-delay', action : UpdateConfigurationController::class)->name(name : 'teacher-loan-delay');
        Route::patch(uri : 'student-renewals-number', action : UpdateConfigurationController::class)->name(name : 'student-renewals-number');
        Route::patch(uri : 'teacher-renewals-number', action : UpdateConfigurationController::class)->name(name : 'teacher-renewals-number');
        Route::patch(uri : 'max-books-per-student', action : UpdateConfigurationController::class)->name(name : 'max-books-per-student');
        Route::patch(uri : 'max-books-per-teacher', action : UpdateConfigurationController::class)->name(name : 'max-books-per-teacher');
        Route::patch(uri : 'max-copies-books-per-student', action : UpdateConfigurationController::class)->name(name : 'max-copies-books-per-student');
        Route::patch(uri : 'max-copies-books-per-teacher', action : UpdateConfigurationController::class)->name(name : 'max-copies-books-per-teacher');
    });

});

Route::apiResource(name : 'soutenance', controller : SoutenanceController::class);
Route::get(uri : 'supportedMemory/no-pagination', action :[ SupportedMemoryController::class, 'indexWithoutPagination'])->name(name : 'supportedMemory.index.no-pagination');
Route::apiResource(name : 'supportedMemory', controller : SupportedMemoryController::class)->except(methods : ['store']);
Route::patch('validate-memory/{supportedMemory}', [SupportedMemoryController::class, 'validateMemory'])
    ->name(name : 'validate-memory')
    ->where(['supportedMemory' => $idRegex]);
Route::patch('reject-memory/{supportedMemory}', [SupportedMemoryController::class, 'rejectMemory'])
    ->name(name : 'reject-memory')
    ->where(['supportedMemory' => $idRegex]);
Route::post(uri : 'print-filing-report/{supportedMemory}', action : [SupportedMemoryController::class, 'printFilingReport']);
Route::apiResource(name : 'article', controller : ArticleController::class);
