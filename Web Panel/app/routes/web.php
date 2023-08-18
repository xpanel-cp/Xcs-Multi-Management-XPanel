<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DahboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OnlineController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FixerController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\TransresController;

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
    return redirect('/login');
});
Route::get('/detail/{key}',[DetailController::class,'index'])->name('detail');
Route::post('/detail/{key}',[DetailController::class,'update'])->name('update');

Route::prefix('cp')->group(function()
{
    Route::get('/dashboard',[DahboardController::class,'index'])->name('dashboard');
    Route::get('/users',[UserController::class,'index'])->name('users');
    Route::post('/users',[UserController::class,'newuser'])->name('new.user');
    Route::post('/users/bulk',[UserController::class,'bulkuser'])->name('new.bulkuser');
    Route::get('/user/active/{username}',[UserController::class,'activeuser'])->name('user.active');
    Route::get('/user/deactive/{username}',[UserController::class,'deactiveuser'])->name('user.deactive');
    Route::get('/user/reset/{username}',[UserController::class,'reset_traffic'])->name('user.reset');
    Route::get('/user/delete/{username}',[UserController::class,'delete'])->name('user.delete');
    Route::post('/user/delete/bulk',[UserController::class,'delete_bulk'])->name('user.delete.bulk');
    Route::get('/user/renewal/{username}',[UserController::class,'renewal_edit'])->name('new.renewal.edit');
    Route::post('/user/renewal',[UserController::class,'renewal'])->name('new.renewal');
    Route::post('/user/server',[UserController::class,'change_server'])->name('new.server');
    Route::get('/user/edit/{username}',[UserController::class,'edit'])->name('user.edit');
    Route::post('/user/edit',[UserController::class,'update'])->name('user.update');
    Route::get('/online',[OnlineController::class,'index'])->name('online');
    Route::get('/online/id/{pid}',[OnlineController::class,'kill_pid'])->name('online.kill.pid');
    Route::get('/online/user/{username}',[OnlineController::class,'kill_user'])->name('online.kill.username');
    Route::get('/invoice',[TransresController::class,'index'])->name('invoice');
    Route::get('/settings',[SettingsController::class,'defualt'])->name('setting');
    Route::get('/settings/{name}',[SettingsController::class,'index'])->name('settings');
    Route::get('/settings/server/delete/{id}',[SettingsController::class,'delete_server'])->name('settings.delete.server');
    Route::get('/settings/server/{id}',[SettingsController::class,'edit_server'])->name('settings.edit.server');
    Route::post('/settings/server/update',[SettingsController::class,'update_server'])->name('settings.update.server');
    Route::post('/settings/server',[SettingsController::class,'add_server'])->name('settings.addserver');
    Route::post('/settings/telegram',[SettingsController::class,'update_telegram'])->name('settings.telegram');
    Route::post('/settings/backup',[SettingsController::class,'import_old'])->name('settings.backup.old');
    Route::post('/settings/backup/new',[SettingsController::class,'upload_backup'])->name('settings.backup.upload');
    Route::get('/settings/backup/delete/{name}',[SettingsController::class,'delete_backup'])->name('settings.backup.delete');
    Route::get('/settings/backup/restore/{name}',[SettingsController::class,'restore_backup'])->name('settings.backup.restore');
    Route::post('/settings/backup/make/',[SettingsController::class,'make_backup'])->name('settings.backup.make');
    Route::get('/settings/backup/dl/{name}',[SettingsController::class,'download_backup'])->name('settings.backup.dl');
    Route::post('/settings/api',[SettingsController::class,'insert_api'])->name('settings.api');
    Route::get('/settings/api/renew/{id}',[SettingsController::class,'renew_api'])->name('settings.token.renew');
    Route::get('/settings/api/delete/{id}',[SettingsController::class,'delete_api'])->name('settings.token.delete');
    Route::get('/package',[PackagesController::class,'index'])->name('package');
    Route::get('/package/edit/{id}',[PackagesController::class,'edit'])->name('package.edit');
    Route::get('/package/delete/{id}',[PackagesController::class,'delete'])->name('package.delete');
    Route::post('/package',[PackagesController::class,'insert'])->name('package.insert');
    Route::post('/package/upsate',[PackagesController::class,'update'])->name('package.update');
    Route::get('/managers',[AdminsController::class,'index'])->name('admins');
    Route::post('/managers',[AdminsController::class,'insert'])->name('admin.new');
    Route::get('/managers/active/{username}',[AdminsController::class,'activeadmin'])->name('admin.active');
    Route::get('/managers/deactive/{username}',[AdminsController::class,'deactiveadmin'])->name('admin.deactive');
    Route::get('/managers/delete/{username}',[AdminsController::class,'deleteadmin'])->name('admin.delete');
    Route::get('/managers/edit/{username}',[AdminsController::class,'edit'])->name('admin.edit');
    Route::post('/manager/update',[AdminsController::class,'update'])->name('admin.update');
    Route::get('/documents',[DocumentController::class,'index'])->name('document');
    Route::get('/logout',[LoginController::class,'logout'])->name('user.logout');


});
/*
Route::prefix('api')->group(function()
{
    Route::get('/{token}/listuser',[ApiController::class,'listuser'])->name('api.listuser');
    Route::get('/{token}/listuser/{sort}',[ApiController::class,'sort_listuser'])->name('api.listuser.sort');
    Route::post('/adduser',[ApiController::class,'add_user'])->name('api.add.user');
    Route::get('/{token}/user/{username}',[ApiController::class,'show_detail'])->name('api.show.detail');
    Route::post('/edituser',[ApiController::class,'edit'])->name('api.user.edit');
    Route::post('/delete',[ApiController::class,'delete_user'])->name('api.user.delete');
    Route::post('/active',[ApiController::class,'active_user'])->name('api.user.active');
    Route::post('/deactive',[ApiController::class,'deactive_user'])->name('api.user.deactive');
    Route::post('/retraffic',[ApiController::class,'retraffic_user'])->name('api.user.retraffic');
    Route::post('/renewal',[ApiController::class,'renewal_user'])->name('api.user.renewal');
    Route::get('/{token}/online',[ApiController::class,'online_user'])->name('api.user.online');
});
*/
Route::prefix('fixer')->group(function() {
    Route::get('/exp', [FixerController::class, 'cronexp'])->name('exp');
});
Auth::routes();
