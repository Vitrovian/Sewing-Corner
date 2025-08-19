<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ObserveController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// ==============================
// Головна сторінка
// ==============================
Route::get('/', [IndexController::class, '__invoke'])->name('index');

// ==============================
// Сторінки (статичні)
// ==============================
Route::view('/about', 'pages.about')->name('about');
Route::view('/contacts', 'pages.contact')->name('contact');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');



// ==============================
// Маршрути для адміністратора
// ==============================
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    //  Cторінка адміністратора
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Список користувачів
    Route::get('/admin/list', [AdminController::class, 'index'])->name('admin.list');
    Route::post('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
    Route::put('/orders/{order}', action: [OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{order}/set-price', action: [OrderController::class, 'setPrice'])->name('orders.setPrice');
    Route::put('/orders/{order}/update-payment-type', [OrderController::class, 'updatePaymentType'])->name('orders.updatePaymentType');
    Route::get('/observe-user',[ObserveController::class, 'show'])->name('observe-user');
});


// ==============================
// Маршрути для авторизованих користувачів
// ==============================
Route::middleware(['auth', 'verified'])->group(function () {
    //  Cторінка користувача
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    // Створення замовлення
    Route::get('create', [OrderController::class, 'showCreateForm'])->name('create-order');
    Route::post('create', [OrderController::class, 'store'])->name('store-order');

    // Маршрути для замовлень
    Route::controller(OrderController::class)
        ->prefix('orders')
        ->name('orders.')
        ->group(function () {
            Route::get('/', 'index')->name('index'); // Список замовлень
            Route::get('/{order}', 'show')->name('show'); // Перегляд замовлення
            Route::post('/', 'store')->name('store'); // Збереження замовлення
            Route::post('/{order}/cancel', 'cancel')->name('cancel'); // Скасування замовлення
        });
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    // Редагування замовлення
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');

    // Оплата замовлення
    Route::get('/orders/{order}/payment', [PaymentController::class, 'showPaymentForm'])->name('orders.payment');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update')->middleware('auth');
});

// ==============================
// Верифікація електронної пошти
// ==============================
Route::middleware('auth')->group(function () {
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:3,1'])->name('verification.send');

    Route::get('/verify-email', function () {
        return view('user.verify-email');
    })->name('verification.notice');

     //Вихід
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
});

// ==============================
// Маршрути для гостей
// ==============================
Route::middleware('guest')->group(function () {
    // Реєстрація
    Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [UserController::class, 'store'])->name('register');

    // Вхід
    Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserController::class, 'login'])->name('login');

    // Забули пароль
    Route::get('forgot-password', function () {
        return view('user.forgot-password');
    })->name('password.request');
    Route::post('forgot-password', [UserController::class, 'forgotPasswordStore'])->name('password.email')->middleware('throttle:3,1');

    // Скидання пароля
    Route::get('reset-password/{token}', function (string $token) {
        return view('user.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('reset-password', [UserController::class , 'resetPasswordUpdate'])->name('password.update');
});


