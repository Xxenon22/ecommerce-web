<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('registration');
    }
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('login');
    }

    public function showRestaurantLoginForm()
    {
        if (Auth::check()) {
            // Check if user has restaurant data
            if (Auth::user()->resto_name) {
                return redirect('/home-resto');
            } else {
                return redirect('/home');
            }
        }
        return view('regisResto');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if user has restaurant data and redirect accordingly
            $user = Auth::user();
            if ($user->resto_name) {
                return redirect()->intended('/home-resto');
            } else {
                return redirect()->intended('/home');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showProfile()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if user has restaurant data, create empty one if not exists
        $user = Auth::user();
        if (is_null($user->restaurant)) {
            $user->restaurant()->create(['user_id' => $user->id]);
        }

        return view('account');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'resto_name' => 'nullable|string|max:255',
            'resto_address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(storage_path('app/public/' . $user->photo))) {
                unlink(storage_path('app/public/' . $user->photo));
            }
            // Store new photo
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $photoPath;
        }

        $user->update($validatedData);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        Auth::login($user);

        return redirect()->intended('/home');
    }

    public function showRestaurantRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('loginResto');
    }

    public function registerRestaurant(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'resto_name' => 'required|string|max:255',
            'resto_address' => 'required|string|max:500',
            'business_type' => 'required|string|in:restaurant,cafe,food_truck,other',
            'description' => 'nullable|string|max:1000',
            'opening_hours' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('restaurant_photos', 'public');
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'resto_name' => $validatedData['resto_name'],
            'resto_address' => $validatedData['resto_address'],
            'business_type' => $validatedData['business_type'],
            'description' => $validatedData['description'],
            'opening_hours' => $validatedData['opening_hours'],
            'photo' => $photoPath,
        ]);

        Auth::login($user);

        return redirect()->route('home-resto')->with('success', 'Restoran berhasil didaftarkan! Selamat datang di Fishery Hub.');
    }

    public function showRestaurantProfile()
    {
        if (!Auth::check()) {
            return redirect('/login-restaurant');
        }

        $user = Auth::user();
        // Ensure user has restaurant data
        if (!$user->resto_name) {
            return redirect('/register-restaurant')->with('error', 'Silakan daftar restoran terlebih dahulu.');
        }

        return view('profileResto');
    }

    public function updateRestaurantProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'resto_name' => 'required|string|max:255',
            'resto_address' => 'required|string|max:500',
            'business_type' => 'required|string|in:restaurant,cafe,food_truck,other',
            'description' => 'nullable|string|max:1000',
            'opening_hours' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(storage_path('app/public/restaurant_photos/' . $user->photo))) {
                unlink(storage_path('app/public/restaurant_photos/' . $user->photo));
            }
            // Store new photo
            $photoPath = $request->file('photo')->store('restaurant_photos', 'public');
            $validatedData['photo'] = basename($photoPath);
        }

        $user->update($validatedData);

        return back()->with('success', 'Profil restoran berhasil diperbarui!');
    }
}
