<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Yasser\Agora\RtcTokenBuilder;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    $appID = env('AGORA_APP_ID');
    $appCertificate = env('AGORA_APP_CERTIFICATE');

    $channelName = "testing3";
    $uid = 123;
    $role = RtcTokenBuilder::RoleSubscriber;
    $expireTimeInSeconds = 3600 * 24;
    $currentTimestamp = now()->getTimestamp();
    $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

    return $rtcToken = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
});
Route::get('realtime', function () {
    return view('realtime');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/index', function () {
    $appID = env('AGORA_APP_ID');
    $appCertificate = env('AGORA_APP_CERTIFICATE');

    $channelName = request('channel');
    $uid = Auth::user()->id;
    $role = RtcTokenBuilder::RoleSubscriber;
    $expireTimeInSeconds = 60;
    $currentTimestamp = now()->getTimestamp();
    $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

    $rtcToken = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
    return view('index', [
        'channel' => $channelName,
        'token' => $rtcToken,
        'user_id' => $uid
    ]);
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
