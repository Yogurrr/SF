<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\FindController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailSendController;

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

// Route for Guest
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('login-perform2', [HomeController::class, 'loginPerform'])->name('login.perform2');
Route::get('logout', [HomeController::class, 'Logout'])->name('logout');

Route::get('/join', [JoinController::class, 'join'])->name('join');
Route::post('join-perform', [JoinController::class, 'joinPerform'])->name('join.perform');

Route::get('/find-userid', [FindController::class, 'findUserid'])->name('find-userid');
Route::get('/getUseridByEmail', [FindController::class, 'getUseridByEmail'])->name('getUseridByEmail');

Route::get('/find-password', [FindController::class, 'findPassword'])->name('find-password');
Route::post('/membershipPresence', [FindController::class, 'membershipPresence'])->name('membershipPresence');
Route::post('/updateTemporaryPassword', [FindController::class, 'updateTemporaryPassword'])->name('updateTemporaryPassword');



// Route for USer
Route::get('/calendar', [CalendarController::class, 'calendar'])->name('calendar');
Route::get('/getScheduleByDate', [CalendarController::class, 'getScheduleByDate'])->name('getScheduleByDate');

Route::post('add-schedule', [CalendarController::class, 'addSchedule'])->name('add-schedule');
Route::post('update-schedule', [CalendarController::class, 'updateSchedule'])->name('update-schedule');
Route::post('delete-schedule', [CalendarController::class, 'deleteSchedule'])->name('delete-schedule');
Route::post('move-schedule', [CalendarController::class, 'moveSchedule'])->name('move-schedule');

Route::post('add-todo', [CalendarController::class, 'addTodo'])->name('add-todo');
Route::post('update-todo', [CalendarController::class, 'updateTodo'])->name('update-todo');
Route::post('delete-todo', [CalendarController::class, 'deleteTodo'])->name('delete-todo');
Route::post('/save-checkbox-status', [CalendarController::class, 'saveStatus'])->name('save-checkbox-status');
Route::post('move-todo', [CalendarController::class, 'moveTodo'])->name('move-todo');

Route::get('/user', [UserController::class, 'user'])->name('user');
Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update-password');
Route::post('/delete-account', [UserController::class, 'deleteAccount'])->name('delete-account');





// test
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login-perform', [AuthController::class, 'customLogin'])->name('login.perform');
Route::get('register', [AuthController::class, 'registration'])->name('register');
Route::post('registration-perform', [AuthController::class, 'customRegistration'])->name('register.perform');
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');