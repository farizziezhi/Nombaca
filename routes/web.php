<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\CirculationController;
use Illuminate\Support\Facades\Route;

// ═══════════════════════════════════════════════════════
// Katalog Publik — akses bebas untuk Guest & Member
// ═══════════════════════════════════════════════════════
Route::get('/', [CatalogController::class, 'index'])->name('catalog');
Route::get('/katalog/{book:isbn}', [CatalogController::class, 'show'])->name('catalog.show');

// ═══════════════════════════════════════════════════════
// Dashboard — redirect berdasarkan role
// ═══════════════════════════════════════════════════════
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin', 'petugas' => redirect()->route('staff.circulation.index'),
        default            => redirect()->route('borrowings.index'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ═══════════════════════════════════════════════════════
// Member Routes — dilindungi middleware auth + role:user
// ═══════════════════════════════════════════════════════
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/my-borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
});

// ═══════════════════════════════════════════════════════
// Staff Routes — admin & petugas (Meja Sirkulasi)
// ═══════════════════════════════════════════════════════
Route::middleware(['auth', 'role:admin,petugas'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::prefix('circulation')->name('circulation.')->group(function () {
            Route::get('/', [CirculationController::class, 'index'])->name('index');
            Route::patch('/{borrowing}/approve', [CirculationController::class, 'approve'])->name('approve');
            Route::patch('/{borrowing}/return', [CirculationController::class, 'returnBook'])->name('return');
        });

        Route::prefix('fines')->name('fines.')->group(function () {
            Route::get('/', [App\Http\Controllers\Staff\FineController::class, 'index'])->name('index');
            Route::patch('/{fine}/pay', [App\Http\Controllers\Staff\FineController::class, 'pay'])->name('pay');
        });

        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::get('/', [App\Http\Controllers\Staff\BookStockController::class, 'index'])->name('index');
            Route::patch('/{book}/stock', [App\Http\Controllers\Staff\BookStockController::class, 'update'])->name('update');
        });
    });

// ═══════════════════════════════════════════════════════
// Admin Routes — dilindungi middleware auth + role:admin
// ═══════════════════════════════════════════════════════
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('books', BookController::class)->except(['show']);
        
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
            Route::get('/preview', [App\Http\Controllers\Admin\ReportController::class, 'preview'])->name('preview');
            Route::get('/export', [App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('export');
        });
        
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
            Route::patch('/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('updateRole');
        });
    });

require __DIR__.'/auth.php';
