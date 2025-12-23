<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
        Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [App\Http\Controllers\ReportController::class, 'print'])->name('reports.print');
        Route::resource('categories', App\Http\Controllers\CategoryController::class);
        Route::resource('payment-methods', App\Http\Controllers\PaymentMethodController::class);
        Route::patch('/payment-methods/{payment_method}/toggle', [App\Http\Controllers\PaymentMethodController::class, 'toggleActive'])->name('payment-methods.toggle');
        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::patch('/users/{user}/toggle', [App\Http\Controllers\UserController::class, 'toggleActive'])->name('users.toggle');
        
        // Archive management
        Route::get('/archive', [App\Http\Controllers\ArchiveController::class, 'index'])->name('archive.index');
        Route::get('/archive/{archivedTransaction}', [App\Http\Controllers\ArchiveController::class, 'show'])->name('archive.show');
        Route::post('/archive/run', [App\Http\Controllers\ArchiveController::class, 'archive'])->name('archive.run');
        Route::post('/archive/purge', [App\Http\Controllers\ArchiveController::class, 'purge'])->name('archive.purge');
        Route::post('/archive/{archivedTransaction}/restore', [App\Http\Controllers\ArchiveController::class, 'restore'])->name('archive.restore');
        Route::delete('/archive/{archivedTransaction}', [App\Http\Controllers\ArchiveController::class, 'destroy'])->name('archive.destroy');
        Route::delete('/archive/{archivedTransaction}', [App\Http\Controllers\ArchiveController::class, 'destroy'])->name('archive.destroy');
        
        // DANGEROUS: Force reset data route
        Route::get('/force-reset-data', function () {
            if (request('key') !== 'mukitcell-secret-deploy') {
                abort(403, 'Unauthorized action.');
            }
            
            // Increase memory limit for seeding
            ini_set('memory_limit', '512M');
            set_time_limit(300); // 5 minutes
            
            Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed --force'); // --force needed for production
            
            return 'Database reset and seeded successfully! <a href="' . route('dashboard') . '">Go to Dashboard</a>';
        });
    });

    // Cashier & Admin routes
    Route::middleware(['role:admin,cashier'])->group(function () {
        Route::get('/pos', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
        Route::post('/pos', [App\Http\Controllers\PosController::class, 'store'])->name('pos.store');
        Route::get('/pos/search-products', [App\Http\Controllers\PosController::class, 'searchProducts'])->name('pos.search-products');
        
        // Product management
        Route::resource('products', ProductController::class);
        Route::patch('/products/{product}/toggle', [ProductController::class, 'toggleActive'])->name('products.toggle');
        
        // Transaction history (accessible by cashier and admin)
        Route::get('/transactions/{transaction}/print', [App\Http\Controllers\TransactionController::class, 'print'])->name('transactions.print');
        Route::get('/transactions/{transaction}/download-pdf', [App\Http\Controllers\TransactionController::class, 'downloadPdf'])->name('transactions.download-pdf');
        Route::resource('transactions', App\Http\Controllers\TransactionController::class)->only(['index', 'show']);
    });
});

require __DIR__.'/auth.php';
