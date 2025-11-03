<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    AnalyticsController,
    Auth\ForgotPasswordController,
    Auth\LoginController,
    AuthController,
    Auth\RegisterController,
    HomeController,
    ExploreController,
    PropertyController,
    PageController,
    ContactController,
    BlockController,
    LotController,
    LotImageController,
    ForecastController,
    ReviewController,
    DashboardController,
    MapController,
    UserManagementController
};

// Enable auth routes with email verification
Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome');

// Authentication
Route::get('/signin', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');

Route::get('/signup', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup');

// Password reset
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

// Static pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

// Public viewing
Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties');
Route::get('/3dmap', fn() => view('3dmap'))->name('3dmap');

// Public API endpoints for blocks/lots
Route::get('/blocks', [BlockController::class, 'getBlocks']);
Route::get('/lots/{blockId}', [LotController::class, 'getLots']);
Route::get('/block/{id}', [BlockController::class, 'show']);
Route::get('/block/{blockId}/lot/{lotNumber}', [LotController::class, 'show']);
Route::get('/blocks/{blockId}/lots/{lotNumber}', [LotController::class, 'showLot'])->name('lots.show');

/*
|--------------------------------------------------------------------------
| Authenticated and Verified Routes
|--------------------------------------------------------------------------
|
| All routes here require both authentication AND verified email.
| Unverified users will be redirected to /email/verify.
|
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Property management
    Route::resource('properties', PropertyController::class)->except(['show', 'create', 'edit']);

    // Analytics and forecasting
    Route::get('/analytics/block-ratings', [AnalyticsController::class, 'dashboard'])->name('analytics.block_ratings');
    Route::get('/forecast', [ForecastController::class, 'forecastPage'])->name('forecast');
    Route::get('/forecast/data/{blockId}', [ForecastController::class, 'getForecastData']);
    Route::get('/forecast/block/{block_id}', [ForecastController::class, 'forecastBlockRating']);
    Route::get('/forecast/sentiment-trend/{blockId}', [ForecastController::class, 'getBlockSentimentTrends']);

    // Reviews (only logged-in verified users can manage reviews)
    Route::post('/block-reviews', [ReviewController::class, 'store'])->name('block.reviews.store');
    Route::put('/block-reviews/{review}', [ReviewController::class, 'update'])->name('block.reviews.update');
    Route::delete('/block-reviews/{review}', [ReviewController::class, 'destroy'])->name('block.reviews.destroy');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/blocks/{blockId}/reviews', [ReviewController::class, 'blockReviews']);
    Route::get('/blocks/all/reviews', [ReviewController::class, 'blockReviews']);

    // 3D map page (protected so only verified users interact with analytics)
    Route::get('/map', [MapController::class, 'index'])->name('map');

    // Lot images
    Route::post('/lots/add-image', [LotController::class, 'addImage'])->name('lots.addImage');
    Route::get('/lots/{lotId}/images', [LotImageController::class, 'index']);

    // User management (admin area)
    Route::prefix('usermanagement')->name('usermanagement.')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('store');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Misc & Tools
|--------------------------------------------------------------------------
*/
Route::get('/test-web', fn() => 'web route is working');
Route::get('/tools/backfill-sentiment', [\App\Http\Controllers\ToolsController::class, 'backfillSentiment']);








use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// ✅ Custom verification success page
Route::get('/email/verified-success', function () {
    return view('auth.verified-success');
})->name('verification.success');

// ✅ Default verification route (you may already have this)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('verification.success');
})->middleware(['auth', 'signed'])->name('verification.verify');

// ✅ Show notice if email isn’t verified yet
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// ✅ Resend link (optional)
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


