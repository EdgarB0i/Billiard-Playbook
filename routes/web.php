<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SigninController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileConversionController;
use App\Http\Controllers\ZipConversionController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Signup
Route::get('/signup', [SignupController::class, 'showSignupForm']);
Route::post('/signup', [SignupController::class, 'signup']);

// SignIn
Route::get('/signin', [SigninController::class, 'showSigninForm'])->name('signin');
Route::post('/signin', [SigninController::class, 'signin']);

//SignOut
Route::get('/signout', function () {
    Auth::logout();
    return redirect('/');
})->name('signout');


// Login with Facebook
Route::get('/login/facebook/', [SigninController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('/login/facebook/callback', [SigninController::class, 'handleFacebookCallback']);



//Converter pdf and zip
Route::post('/convert', [FileConversionController::class, 'convert'])->name('convert');
Route::post('/convertzip', [ZipConversionController::class, 'convert'])->name('convertzip');


//downloadpdf
Route::get('/download-latest-converted-csv', [FileConversionController::class, 'downloadLatestConvertedCSV'])
    ->name('download-latest-converted-csv');

//download zip
Route::get('/download-converted-zip', [ZipConversionController::class, 'downloadConvertedZip'])->name('download-converted-zip');


Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/download-csv/{opponent_name}/{game_date}', [DashboardController::class, 'downloadCSV'])->name('downloadCSV');
});





