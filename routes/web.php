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


use App\Http\Controllers\CampaignProgressController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Post a new progress update
    Route::post('/campaigns/{campaign}/progress', [CampaignProgressController::class, 'store'])->name('campaigns.progress.store');

    // Optional: Delete an update
    Route::delete('/progress/{progress}', [CampaignProgressController::class, 'destroy'])->name('campaigns.progress.destroy');
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








Route::middleware(['auth', 'verified'])->group(function () {
    // Show the user's volunteering history
    Route::get('/volunteer-history', [VolunteerApplicationController::class, 'history'])->name('volunteer.history');
});

use App\Http\Controllers\FactCheckerController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Cast a Trust/Flag vote
    Route::post('/campaigns/{campaign}/vote', [FactCheckerController::class, 'vote'])->name('campaigns.vote');
});


use App\Http\Controllers\DonationController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Initiate payment
    Route::post('/donate/{campaign}', [DonationController::class, 'initiate'])->name('donate.initiate');
    });

// SSLCommerz Callbacks (Must be excluded from CSRF)
Route::post('/donate/success', [DonationController::class, 'success'])->name('donate.success');
Route::post('/donate/fail', [DonationController::class, 'fail'])->name('donate.fail');
Route::post('/donate/cancel', [DonationController::class, 'cancel'])->name('donate.cancel');



use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCampaignController;
use App\Http\Controllers\Admin\AdminHelpRequestController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Help Requests
    // Route::get('/help-requests', [AdminHelpRequestController::class, 'index'])->name('help.requests');
    // Route::patch('/help-requests/{helpRequest}/status', [AdminHelpRequestController::class, 'updateStatus'])->name('help.status');

    // Campaign Moderation
    Route::get('/campaigns', [AdminCampaignController::class, 'index'])->name('campaigns');
    Route::patch('/campaigns/{campaign}/rank', [AdminCampaignController::class, 'updateRank'])->name('campaigns.rank');
});




Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // List all requests
    Route::get('/help-requests', [AdminHelpRequestController::class, 'index'])->name('help.requests');

    // Update request status
    Route::patch('/help-requests/{helpRequest}/status', [AdminHelpRequestController::class, 'updateStatus'])->name('help.status');

    // Delete/Archive request (Optional)
    Route::delete('/help-requests/{helpRequest}', [AdminHelpRequestController::class, 'destroy'])->name('help.destroy');
});


use App\Http\Controllers\Admin\AdminUserController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');
    Route::patch('/users/{user}/verify-volunteer', [AdminUserController::class, 'verifyVolunteer'])->name('users.verify-volunteer');
});


// use App\Http\Controllers\Admin\AdminCampaignController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // List all campaigns for auditing
    Route::get('/campaigns', [AdminCampaignController::class, 'index'])->name('campaigns');

    // Feature/Rank a campaign
    Route::patch('/campaigns/{campaign}/rank', [AdminCampaignController::class, 'updateRank'])->name('campaigns.rank');

    // Suspend or Reactivate a campaign
    Route::patch('/campaigns/{campaign}/status', [AdminCampaignController::class, 'toggleStatus'])->name('campaigns.status');
});

use App\Http\Controllers\Admin\AdminDonationController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Global Financial Ledger
    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
});



use App\Http\Controllers\CampaignStreamController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Creator controls
    Route::post('/campaigns/{campaign}/go-live', [CampaignStreamController::class, 'startStream'])->name('campaigns.stream.start');
    Route::post('/campaigns/{campaign}/end-live', [CampaignStreamController::class, 'stopStream'])->name('campaigns.stream.stop');
});
