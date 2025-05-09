<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');
Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('applyJob');
Route::post('/save-job', [JobsController::class, 'saveJob'])->name('saveJob');


Route::group(['prefix' => 'account'], function(){

    Route::group(['middleware' => 'guest'], function(){
        Route::get('/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/process-register',[AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::post('/authenticate', [AccountController::class, 'authentication'])->name('account.authenticate');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
        Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');

        Route::get('/my-jobs/edit/{jobId}', [AccountController::class, 'editJob'])->name('account.editJob');
        Route::post('/update-job/{jobId}', [AccountController::class, 'updateJob'])->name('account.updateJob');
        Route::post('/delete-job', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
        Route::get('/my-jobs-applications', [AccountController::class, 'myJobApplications'])->name('account.myJobApplications');

        Route::post('/remove-job-application', [AccountController::class, 'removeJobs'])->name('account.removeJobs');

        
        Route::get('/saved-jobs', [AccountController::class, 'savedJobs'])->name('account.savedJobs');

        Route::post('/remove-saved-job', [AccountController::class, 'removesavedJobs'])->name('account.removesavedJobs');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
        
    });
});