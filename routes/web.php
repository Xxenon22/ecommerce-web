<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('startedPage');
})->name('started');

Route::get('/beranda', function () {
    return view('home');
})->name('beranda');

Route::get('/kategori/{kategori?}', function ($kategori = null) {
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
    return view('category', compact('products', 'kategori'));
})->name('kategori');


Route::get('/akun', function () {
    return view('account');
})->name('akun');

Route::get('/masuk', function () {
    return view('login');
})->name('masuk');

Route::get('/daftar', function () {
    return view('regis');
})->name('daftar');

Route::get('/pesanan', function () {
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
})->name('pesanan');

Route::get('keranjang', function () {
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
    return view('keranjang', compact('cart'));
})->name('keranjang');

Route::get('/checkout', function () {
    // Sample cart data for checkout - same as keranjang for now
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
