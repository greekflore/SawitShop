<?php

use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Feature\OrderController;
use App\Http\Controllers\Backend\Master\CategoryController;
use App\Http\Controllers\Backend\Master\ProductController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\TransacationController;
use App\Http\Controllers\Midtrans\MidtransController;
use App\Http\Controllers\Rajaongkir\RajaongkirController;
use App\Http\Controllers\Setting\WebconfigController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Master\VoucherController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ReviewController;




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

Route::post('payments/midtrans-notification', [MidtransController::class, 'receive']);
Route::post('payments/midtrans-success', [MidtransController::class, 'success']);

Route::prefix('app')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
        });

        Route::prefix('master')->name('master.')->group(function () {
            Route::prefix('category')->name('category.')->group(function () {
                Route::get('/', [CategoryController::class, 'index'])->name('index');
                Route::get('/create', [CategoryController::class, 'create'])->name('create');
                Route::post('/create', [CategoryController::class, 'store'])->name('store');
                Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
                Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
                Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
            });

            Route::prefix('product')->name('product.')->group(function () {
                Route::get('/', [ProductController::class, 'index'])->name('index');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('/create', [ProductController::class, 'store'])->name('store');
                Route::get('/show/{id}', [ProductController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
            });

            // Voucher routes
            Route::prefix('voucher')->name('voucher.')->group(function () {
                Route::get('/', [VoucherController::class, 'index'])->name('index');
                Route::get('/create', [VoucherController::class, 'create'])->name('create');
                Route::post('/create', [VoucherController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [VoucherController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [VoucherController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [VoucherController::class, 'delete'])->name('delete');
                Route::get('/show/{id}', [VoucherController::class, 'show'])->name('show');
            });
        });

        Route::prefix('feature')->name('feature.')->group(function () {
            Route::prefix('order')->name('order.')->group(function () {
                Route::get('/{status?}', [OrderController::class, 'index'])->name('index');
                Route::get('/detail/{id}', [OrderController::class, 'show'])->name('show');
                Route::post('/detail/input-resi', [OrderController::class, 'inputResi'])->name('inputresi');
            });
        });

        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('/shipping', [WebconfigController::class, 'shipping'])->name('shipping');
            Route::post('/shipping', [WebconfigController::class, 'shippingUpdate'])->name('shippingUpdate');
            Route::get('/web', [WebconfigController::class, 'web'])->name('web');
            Route::post('/web', [WebconfigController::class, 'webUpdate'])->name('web.update');
        });
    });
});

Route::middleware('auth', 'role:user')->group(function () {
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/store', [CartController::class, 'store'])->name('store');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CartController::class, 'delete'])->name('delete');
    });

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/', [TransacationController::class, 'index'])->name('index');
        Route::get('/{invoice_number}', [TransacationController::class, 'show'])->name('show');
        Route::get('/{invoice_number}/received', [TransacationController::class, 'received'])->name('received');
        Route::get('/{invoice_number}/canceled', [TransacationController::class, 'canceled'])->name('canceled');
    });

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    });

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
    });
});

Route::prefix('rajaongkir')->name('rajaongkir.')->group(function () {
    Route::post('/cost', [RajaongkirController::class, 'cost'])->name('cost');
    Route::get('/province/{id}', [RajaongkirController::class, 'getCity'])->name('city');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route Product
Route::get('/product', [FrontendProductController::class, 'index'])->name('product.index');
Route::get('/search', [FrontendProductController::class, 'search'])->name('product.search');

// Route Category
Route::get('/category', [FrontendCategoryController::class, 'index'])->name('category.index');
Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('category.show');

// Route untuk menampilkan produk dengan kategori
Route::get('/product/{categoriSlug}/{productSlug}', [FrontendProductController::class, 'show'])->name('product.show');
// Voucher routes
Route::get('/vouchers', [VoucherController::class, 'index'])->name('master.voucher.index');

Route::post('/check-voucher', [VoucherController::class, 'checkVoucher'])->name('voucher.check');

use App\Http\Controllers\EmailController;

Route::get('/send-email', [EmailController::class, 'sendEmail']);

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [FaqController::class, 'faq'])->name('faq');
// Route::get('/test-view', action: [TestController::class, 'test']);
Route::post('/reviews/{orderDetailId}', [ReviewController::class, 'store'])->name('reviews.store');


Route::post('/app/feature/order/detail/input-resi/{id}', [OrderController::class, 'inputResi'])->name('order.inputResi');


Route::post('/transaction/review/{orderDetailId}', 'TransactionController@storeReview')->name('transaction.storeReview');

require __DIR__ . '/auth.php';
