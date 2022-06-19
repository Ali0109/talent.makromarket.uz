<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController as UserAuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ConfigController;

Route::redirect('/', '/login');
Route::get('/change/{locale}', [ConfigController::class, 'changeLang'])->name('change_locale');
Route::get('/add_employees_list', [ConfigController::class, 'add_employees_list']);

Route::group(['middleware' => 'set_locale'], function () {
    Route::get('/members', [MainController::class, 'members'])->name('members');
    Route::get('/talents/{user_id}', [MainController::class, 'talents'])->name('talents');
    Route::post('/like_talent_cookie', [MainController::class, 'likeTalentCookie'])->name('like_talent_cookie');
    Route::get('/login', [UserAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'loginPost'])->name('login_post');
    Route::get('/login_check/{id}', [UserAuthController::class, 'smsCheckForm'])->name('sms_check');
    Route::post('/login_check', [UserAuthController::class, 'smsCheckPost'])->name('sms_check_post');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::group(['middleware' => 'auth:web', 'prefix' => 'user'], function () {
         Route::get('/', [UserHomeController::class, 'index'])->name('auth.user.index');
         Route::post('/file_store', [UserHomeController::class, 'fileStore'])->name('auth.user.file_store');
         Route::get('/success_talent', [UserHomeController::class, 'successTalent'])->name('auth.user.success_talent');
         Route::get('/like_talent/{talent_id}', [UserHomeController::class, 'likeTalent'])->name('auth.user.like_talent');
    });
});

Route::get('/login/admin', [AdminAuthController::class, 'loginForm'])->name('admin.login');
Route::post('/login/admin', [AdminAuthController::class, 'loginPost'])->name('admin.login_post');
//'email' => 'admin@msmarket.com'
//'password' => 'MaKrO_Festivale_2022'

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], function() {
    Route::get('/', [AdminHomeController::class, 'index'])->name('auth.admin.index');
});
