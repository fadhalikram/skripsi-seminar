<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentConfirmationController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('public');
Route::get('/home', [HomeController::class, 'index'])->name('public.home');
Route::get('/event/{id}', [PublicController::class, 'showEvent'])->name('public.event.show');

Route::group(['middleware' => 'auth'], function () {
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // CATEGORIES
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // EVENTS
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    
    Route::get('/events/{event}/certificate', [EventController::class, 'upsertCertificate'])->name('events.certificate.upsert');
    Route::put('/events/{event}/certificate', [EventController::class, 'submitUpsertCertificate'])->name('events.certificate.submitUpsert');
    Route::get('/events/{event}/certificate/generate', [EventController::class, 'generateCertificate'])->name('events.certificate.generate');
    
    // EVENTS CLIENTS
    Route::get('/events/client', [EventController::class, 'indexClient'])->name('events.client.index');
    
    // ATTENDANCES
    Route::resource('attendances', AttendanceController::class);
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::get('/attendances/{registration}/status', [AttendanceController::class, 'updatePresentStatus'])->name('attendances.updatePresentStatus');
    
    // REGISTRATIONS
    Route::resource('registrations', RegistrationController::class);
    Route::get('/events/{id}/register', [RegistrationController::class, 'eventRegister'])->name('events.eventRegister');
    
    // CERTIFICATES
    Route::resource('certificates', CertificateController::class);
    Route::get('/certificates/generate/{userId}', [CertificateController::class, 'generate'])->name('certificates.generate');
    
    
    // USERS
    Route::resource('users', UserController::class);
    
    // PAYMENT CONFIRMATIONS
    Route::get('/payment_confirmations/client', [PaymentConfirmationController::class, 'indexClient'])->name('payment_confirmations.client.index');
    Route::get('/payment_confirmations/client/create', [PaymentConfirmationController::class, 'createClient'])->name('payment_confirmations.client.create');
    Route::post('/payment_confirmations/client/create', [PaymentConfirmationController::class, 'storeClient'])->name('payment_confirmations.client.store');
    Route::get('/payment_confirmations/client/{payment_confirmation}', [PaymentConfirmationController::class, 'showClient'])->name('payment_confirmations.client.show');
    
    Route::get('/payment_confirmations', [PaymentConfirmationController::class, 'index'])->name('payment_confirmations.index');
    Route::get('/payment_confirmations/create', [PaymentConfirmationController::class, 'create'])->name('payment_confirmations.create');
    Route::post('/payment_confirmations', [PaymentConfirmationController::class, 'store'])->name('payment_confirmations.store');
    Route::get('/payment_confirmations/{payment_confirmation}/edit', [PaymentConfirmationController::class, 'edit'])->name('payment_confirmations.edit');
    Route::get('/payment_confirmations/{payment_confirmation}', [PaymentConfirmationController::class, 'show'])->name('payment_confirmations.show');
    Route::get('/payment_confirmations/{payment_confirmation}/status', [PaymentConfirmationController::class, 'updatePaymentStatus'])->name('payment_confirmations.updatePaymentStatus');
    // Route::put('/payment_confirmations/{event}', [EventController::class, 'update'])->name('payment_confirmations.update');
    // Route::delete('/payment_confirmations/{event}', [EventController::class, 'destroy'])->name('payment_confirmations.destroy');
    // Route::resource('payment_confirmations', PaymentConfirmationController::class);
});