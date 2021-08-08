<?php

use App\Http\Controllers\Admin\ApprovedStoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocationsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserTransactionsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\TransferToStoreController;
use App\Http\Controllers\Admin\AllProductController;
use App\Http\Controllers\Admin\AllTransactionController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LaporanController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/category/all', [HomeController::class, 'category'])->name('category');

Route::get('/shop', [ShopController::class, 'index'])->name('kado');
Route::post('/shop/filter/price/', [FilterController::class, 'shopFilterPrice'])->name('shop-filter-price');
Route::get('/shop/filter/category/{slug}', [FilterController::class, 'shopFilterCategory'])->name('shop-filter-category');
Route::post('/shop/filter/location/', [FilterController::class, 'shopFilterLocation'])->name('shop-filter-location');
Route::get('/shop/filter/az/{q}', [FilterController::class, 'shopFilterAsc'])->name('shop-filter-asc');

Route::get('/detail/product/{slug}', [DetailController::class, 'index'])->name('detail.product');
Route::get('/detail/store/{url}', [DetailController::class, 'detailstore'])->name('detail-store');
Route::post('/detail/store/product/filter/price/', [FilterController::class, 'price'])->name('store-filter-product-price');
Route::get('/detail/store/{id}/product/filter/category/{name}', [FilterController::class, 'category'])->name('store-filter-product-category');

Route::post('/category/natal/filter/price/', [FilterController::class, 'filterCategoryPrice'])->name('category-filter-price');

Route::get('/category/{slug}', [DetailController::class, 'detailcategory'])->name('detail-category');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'detail'])->name('detail-blog');


Route::group(['prefix'=>'admin', 'middleware' => ['role:admin']], function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin-dashboard');
    Route::resource('post', PostController::class);
    Route::resource('/category', AdminCategory::class);
    Route::get('/allstore', [ApprovedStoreController::class, 'approved'])->name('approved-store');
    Route::get('/newstore', [ApprovedStoreController::class, 'new'])->name('new-store');
    Route::get('/checkstore/{slug}', [ApprovedStoreController::class, 'show'])->name('show-store-to-approved');
    Route::post('/accept/{slug}', [ApprovedStoreController::class, 'accept'])->name('accept-store');
    Route::post('/disapproved/{slug}', [ApprovedStoreController::class, 'disapproved'])->name('cancel approved');
    Route::get('/users/index', [UserController::class, 'alluser'])->name('users.index');
    Route::get('/users/customers', [UserController::class, 'customers'])->name('users.customers');
    Route::get('/users/detail/{id}', [UserController::class, 'detailuser'])->name('detail-user');
    
    Route::resource('/role', RoleController::class);
    Route::get('/update/password', [UserController::class, 'formupdatepassword'])->name('form-update-password');
    Route::post('/update/password{redirect}', [UserController::class, 'updatepassword'])->name('update-password');

    Route::resource('/banner', BannerController::class);

    Route::resource('/transfertostore', TransferToStoreController::class);

    Route::get('mail/send/{code}', [MailController::class, 'send'])->name('mailsend');

    Route::resource('/allproduct', AllProductController::class);

    Route::get('alltransaction', [AllTransactionController::class, 'index'])->name('alltransaction.index');

    Route::get('alltransaction/show/{id}', [AllTransactionController::class, 'show'])->name('alltransaction.show');

    Route::post('/laporan/penjualan', [LaporanController::class, 'pdflaporanadmin'])->name('pdflaporanadmin');

    
});

Route::group(['middleware' => ['auth']], function() {

    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user-dashboard');

    Route::resource('/product', ProductController::class);
    Route::get('/update/password', [UserController::class, 'formupdatepassword'])->name('form-update-password');
    Route::post('/update/password/{redirect}', [UserController::class, 'updatepassword'])->name('update-password');

    Route::get('/store', [StoreController::class, 'index'])->name('my-store');


    Route::post('/store/create', [StoreController::class, 'store'])->name('store.create');

    Route::get('/store/edit/{user_id}', [StoreController::class, 'edit'])->name('store.edit');
    Route::post('/store/update/{id}', [StoreController::class, 'update'])->name('store.update');

    Route::get('/province/{id}/cities', [LocationsController::class, 'getCities']);
    Route::resource('/store', StoreController::class);

    Route::post('/cart/{id}', [DetailController::class, 'addToCart'])->name('detail.addToCart');
   
    // Route::delete('/cart/delete/{id}', [CartController::class, 'deleteCart'])->name('delete-cart');
    // Route::resource('/cart', CartController::class);
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart-delete');


    // Route::delete('/deletecart/{id}', [DetailController::class, 'deleteCartItem']);

    Route::get('/dashboard/account/', [UserController::class, 'profil'])->name('profil');
    Route::post('/dashboard/update/{redirect}', [UserController::class, 'update'])
    ->name('dashboard-settings-redirect');

    Route::get('/checkout', [CheckoutController::class, 'proccess'])->name('checkout');

    Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('midtrans-callback');

    Route::post('/ongkir', [CheckoutController::class, 'cekongkir'])->name('cek-ongkir');

    Route::get('/ongkir', [CheckoutController::class, 'selectedongkir'])->name('select-ongkir');

    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

    Route::resource('transaction', TransactionController::class);

    Route::get('user/transaction', [UserTransactionsController::class, 'index'])->name('user-transaction');

    Route::get('user/transaction/detail/{id}', [UserTransactionsController::class, 'detail'])->name('detail-user-transaction');

    Route::post('bayar/{code}', [CheckoutController::class, 'paylater'])->name('bayar-sekarang');

    Route::post('/pdf/{code}', [UserTransactionsController::class, 'pdf'])->name('pdf');

    Route::get('laporan/penjualan', [LaporanController::class, 'index'])->name('laporan.penjualan');

    Route::post('/laporan/penjualan', [LaporanController::class, 'pdflaporan'])->name('pdflaporan');

});
