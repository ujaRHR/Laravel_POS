<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;

// Test Routes
Route::get('/test', [TestController::class, 'testFunc']);

// Front-End Routes
Route::get('/', [HomeController::class, 'HomePage']);

// Pre-Login Routes
Route::get('/user-login', [UserController::class, 'loginPage']);
Route::post('/user-login', [UserController::class, 'userLogin']);
Route::get('/user-registration', [UserController::class, 'registrationPage']);
Route::post('/user-registration', [UserController::class, 'userRegistration']);
Route::get('/forget-password', [UserController::class, 'sendOTPPage']);
Route::get('/reset-password', [UserController::class, 'resetPasswordPage']);
Route::get('/verify-otp', [UserController::class, 'verifyOTPPage']);
Route::post('/verify-otp', [UserController::class, 'verifyOTP']);
Route::post('/send-otp', [UserController::class, 'sendOTPCode']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware('token');



Route::middleware(['token'])->group(function () {

    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'dashboardPage']);
    Route::get('/dashboard-summary', [DashboardController::class, 'dashboardSummary']);

    // User Profile Routes
    Route::get('/user-profile', [UserController::class, 'userProfilePage']);
    Route::get('/get-profile', [UserController::class, 'userProfile']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);
    Route::get('/logout', [UserController::class, 'userLogout']);

    // Category Routes
    Route::get('/category', [CategoryController::class, 'categoryPage']);
    Route::get('/list-category', [CategoryController::class, 'categoryList']);
    Route::post('/create-category', [CategoryController::class, 'categoryCreate']);
    Route::post('/delete-category', [CategoryController::class, 'categoryDelete']);
    Route::post('/update-category', [CategoryController::class, 'categoryUpdate']);
    Route::post('/category-by-id', [CategoryController::class, 'categoryById']);

    // Customer Routes
    Route::get('/customer', [CustomerController::class, 'customerPage']);
    Route::get('/list-customer', [CustomerController::class, 'customerList']);
    Route::post('/create-customer', [CustomerController::class, 'createCustomer']);
    Route::post('/delete-customer', [CustomerController::class, 'deleteCustomer']);
    Route::post('/update-customer', [CustomerController::class, 'updateCustomer']);
    Route::post('/customer-by-id', [CustomerController::class, 'customerById']);

    // Product Routes
    Route::get('/product', [ProductController::class, 'productPage']);
    Route::get('/list-product', [ProductController::class, 'productList']);
    Route::post('/create-product', [ProductController::class, 'createProduct']);
    Route::post('/delete-product', [ProductController::class, 'deleteProduct']);
    Route::post('/update-product', [ProductController::class, 'updateProduct']);
    Route::post('/product-by-id', [ProductController::class, 'productById']);

    // Invoices Routes
    Route::get('/invoice', [InvoiceController::class, 'invoicePage']);
    Route::get('/sale', [InvoiceController::class, 'salePage']);
    Route::get('/select-invoice', [InvoiceController::class, 'selectInvoice']);

    Route::post('/invoice-details', [InvoiceController::class, 'invoiceDetails']);
    Route::post('/create-invoice', [InvoiceController::class, 'createInvoice']);
    Route::post('/delete-invoice', [InvoiceController::class, 'invoiceDelete']);

    // Report Routes
    Route::get('/report', [ReportController::class, 'reportPage']);
    Route::get('/sales-report/{fromDate}/{toDate}', [ReportController::class, 'salesReport']);

});