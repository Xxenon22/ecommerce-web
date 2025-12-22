<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('startedPage');
})->name('started');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/category/{category?}', function ($category = null) {
    $products = [
        'Ikan segar' => [
            ['name' => 'Tuna Steak', 'price' => 'Rp25.000', 'image' => 'assets/cumi-krispy.jpg'],
            ['name' => 'Salmon Fillet', 'price' => 'Rp30.000', 'image' => 'assets/cumi-krispy.jpg'],
            ['name' => 'Cod Fish', 'price' => 'Rp20.000', 'image' => 'assets/cumi-krispy.jpg'],
            ['name' => 'Mackerel', 'price' => 'Rp18.000', 'image' => 'assets/cumi-krispy.jpg'],
        ],
        'Kepiting' => [
            ['name' => 'Blue Crab', 'price' => 'Rp35.000', 'image' => 'assets/cumi-krispy.jpg'],
        ],
        'Cumi - Cumi' => [
            ['name' => 'Cumi Krispy', 'price' => 'Rp15.000', 'image' => 'assets/cumi-krispy.jpg'],
        ],
        'Udang' => [
            ['name' => 'Shrimp Large', 'price' => 'Rp22.000', 'image' => 'assets/cumi-krispy.jpg'],
        ],
        'Kerang' => [
            ['name' => 'Clam Shell', 'price' => 'Rp12.000', 'image' => 'assets/cumi-krispy.jpg'],
        ],
    ];
    return view('category', compact('products', 'category'));
})->name('category');


Route::get('/account', [AuthController::class, 'showProfile'])->name('account');
Route::post('/account', [AuthController::class, 'updateProfile'])->name('account.update');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/registration', function () {
    return view('registration');
})->name('registration');

Route::get('/register-restaurant', [AuthController::class, 'showRestaurantRegistrationForm'])->name('register.restaurant');
Route::post('/register-restaurant', [AuthController::class, 'registerRestaurant'])->name('register.restaurant.store');

Route::get('/login-restaurant', [AuthController::class, 'showRestaurantLoginForm'])->name('login.restaurant');
Route::post('/login-restaurant', [AuthController::class, 'login'])->name('login.restaurant.store');

Route::get('/order', function () {
    // Sample orders data - replace with actual order logic later
    $orders = [
        [
            'id' => 'ORD001',
            'date' => '15 Desember 2024, 14:30',
            'status' => 'Diproses',
            'total' => 'Rp98.000',
            'items' => [
                [
                    'name' => 'Tuna Steak',
                    'image' => 'assets/cumi-krispy.jpg',
                    'price' => 'Rp50.000',
                    'quantity' => 2
                ],
                [
                    'name' => 'Salmon Fillet',
                    'image' => 'assets/cumi-krispy.jpg',
                    'price' => 'Rp30.000',
                    'quantity' => 1
                ]
            ]
        ],
        [
            'id' => 'ORD002',
            'date' => '10 Desember 2024, 09:15',
            'status' => 'Selesai',
            'total' => 'Rp45.000',
            'items' => [
                [
                    'name' => 'Cumi Krispy',
                    'image' => 'assets/cumi-krispy.jpg',
                    'price' => 'Rp15.000',
                    'quantity' => 3
                ]
            ]
        ]
    ];
    return view('order', compact('orders'));
})->name('order');

Route::get('cart', function () {
    // Sample cart data - replace with actual cart logic later
    $cart = [
        [
            'name' => 'Tuna Steak',
            'image' => 'assets/cumi-krispy.jpg',
            'price' => 'Rp25.000',
            'quantity' => 2,
            'description' => 'Fresh tuna steak from the best catch'
        ],
        [
            'name' => 'Salmon Fillet',
            'image' => 'assets/cumi-krispy.jpg',
            'price' => 'Rp30.000',
            'quantity' => 1,
            'description' => 'Premium salmon fillet'
        ]
    ];
    return view('cart', compact('cart'));
})->name('cart');

Route::get('/checkout', function () {
    // Sample cart data for checkout - same as cart for now
    $cart = [
        [
            'name' => 'Tuna Steak',
            'image' => 'assets/cumi-krispy.jpg',
            'price' => 'Rp25.000',
            'quantity' => 2,
            'description' => 'Fresh tuna steak from the best catch'
        ],
        [
            'name' => 'Salmon Fillet',
            'image' => 'assets/cumi-krispy.jpg',
            'price' => 'Rp30.000',
            'quantity' => 1,
            'description' => 'Premium salmon fillet'
        ]
    ];
    return view('checkout', compact('cart'));
})->name('checkout');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registration', [AuthController::class, 'showRegistrationForm'])->name('registration');
Route::post('/registration', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});
Route::get('/produk/{name}', function ($name) {
    // Sample product data - replace with actual product logic later
    $products = [
        'Cumi Krispy' => [
            'name' => 'Cumi Krispy',
            'price' => 'Rp15.000',
            'image' => 'assets/cumi-krispy.jpg',
            'description' => 'Cumi yang digoreng crispy dengan bumbu rahasia, cocok untuk camilan atau lauk.',
            'restaurant' => [
                'name' => 'Layar Seafood 99',
                'image' => 'assets/resto1.jpg',
                'address' => 'Jalan Pesanggrahan Raya No.80, Meruya Utara, West Jakarta 11620'
            ]
        ],
        'Salmon Fillet' => [
            'name' => 'Salmon Fillet',
            'price' => 'Rp30.000',
            'image' => 'assets/cumi-krispy.jpg',
            'description' => 'Premium salmon fillet, segar dan berkualitas tinggi.',
            'restaurant' => [
                'name' => 'Tepian Rasa',
                'image' => 'assets/resto2.jpg',
                'address' => 'Jalan Lombok Nomor 45, Bandung'
            ]
        ],
        // Add more products as needed
    ];

    $product = $products[$name] ?? null;
    if (!$product) {
        abort(404);
    }

    return view('product', compact('product'));
})->name('produk');

Route::get('/edukasi/cara-menangkap-ikan', function () {
    return view('education');
})->name('edukasi');

Route::get('/restaurant/{name}', function ($name) {
    // Sample restaurant data - replace with actual restaurant logic later
    $restaurants = [
        'Layar Seafood 99' => [
            'name' => 'Layar Seafood 99',
            'image' => 'assets/resto1.jpg',
            'address' => 'Jalan Pesanggrahan Raya No.80, Meruya Utara, West Jakarta 11620',
            'products' => [
                [
                    'name' => 'Cumi Krispy',
                    'price' => 'Rp15.000',
                    'image' => 'assets/cumi-krispy.jpg'
                ],
                [
                    'name' => 'Tuna Steak',
                    'price' => 'Rp25.000',
                    'image' => 'assets/cumi-krispy.jpg'
                ]
            ]
        ],
        'Tepian Rasa' => [
            'name' => 'Tepian Rasa',
            'image' => 'assets/resto2.jpg',
            'address' => 'Jalan Lombok Nomor 45, Bandung',
            'products' => [
                [
                    'name' => 'Salmon Fillet',
                    'price' => 'Rp30.000',
                    'image' => 'assets/cumi-krispy.jpg'
                ],
                [
                    'name' => 'Blue Crab',
                    'price' => 'Rp35.000',
                    'image' => 'assets/cumi-krispy.jpg'
                ]
            ]
        ]
    ];

    $restaurant = $restaurants[$name] ?? null;
    if (!$restaurant) {
        abort(404);
    }

    return view('restaurant', compact('restaurant'));
})->name('restaurant');

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryProductController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::view('/', 'startedPage')->name('started');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (GUEST ONLY) / NOT LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // User Login & Register
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/registration', [AuthController::class, 'showRegistrationForm'])->name('registration');
    Route::post('/registration', [AuthController::class, 'register']);

    // Restaurant Login & Register
    Route::view('/login-resto', 'loginResto')->name('loginResto');
    Route::view('/regis-resto', 'regisResto')->name('regisResto');

    Route::get('/register-restaurant', [AuthController::class, 'showRestaurantRegistrationForm'])->name('register.restaurant');
    Route::post('/register-restaurant', [AuthController::class, 'registerRestaurant'])->name('register.restaurant.store');

    Route::get('/login-restaurant', [AuthController::class, 'showRestaurantLoginForm'])->name('login.restaurant');
    Route::post('/login-restaurant', [AuthController::class, 'login'])->name('login.restaurant.store');
});



/*
|--------------------------------------------------------------------------
| USER AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

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

    Route::view('/home', 'home')->name('home');

    // Category Page
    Route::get('/category/{category?}', function ($category = null) {
        $products = [
            'Ikan segar' => [
                ['name' => 'Tuna Steak', 'price' => 'Rp25.000', 'image' => 'assets/cumi-krispy.jpg'],
                ['name' => 'Salmon Fillet', 'price' => 'Rp30.000', 'image' => 'assets/cumi-krispy.jpg'],
                ['name' => 'Cod Fish', 'price' => 'Rp20.000', 'image' => 'assets/cumi-krispy.jpg'],
                ['name' => 'Mackerel', 'price' => 'Rp18.000', 'image' => 'assets/cumi-krispy.jpg'],
            ],
            'Kepiting' => [
                ['name' => 'Blue Crab', 'price' => 'Rp35.000', 'image' => 'assets/cumi-krispy.jpg'],
            ],
            'Cumi - Cumi' => [
                ['name' => 'Cumi Krispy', 'price' => 'Rp15.000', 'image' => 'assets/cumi-krispy.jpg'],
            ],
            'Udang' => [
                ['name' => 'Shrimp Large', 'price' => 'Rp22.000', 'image' => 'assets/cumi-krispy.jpg'],
            ],
            'Kerang' => [
                ['name' => 'Clam Shell', 'price' => 'Rp12.000', 'image' => 'assets/cumi-krispy.jpg'],
            ],
        ];
        return view('category', compact('products', 'category'));
    })->name('category');

    // Cart, Order, Checkout
    Route::view('/order', 'order')->name('order');
    Route::view('/cart', 'cart')->name('cart');
    Route::view('/checkout', 'checkout')->name('checkout');

    // Dynamic Produk
    Route::get('/produk/{name}', function ($name) {
        $products = [
            'Cumi Krispy' => [
                'name' => 'Cumi Krispy',
                'price' => 'Rp15.000',
                'image' => 'assets/cumi-krispy.jpg',
                'description' => 'Cumi crispy...',
                'restaurant' => [
                    'name' => 'Layar Seafood 99',
                    'image' => 'assets/resto1.jpg',
                    'address' => 'Jalan Pesanggrahan Raya No.80',
                ]
            ],
            'Salmon Fillet' => [
                'name' => 'Salmon Fillet',
                'price' => 'Rp30.000',
                'image' => 'assets/cumi-krispy.jpg',
                'description' => 'Premium salmon...',
                'restaurant' => [
                    'name' => 'Tepian Rasa',
                    'image' => 'assets/resto2.jpg',
                    'address' => 'Jalan Lombok 45, Bandung',
                ]
            ],
        ];

        $product = $products[$name] ?? null;
        abort_if(!$product, 404);

        return view('product', compact('product'));
    })->name('produk');

    // Dynamic Restaurant
    Route::get('/restaurant/{name}', function ($name) {
        $restaurants = [
            'Layar Seafood 99' => [
                'name' => 'Layar Seafood 99',
                'image' => 'assets/resto1.jpg',
                'address' => 'Jalan Pesanggrahan Raya No.80',
                'products' => [
                    ['name' => 'Cumi Krispy', 'price' => 'Rp15.000', 'image' => 'assets/cumi-krispy.jpg'],
                    ['name' => 'Tuna Steak', 'price' => 'Rp25.000', 'image' => 'assets/cumi-krispy.jpg']
                ]
            ],
            'Tepian Rasa' => [
                'name' => 'Tepian Rasa',
                'image' => 'assets/resto2.jpg',
                'address' => 'Jalan Lombok 45, Bandung',
                'products' => [
                    ['name' => 'Salmon Fillet', 'price' => 'Rp30.000', 'image' => 'assets/cumi-krispy.jpg'],
                    ['name' => 'Blue Crab', 'price' => 'Rp35.000', 'image' => 'assets/cumi-krispy.jpg']
                ]
            ]
        ];

        $restaurant = $restaurants[$name] ?? null;
        abort_if(!$restaurant, 404);

        return view('restaurant', compact('restaurant'));
    })->name('restaurant');

    // Edukasi
    Route::view('/edukasi/cara-menangkap-ikan', 'edukasi')->name('edukasi');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::resource('/category', CategoryProductController::class);
    Route::resource('/user', UserController::class);

});
