<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ProfileController;
use App\Models\Campaign;
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
// Route::get('/', [CampaignController::class, 'landing'])->name('welcome');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


use App\Http\Controllers\HelpRequestController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Show the Help Request Form
    Route::get('/help-request', [HelpRequestController::class, 'create'])->name('help.request.create');

    // Store the Help Request
    Route::post('/help-request', [HelpRequestController::class, 'store'])->name('help.request.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // List only campaigns created by the logged-in user
    Route::get('/my-campaigns', [CampaignController::class, 'myCampaigns'])->name('campaigns.mine');

    // Toggle campaign status (Active/Paused/Completed)
    Route::patch('/campaigns/{campaign}/status', [CampaignController::class, 'toggleStatus'])->name('campaigns.status');
});




Route::middleware(['auth', 'verified'])->group(function () {
    // Show the Edit Form
    Route::get('/campaigns/{campaign}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');

    // Update the Campaign (Using PATCH or PUT)
    Route::patch('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');
});




Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile/donations', [ProfileController::class, 'donations'])->name('profile.donations');
});




// Public Routes (Anyone can see these)
Route::get('/', [CampaignController::class, 'landing'])->name('landing');
Route::get('/explore', [CampaignController::class, 'index'])->name('campaigns.index');


// Protected Routes (Must be logged in)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    // Campaign Details Route (Using Route Model Binding)
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');

    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
});

use App\Http\Controllers\VolunteerApplicationController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Show the application form for a specific campaign
    Route::get('/campaigns/{campaign}/apply', [VolunteerApplicationController::class, 'create'])->name('volunteer.apply');

    // Store the application
    Route::post('/campaigns/{campaign}/apply', [VolunteerApplicationController::class, 'store'])->name('volunteer.store');
});







