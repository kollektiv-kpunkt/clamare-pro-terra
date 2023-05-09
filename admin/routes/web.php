<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeetingPointController;
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

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'approved'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin', 'approved'])->group(function () {
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/approval', [UserController::class, 'approval'])->name('users.approval');
    Route::patch('/meetingpoints/{meetingPoint}/approval', [MeetingPointController::class, 'approval'])->name('meeting_points.approval');
});

Route::middleware(['auth', 'verified', 'role:admin|manager|user', 'approved'])->group(function () {
    Route::middleware("meetingpoint_owner")->resource('meeting_points', MeetingPointController::class);
});

Route::middleware(['auth', 'verified', 'role:user', 'approved'])->group(function () {
    Route::get('/my-meeting_points', [MeetingPointController::class, 'personal'])->name('meeting_points.personal');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix("create")->group(function(){
    Route::get("/event", function(){
        return view("create.form", [
            "title" => __("Create a mobilisation event for the Climate-Demonstration in September!"),
            "type" => "event"
        ]);
    })->name("create.event");

    Route::get("meetingpoint", function(){
        return view("create.form", [
            "title" => __("Create a meeting point for the Climate-Demonstration in September!"),
            "type" => "meetingpoint"
        ]);
    })->name("create.meetingpoint");

    Route::get("success", function() {
        return view("create.success");
    })->name("create.success");

    Route::post("/store", [MeetingPointController::class, "store_frontend"])->name("create.store");
});

require __DIR__.'/auth.php';
