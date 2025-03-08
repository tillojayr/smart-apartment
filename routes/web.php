<?php

use App\Events\SwitchControlEvent;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('tenants', 'tenants')->name('tenants');
    Route::view('control-panel', 'control-panel')->name('control-panel');
    Route::view('visual-data', 'visual-data')->name('visual-data');
    Route::get('visual-data/{id}/room', function($id) {
        return view('visual-data-room', ['roomId' => $id]);
    })->name('visual-data.room');
});

Route::get('test', function () {
    event(new SwitchControlEvent('asd'));

    return 'done';
});

require __DIR__ . '/auth.php';
