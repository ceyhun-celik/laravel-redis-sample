<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

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

Route::middleware(('auth'))->group(function (): void {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('verified');

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('user-roles', UserRoleController::class)->only('create', 'store', 'edit', 'update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
