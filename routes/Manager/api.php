<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\KeywordController;
use App\Http\Controllers\API\SoutenanceController;
use App\Http\Resources\Configuration\ConfigurationResource;
use App\Http\Responses\Configuration\SingleConfigurationResponse;
use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;
use App\Http\Controllers\API\Configuration\UpdateConfigurationController;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

// Configurations

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
        Route::patch(uri : 'school-name', action : UpdateConfigurationController::class)
            ->name(name : 'school-name');
        Route::patch(uri : 'school-acronym', action : UpdateConfigurationController::class)
            ->name(name : 'school-acronym');
        Route::patch(uri : 'school-city', action : UpdateConfigurationController::class)
            ->name(name : 'school-city');
        Route::patch(uri : 'archivist-full-name', action : UpdateConfigurationController::class)
            ->name(name : 'archivist-full-name');
        Route::patch(uri : 'eneamien-subscribe-amount', action : UpdateConfigurationController::class)
            ->name(name : 'eneamien-subscribe-amount');
        Route::patch(uri : 'extern-subscribe-amount', action : UpdateConfigurationController::class)
            ->name(name : 'extern-subscribe-amount');
        Route::patch(uri : 'subscription-expiration-delay', action : UpdateConfigurationController::class)
            ->name(name : 'subscription-expiration-delay');
        Route::patch(uri : 'student-debt-amount', action : UpdateConfigurationController::class)
            ->name(name : 'student-debt-amount');
        Route::patch(uri : 'teacher-debt-amount', action : UpdateConfigurationController::class)
            ->name(name : 'teacher-debt-amount');
        Route::patch(uri : 'student-loan-delay', action : UpdateConfigurationController::class)
            ->name(name : 'student-loan-delay');
        Route::patch(uri : 'teacher-loan-delay', action : UpdateConfigurationController::class)
            ->name(name : 'teacher-loan-delay');
        Route::patch(uri : 'student-renewals-number', action : UpdateConfigurationController::class)
            ->name(name : 'student-renewals-number');
        Route::patch(uri : 'teacher-renewals-number', action : UpdateConfigurationController::class)
            ->name(name : 'teacher-renewals-number');
        Route::patch(uri : 'max-books-per-student', action : UpdateConfigurationController::class)
            ->name(name : 'max-books-per-student');
        Route::patch(uri : 'max-books-per-teacher', action : UpdateConfigurationController::class)
            ->name(name : 'max-books-per-teacher');
        Route::patch(uri : 'max-copies-books-per-student', action : UpdateConfigurationController::class)
            ->name(name : 'max-copies-books-per-student');
        Route::patch(uri : 'max-copies-books-per-teacher', action : UpdateConfigurationController::class)
            ->name(name : 'max-copies-books-per-teacher');
    });

});

// Années scolaires
Route::get(uri : 'schoolYear', action : [ SchoolYearController::class, 'index'])
    ->name(name : 'schoolYear.index');


// Soutenances
Route::apiResource(name : 'soutenance', controller : SoutenanceController::class);

Route::get(uri : '/check-soutenance-childrens/{soutenance}', action : [App\Http\Controllers\API\SoutenanceController::class, 'checkChildrens'])
    ->name('check-soutenance-childrens')
    ->where(['soutenance' => $idRegex]);

Route::delete(uri : '/destroy-soutenances', action : [App\Http\Controllers\API\SoutenanceController::class, 'destroySoutenances'])
    ->name('destroy-soutenances');


// Mémoires soutenus
Route::get(uri : 'supportedMemory/no-pagination', action : [ SupportedMemoryController::class, 'indexWithoutPagination'])
    ->name(name : 'supportedMemory.index.no-pagination');

Route::apiResource(name : 'supportedMemory', controller : SupportedMemoryController::class)
    ->except(methods : ['store']);

Route::patch('validate-memory/{supportedMemory}', [SupportedMemoryController::class, 'validateMemory'])
    ->name(name : 'validate-memory')
    ->where(['supportedMemory' => $idRegex]);

Route::patch(uri : '/validate-memories', action : [SupportedMemoryController::class, 'validateMemories'])
    ->name('validate-memories');

Route::patch('reject-memory/{supportedMemory}', [SupportedMemoryController::class, 'rejectMemory'])
    ->name(name : 'reject-memory')
    ->where(['supportedMemory' => $idRegex]);

Route::get(uri : 'print-filing-report/{supportedMemory}', action : [SupportedMemoryController::class, 'printFilingReport']);

Route::post(uri : '/print-reports', action : [SupportedMemoryController::class, 'printReports'])
    ->name('print-reports');

Route::delete(uri : '/destroy-memories', action : [SupportedMemoryController::class, 'destroyMemories'])
    ->name('destroy-memories');


// Article
Route::get(uri : 'article/no-pagination', action : [ ArticleController::class, 'indexWithoutPagination'])
    ->name(name : 'article.index.no-pagination');

Route::apiResource(name : 'article', controller : ArticleController::class);

Route::get(uri : '/check-article-childrens/{article}', action : [App\Http\Controllers\API\ArticleController::class, 'checkChildrens'])
    ->name('check-article-childrens')
    ->where(['article' => $idRegex]);

Route::delete(uri : '/destroy-articles', action : [App\Http\Controllers\API\ArticleController::class, 'destroyArticles'])
    ->name('destroy-articles');


// Mots clés
Route::get(uri : 'keyword', action : [ KeywordController::class, 'index'])
    ->name(name : 'keywords.index');


// Commentaires
Route::apiResource(name : 'article.comment', controller : CommentController::class);

// Emprunts
Route::apiResource(name : 'loan', controller : LoanController::class);
