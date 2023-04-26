<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminuserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MatchmakingController;
use App\Http\Controllers\AdminTagsController;
use App\Http\Controllers\AdminSentencesController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\JustChattingController;
use App\Http\Controllers\BlockedController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('/');

/* these are the mail verification controller methods ----------------------------------------------------------------*/
Route::get('send-mail', [MailController::class, 'index']);
Route::get('/email-verify', [RegisteredUserController::class, 'verify'])
    ->name('email-verify');
Route::get('confirm-otp', [RegisteredUserController::class, 'confirm'])
    ->name('confirm-otp');

/* these are the QR-code verification controller methods -------------------------------------------------------------*/
Route::get('verification', [Controller::class, 'generateQR'])
    ->name('verification');
Route::get('/qr-verify', function () {
    return view('auth.qr-code');
})->name('qr.verify');

Route::get('/qr-accept/{id}/{type}', [Controller::class, 'statusQR'])
    ->name('qr-accept');

Route::get('/qr-decline/{id}/{type}', [Controller::class, 'statusQR'])
    ->name('qr-decline');

Route::get('/qr-redo/{id}', [Controller::class, 'statusQR'])
    ->name('qr-redo');

Route::get('/confirm-qr', [AuthenticatedSessionController::class, 'verifyQR'])
    ->name('confirm-qr');
/* main website app logic here -------------------------------------------------------------------------------------- */
Route::get('/dashboard', [Controller::class, 'dash'])
    ->middleware(['auth', 'verified'])->name('.dashboard');

Route::resource('enterprise', EnterpriseController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::post('/profile/images', [ProfileController::class, 'image'])->name('profile.images');

    Route::get('/matchmaking', [MatchmakingController::class, 'index'])->name('matchmaking.index');
    Route::post('/matchmaking/profile', [MatchmakingController::class, 'show'])->name('matchmaking.show');
    Route::post('/matchmaking/like', [MatchmakingController::class, 'like'])->name('matchmaking.like');
    Route::post('/matchmaking/decline', [MatchmakingController::class, 'decline'])->name('matchmaking.decline');
    Route::get('/matchmaking/{id}', [MatchmakingController::class, 'back'])->name('matchmaking.back');
});

// this route group is reserved for the admin user
Route::middleware('isAdmin')->group(function ()
{
    Route::resource('admin_users', AdminuserController::class);
    Route::resource('admin_tags', AdminTagsController::class);
    Route::resource('admin_sentences', AdminSentencesController::class);
});

Route::get('/chat', [JustChattingController::class, 'index'])->name('chat.index');

Route::get('/chat/{id}', [JustChattingController::class, 'match_chat']);

Route::post('/chat_with_user/{id}', [JustChattingController::class, 'chat_with_user'])->name('chat_with_user');

Route::post('/sentence/{id}', [JustChattingController::class, 'use_sentences'])->name('use_sentences');

Route::post('/unmatch', [JustChattingController::class, 'unmatch'])->name('unmatch');

Route::post('/block', [JustChattingController::class, 'block'])->name('block');

Route::get('/block_view', [BlockedController::class, 'index'])->name('blocked');

Route::post('/unblock/{id}', [BlockedController::class, 'unblock'])->name('unblock');



require __DIR__.'/auth.php';
