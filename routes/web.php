<?php

use App\Http\Controllers\API\SupportedMemory\SupportedMemoryController;
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

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-]+';

Route::get('/', function () {
    return view('welcome');
});

Route::controller(UserController::class)->group(function(){
    Route::get(uri : 'users', action : 'getUsers')->name('users.getUsers');
    /* Route::get(uri : 'users-export', action : 'export')->name('users.export'); */
    Route::post(uri : 'import-teachers', action : 'import')->name('teachers.import');
    Route::post(uri : 'import-eneamiens-students', action : 'import')->name('eneamiens.students.import');
});

Route::controller(SupportedMemoryController::class)->group(function(){
    Route::get(uri : 'memories', action : 'getMemories')->name('memories.getMemories');
    Route::post(uri : 'import-pdfs-reports', action : 'importPdfsReports')->name(name : 'import.pdfs.reports');
    Route::post(uri : 'import-words-reports', action : 'importWordsReports')->name(name : 'import.words.reports');
});

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
