<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
    OwnerVerificationController,
    SearchController,
    UserManagementController
};
use App\Http\Middleware\CheckRole;

// Enable auth routes with email verification
Auth::routes(['verify' => true]);

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::view('/', 'welcome');

// Authentication
Route::get('/signin', [LoginController::class, 'showLoginForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin.submit');

Route::get('/signup', [RegisterController::class, 'showRegistrationForm'])->name('signup');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.submit');


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


// Search Bar
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('blocks/{blockId}/lots/{lotNumber}', [LotController::class, 'show'])->name('lots.show');


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

    // ------------------------
    // Dashboard
    // ------------------------
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // ------------------------
    // Property Management
    // ------------------------
    Route::resource('properties', PropertyController::class)
        ->except(['show', 'create', 'edit']);

    // ------------------------
    // Analytics & Forecasting
    // ------------------------
    Route::get('/analytics/block-ratings', [AnalyticsController::class, 'dashboard'])
        ->name('analytics.block_ratings');
    Route::get('/forecast', [ForecastController::class, 'forecastPage'])->name('forecast');
    Route::get('/forecast/data/{blockId}', [ForecastController::class, 'getForecastData']);
    Route::get('/forecast/block/{block_id}', [ForecastController::class, 'forecastBlockRating']);
    Route::get('/forecast/sentiment-trend/{blockId}', [ForecastController::class, 'getBlockSentimentTrends']);

    // ------------------------
    // Reviews (all logged-in verified users)
    // ------------------------
    Route::post('/block-reviews', [ReviewController::class, 'store'])->name('block.reviews.store');
    Route::put('/block-reviews/{review}', [ReviewController::class, 'update'])->name('block.reviews.update');
    Route::delete('/block-reviews/{review}', [ReviewController::class, 'destroy'])->name('block.reviews.destroy');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/blocks/{blockId}/reviews', [ReviewController::class, 'blockReviews']);
    Route::get('/blocks/all/reviews', [ReviewController::class, 'blockReviews']);
    Route::get('/block/{block}/with-reviews-lots', [BlockController::class, 'getBlockWithReviewsAndLots']);

    // ------------------------
    // 3D Map
    // ------------------------
    Route::get('/map', [MapController::class, 'index'])->name('map');

    // ------------------------
    // Lot Images
    // ------------------------
    Route::post('/lots/add-image', [LotController::class, 'addImage'])->name('lots.addImage');
    Route::get('/lots/{lotId}/images', [LotImageController::class, 'index']);

    // ------------------------
    // Buyer Routes (Owner Verification Requests)
    // ------------------------
    Route::middleware(['role:buyer'])->prefix('owner-verification')->name('owner-verification.')->group(function () {
        Route::get('/request', [OwnerVerificationController::class, 'create'])->name('create');
        Route::post('/request', [OwnerVerificationController::class, 'store'])->name('store');
    });

    // ------------------------
    // Admin Routes
    // ------------------------
    Route::middleware(['role:admin'])->group(function () {

        // User Management
        Route::prefix('usermanagement')->name('usermanagement.')->group(function () {
            Route::get('/users', [UserManagementController::class, 'index'])->name('index');
            Route::get('/users/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/users', [UserManagementController::class, 'store'])->name('store');
            Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
            Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('update');
            Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
        });

        // Owner Verification Requests
        Route::prefix('owner-verification')->name('owner-verification.')->group(function () {
            Route::get('/requests', [OwnerVerificationController::class, 'index'])->name('index');
            Route::post('/approve/{id}', [OwnerVerificationController::class, 'approve'])->name('approve');
            Route::post('/reject/{id}', [OwnerVerificationController::class, 'reject'])->name('reject');
        });
    });
});


/*
|--------------------------------------------------------------------------
| Misc & Tools
|--------------------------------------------------------------------------
*/
Route::get('/test-web', fn() => 'web route is working');
Route::get('/tools/backfill-sentiment', [\App\Http\Controllers\ToolsController::class, 'backfillSentiment']);





/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/
// verification success page
Route::get('/email/verified-success', function () {
    return view('auth.verified-success');
})->name('verification.success');

// default verification route 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('verification.success');
})->middleware(['auth', 'signed'])->name('verification.verify');

// if email isn’t verified yet
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// resend link 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


