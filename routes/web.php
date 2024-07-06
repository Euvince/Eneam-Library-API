<?php

use App\Actions\SupportedMemory\GenerateReports;
use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Models\SupportedMemory;

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

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::get('/', function () {
    return view('welcome');
});

Route::controller(SupportedMemoryController::class)->group(function(){
    Route::get(uri : 'memories', action : 'getMemories')->name('memories.getMemories');
    Route::post(uri : 'import-pdfs-reports', action : 'importReports')->name(name : 'import.pdfs.reports');
    Route::post(uri : 'import-words-reports', action : 'importReports')->name(name : 'import.words.reports');
});

/* Route::get('/php-blade/{memory}', function (SupportedMemory $memory) {
    return GenerateReports::printReportUsingBladeView($memory);
});

Route::get('/php-word/{memory}', function (SupportedMemory $memory) {
    return GenerateReports::printReportUsingWord($memory);
});

Route::get('/php-blades', function (SupportedMemory $memory) {
    return GenerateReports::printReportsUsingBladeView($memory);
});

Route::get('/php-words', function (SupportedMemory $memory) {
    return GenerateReports::printReportsUsingWord($memory);
}); */



/* Route::get('generate-img-by-pdf', function () {
    $imagick = new Imagick(public_path('pdfs/file.pdf'));
    $imagick->readImage(public_path('pdfs/file.pdf'));
    $imagick->writeImage('converted.jpg', true);
    dd("done");
}); */

/* Route::get('/check-imagick', function () {
    if (extension_loaded('imagick')) {
        return 'Imagick is installed and loaded.';
    } else {
        return 'Imagick is not installed.';
    }
}); */

/* Route::get('/check-ghostscript', function () {
    $output = null;
    $retval = null;
    exec('gswin64c --version', $output, $retval);
    if ($retval == 0) {
        return 'Ghostscript is installed: ' . implode(' ', $output);
    } else {
        return 'Ghostscript is not installed.';
    }

    // $output = shell_exec('gswin64c -version');
    // return $output;

}); */
