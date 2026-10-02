<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;

// --- Imports Controller Admin ---
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\Admin\PemesananController as AdminPemesananController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

// --- Imports Controller Member/Publik ---
use App\Http\Controllers\Member\KamarPublikController as MemberKamarController; // <<< Controller Kamar Publik
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\PemesananController as MemberPemesananController;
use App\Http\Controllers\ReviewController;

use Illuminate\Support\Facades\Auth;

// ====================================================================
// A. ROUTE PUBLIK / GUEST
// ====================================================================

// Public landing page (Home)
// Menggunakan MemberKamarController untuk menampilkan kamar unggulan
Route::get('/', [MemberKamarController::class, 'landing'])->name('landing');

Route::get('/home', function () {
    return redirect()->route('landing');
})->name('home');

// Daftar kamar route accessible publicly for both guests and members
// Menggunakan MemberKamarController untuk daftar kamar
Route::get('/daftarkamar', [MemberKamarController::class, 'index'])->name('daftarkamar');
Route::get('/daftarkamar/{kamar}', [MemberKamarController::class, 'show'])->name('daftarkamar.show');


// About
Route::get('/about', fn() => view('about'))->name('about');

// Contact Us
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');


// Midtrans payment notification webhook endpoint
Route::post('/midtrans/notification', [AdminPemesananController::class, 'midtransNotification'])->name('midtrans.notification');


// ====================================================================
// B. ROUTE AUTH (LOGIN/REGISTER/LOGOUT)
// ====================================================================

// Auth
Route::get('register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'register'])->middleware('guest');
Route::get('login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->middleware('guest');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('password/forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');


// ====================================================================
// C. ROUTE ADMIN
// ====================================================================

// Protected by auth and IsAdmin middleware
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    // Kamar: Menggunakan AdminKamarController
    Route::resource('kamar', AdminKamarController::class, ['as' => 'admin'])->except(['show']);
    
    // Pemesanan: Menggunakan AdminPemesananController
    Route::get('pemesanan', [AdminPemesananController::class, 'index'])->name('admin.pemesanan.index');
    Route::post('pemesanan/{pemesanan}/status', [AdminPemesananController::class, 'updateStatus'])->name('admin.pemesanan.updateStatus');

    // Review
    Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class, ['as' => 'admin'])->only(['index', 'show', 'destroy']);

    // Tipe Kamar
    Route::resource('tipe-kamar', App\Http\Controllers\Admin\TipeKamarController::class, ['as' => 'admin']);

    // Calendar
    Route::get('calendar', function () {
        return view('admin.calendar.index');
    })->name('admin.calendar.index');

    // Profile Admin
    Route::get('profile', [AdminProfileController::class, 'show'])->name('admin.profile.show');
    Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});


// ====================================================================
// D. ROUTE MEMBER
// ====================================================================

// Protected by auth and ensure_member middleware
Route::prefix('member')->name('member.')->middleware(['auth', 'ensure_member'])->group(function(){
    // Member Dashboard
    Route::get('/', [App\Http\Controllers\Member\DashboardController::class, 'index'])->name('index');

    // Kamar: Menggunakan MemberKamarController
    Route::get('kamar', [MemberKamarController::class, 'index'])->name('kamar.index');
    Route::get('kamar/{kamar}', [MemberKamarController::class, 'show'])->name('kamar.show');

    // Pemesanan: Menggunakan Member PemesananController
    Route::post('pemesanan', [MemberPemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('pemesanan/my', [MemberPemesananController::class, 'myBookings'])->name('pemesanan.my');
    Route::get('pemesanan/{pemesanan}', [MemberPemesananController::class, 'show'])->name('pemesanan.show');
    Route::delete('pemesanan/{pemesanan}/cancel', [MemberPemesananController::class, 'cancelBooking'])->name('pemesanan.cancel');
    
    // Review
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Wishlist
    Route::get('wishlist', [App\Http\Controllers\Member\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist', [App\Http\Controllers\Member\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('wishlist/{id_kamar}', [App\Http\Controllers\Member\WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::get('wishlist/check/{id_kamar}', [App\Http\Controllers\Member\WishlistController::class, 'check'])->name('wishlist.check');

    // Profile Member
    Route::get('profile', [MemberProfileController::class, 'show'])->name('profile');
    Route::get('profile/edit', [MemberProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [MemberProfileController::class, 'update'])->name('profile.update');
});