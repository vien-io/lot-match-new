<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LotController;  
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;





Auth::routes(['verify' => true]); // enable pass reset route




// default
Route::get('/', function () {
    return view('welcome');
});

/* // route for lots
Route::get('/lots', [LotController::class, 'index']); */

// route for homepage
Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');

// route for explore button
Route::get('/explore', [ExploreController::class, 'index'])->name('explore');

// route for properties button
Route::get('/properties', [PropertyController::class, 'index'])->name('properties');

// dashboard stuff
Route::resource('properties', PropertyController::class);
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::resource('reviews', ReviewController::class);

// routes using pagecontroller (static)
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// route for contact
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

// route to 3d map
Route::get('/3dmap', function(){
    return view('3dmap');
})->name('3dmap');

// route for blocks
Route::get('/blocks', [BlockController::class, 'getBlocks']);
Route::get('/lots/{blockId}', [LotController::class, 'getLots']);

// for fetching lot and block details
Route::get('/lot/{id}', [LotController::class, 'show']);
Route::get('/block/{id}', [BlockController::class, 'show']);




// password reset route
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');



// to signin page (already have an account?)
Route::get('/signin', [LoginController::class, 'showLoginForm'])->name('login');

// signin
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Auth::routes();

// to signup page (dont have an account?)
Route::get('/signup', [RegisterController::class, 'showRegistrationForm'])->name('register');

// signup (form submission)
Route::post('/signup', [RegisterController::class, 'register'])->name('signup');







// analytics
Route::get('/analytics/block-ratings', [AnalyticsController::class, 'blockRatings'])->name('analytics.block_ratings');

// dashboard
Route::get('/dashboardA', [AnalyticsController::class, 'dashboard'])->name('dashboardA');



// left nav buttons
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::resource('properties', PropertyController::class);


// reviews
Route::middleware(['auth'])->group(function () {
    Route::post('/block-reviews', [ReviewController::class, 'store'])->name('block.reviews.store'); 
});

Route::put('/block-reviews/{review}', [ReviewController::class, 'update']);
Route::delete('/block-reviews/{review}', [ReviewController::class, 'destroy']);


// forecasting
Route::get('/forecast/block/{block_id}', [ForecastController::class, 'forecastBlockRating']);
Route::get('/forecast/sentiment-trend/{blockId}', [ForecastController::class, 'getBlockSentimentTrends']);




// testing
Route::get('/test-web', function () {
    return 'web route is working';
});
Route::get('/tools/backfill-sentiment', [\App\Http\Controllers\ToolsController::class, 'backfillSentiment']);