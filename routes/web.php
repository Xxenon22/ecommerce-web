<?php

use App\Http\Controllers\NutrisiController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminDashboardController, CategoryProductController, TransactionController, AuthController, HomeController, UserController, ProductController, RestaurantController, CartController, AddressController, PaymentController, EdukasiController, SearchController, TrackingController};


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (GUEST ONLY) / NOT LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return view('startedPage');
    })->name('started');

    // User Login & Register
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/registration', [AuthController::class, 'showRegistrationForm'])->name('registration');
    Route::post('/registration', [AuthController::class, 'register']);

    // Restaurant Login & Register
    // Route::view('/login-resto', 'loginResto')->name('loginResto');
    // Route::view('/regis-resto', 'regisResto')->name('regisResto');

    Route::get('/register-restaurant', [AuthController::class, 'showRestaurantRegistrationForm'])->name('register.restaurant');
    Route::post('/register-restaurant', [AuthController::class, 'registerRestaurant'])->name('register.restaurant.store');

    Route::get('/login-restaurant', [AuthController::class, 'showRestaurantLoginForm'])->name('login.restaurant');
    Route::post('/login-restaurant', [AuthController::class, 'login'])->name('login.restaurant.store');

    Route::get('/edukasi/cara-menangkap-ikan', function () {
        return view('education');
    })->name('edukasi');
});



/*
|--------------------------------------------------------------------------
| USER AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // User Profile
    Route::get('/account', [AuthController::class, 'showProfile'])->name('account');
    Route::post('/account', [AuthController::class, 'updateProfile'])->name('account.update');

    // Restaurant Profile
    Route::get('/profil-resto', [AuthController::class, 'showRestaurantProfile'])->name('profileResto');
    Route::post('/profil-resto', [AuthController::class, 'updateRestaurantProfile'])->name('profileResto.update');

    // Restaurant Dashboard (Menu Management)
    Route::get('/home-resto', [ProductController::class, 'index'])->name('home-resto');
    Route::get('/tambah-menu', [ProductController::class, 'create'])->name('tambah-menu');
    Route::post('/tambah-menu', [ProductController::class, 'store'])->name('tambah-menu.store');


    Route::get('/category/', [CategoryProductController::class, 'index_user'])->name('category');
    Route::get('/category/{category}', [CategoryProductController::class, 'show_user'])->name('category.products');

    Route::post('/get-rates', [TransactionController::class, 'getRates'])->name('get.rates');
    Route::get('/history-transaction', [TransactionController::class, 'history'])->name('history');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');


    Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');

    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/transaction/{product}', function (Product $product) {
        return view('transaction', compact('product'));
    })->name('transaction');
    Route::post('/order/{id}/pay', [PaymentController::class, 'getSnapToken'])
        ->name('order.pay');
    Route::post('/order/{id}/cancel', [PaymentController::class, 'cancelOrder'])
        ->name('order.cancel');

    Route::get('/cart-checkout', [TransactionController::class, 'cart_checkout'])->name('cart_checkout');

    Route::get('/education/{id}', [EdukasiController::class, 'showUser'])->name('education.show');
    Route::get('/allEducation', [EdukasiController::class, 'index_user'])->name('education.all');

    // Route::put('/restaurant.update', [RestaurantController::class, 'update'])->name('restaurant.update');
    Route::resource('/restaurant', RestaurantController::class);
    Route::view('/search', 'components.search')->name('search');

    // // Edukasi
    // Route::view('/education/cara-menangkap-ikan', 'education')->name('education');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Address routes
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::get('/detailProduct/{id}', [ProductController::class, 'showUser'])->name('detailProduct.show');
    Route::get('/allProduct', [ProductController::class, 'index_user'])->name('allProduct.show');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    // SEARCH
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search-page', [App\Http\Controllers\SearchController::class, 'searchPage'])
        ->name('search.page');

    // TRACKING
    Route::get('/tracking/{biteshipOrderId}', [TrackingController::class, 'show'])->name('tracking.show');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('/category', CategoryProductController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/history', TransactionController::class);
    Route::resource('/education', EdukasiController::class);
});
