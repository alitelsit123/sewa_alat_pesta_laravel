<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Publics\BaseViewController;
use Illuminate\Support\Facades\Broadcast;

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

// Tests aja
Route::get('/recached', function() {
    \Artisan::call('optimize');
});

Route::get('user-image', function() {
    return 'data:image/png;base64,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
    I=';
});

Route::get('/default/data', function() {
    return response()->json([
        'user_image' => 'https://upload.wikimedia.org/wikipedia/commons/9/99/Sample_User_Icon.png',
    ]);
})->name('data-page');

Route::get('/notif', function() {
    return view('tests');
});
Route::get('send', [App\Http\Controllers\PusherTestController::class, 'notification']);

// End Tests

// user route
Route::get('/', [BaseViewController::class, 'showHomePage']);

Route::get('/products', [App\Http\Controllers\Publics\ProductController::class, 'showProductsPage']);
Route::post('/products/set_durasi', [App\Http\Controllers\Publics\ProductController::class, 'setDuration'])->name('set.duration');
Route::get('/products/{kategori}/{slug}/{id}', [App\Http\Controllers\Publics\ProductController::class, 'showProductsItemPage'])->name('product-view');

Route::get('/about', [App\Http\Controllers\Publics\BaseViewController::class, 'showAboutPage']);

Route::get('/cart', [App\Http\Controllers\Publics\KeranjangController::class, 'showCartPage']);
Route::middleware(['ShouldAddDuration', 'CartGuess'])->group(function() {
    Route::post('/cart/add', [App\Http\Controllers\Publics\KeranjangController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/cart/update', [App\Http\Controllers\Publics\KeranjangController::class, 'updateCart'])->name('update-cart');
    Route::delete('/cart/delete/{id}', [App\Http\Controllers\Publics\KeranjangController::class, 'deleteCart'])->name('delete-singleton-cart');
});

Route::get('/profile/{slug}', [App\Http\Controllers\Publics\ProfileController::class, 'showProfilePage'])->name('profile.show')->middleware(['auth']);

Route::get('/profile/{slug}/add_address', [App\Http\Controllers\Publics\ProfileController::class, 'addNewAddress'])->name('profile.add_address')->middleware(['auth']);
Route::get('/profile/{slug}/remove_address/{id}', [App\Http\Controllers\Publics\ProfileController::class, 'removeAddress'])->name('profile.remove_address')->middleware(['auth']);

Route::put('/profile/{slug}/update', [App\Http\Controllers\Publics\ProfileController::class, 'update'])->name('profile.update')->middleware(['auth']);
Route::put('/profile/{slug}/update_photo', [App\Http\Controllers\Publics\ProfileController::class, 'updatePhoto'])->name('profile.update-photo')->middleware(['auth']);

// user api route

Route::post('/api_v1/chat_with_bot', [App\Http\Controllers\Admin\LiveChatController::class, 'chatwithBot'])->name('chat-with-bot');
Route::post('/api_v1/searching_for_costumer_service', [App\Http\Controllers\Admin\LiveChatController::class, 'searchOnlineCs'])->name('search-online-cs');
Route::post('/api_v1/chat', [App\Http\Controllers\Admin\LiveChatController::class, 'chat'])->name('send_chat');
Route::post('/api_v1/chat/cs/store', [App\Http\Controllers\Admin\LiveChatController::class, 'chatWithCs'])->name('chat-with-cs');
Route::get('/api_v1/checkout/payment/type/{type}/change', [App\Http\Controllers\Publics\OrderController::class, 'changePaymentType'])->name('order.payment.type.change');
Route::post('/api_v1/checkout/book_duration/change', [App\Http\Controllers\Publics\OrderController::class, 'changeBookDuration'])->name('order.book.duration.change');
Route::get('/api_v1/web_notification/read', [App\Http\Controllers\Publics\NotificationController::class, 'markAsRead'])->name('notification.markread');

// Payment Notification dari midtrans
Route::post('/api_v1/order/payment/notification', [App\Http\Controllers\Publics\OrderController::class, 'paymentNotification'])->name('payment.notification');
Route::post('/api_v1/payment/poll/status', [App\Http\Controllers\Publics\OrderController::class, 'paymentCheckStatus'])->name('payment.check.status');

// Polling gakepake
Route::post('/api_v1/polling/payment/notification', [App\Http\Controllers\PollingController::class, 'paymentStatus'])->name('polling.payment.status');

// end user api route

Route::name('order.')->prefix('order')->group(function() {
    Route::middleware(['auth', 'verified'])->group(function() {
        Route::post('/checkout', [App\Http\Controllers\Publics\OrderController::class, 'checkData'])->middleware(['PreventOrder'])->name('proses.checkdata');
        Route::get('/checkout', [App\Http\Controllers\Publics\OrderController::class, 'checkoutView'])->middleware(['PreventOrder'])->name('proses.checkout.view');
        Route::post('/process_payment', [App\Http\Controllers\Publics\OrderController::class, 'processPayment'])->middleware(['PreventOrder'])->name('proses.init_payment');
        Route::get('/payment', [App\Http\Controllers\Publics\OrderController::class, 'makePayment'])->name('proses.payment');    
        Route::get('/payment/finish', [App\Http\Controllers\Publics\OrderController::class, 'finishPayment'])->name('payment.finish');    
    });
});

// end user route

Route::prefix('auth')->group(function() {

    // verifikasi email
    Route::get('/verify-email', [App\Http\Controllers\Auth\UserVerification::class, 'showVerifyEmail'])
    ->middleware('auth')
    ->name('verification.notice');
    Route::post('/verify-email/resend', [App\Http\Controllers\Auth\UserVerification::class, 'resendEmailVerification'])
    ->middleware('auth')
    ->name('verification.resend');
    Route::get('/verify-email/{id}/{hash}', [App\Http\Controllers\Auth\UserVerification::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
    // end verifikasi email

    // guest auth
    Route::middleware(['guest'])->group(function() {
        Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login-form');
        Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
        Route::post('/channels/authorize', [App\Http\Controllers\Auth\LoginController::class, 'authorizeWebsocket']);
        Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index']);
        Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

        Route::get('/admin/login', [App\Http\Controllers\Auth\LoginAdminController::class, 'index'])->name('admin.login-form');
        Route::post('/admin/login', [App\Http\Controllers\Auth\LoginAdminController::class, 'login'])->name('admin.login');

    });
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('user.logout');
    Route::post('/admin/logout', [App\Http\Controllers\Auth\LoginAdminController::class, 'logout'])->name('admin.logout');
    // end guest auth
});

// admin route
Route::middleware(['auth.admin'])->name('admin.')->group(function() {
    Route::prefix('admin')->group(function() {
        Route::get('/', function () {
            return redirect('/admin/dashboard');
        });
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
        Route::name('user.')->prefix('users')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
            Route::get('/{id}', [App\Http\Controllers\Admin\UserController::class, 'showUser'])->name('show');
            Route::get('/{id}/set_admin', [App\Http\Controllers\Admin\UserController::class, 'setAsAdmin'])->name('set.role.admin');
            Route::get('/{id}/remove_admin', [App\Http\Controllers\Admin\UserController::class, 'removeAdminRole'])->name('remove.role.admin');
        });
        Route::name('livechat.')->prefix('livecommunication')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\LiveChatController::class, 'index'])->name('index');
            Route::post('/chats/markasread', [App\Http\Controllers\Admin\LiveChatController::class, 'markAsReadChat'])->name('mark-as-read-chat');
            Route::post('/bot/add', [App\Http\Controllers\Admin\LiveChatController::class, 'botStore'])->name('bot.store');
            Route::put('/bot/{id}/update', [App\Http\Controllers\Admin\LiveChatController::class, 'botUpdate'])->name('bot.update');
            Route::delete('/bot/{id}/destroy', [App\Http\Controllers\Admin\LiveChatController::class, 'botDestroy'])->name('bot.destroy');
            Route::post('/connect_to_user', [App\Http\Controllers\Admin\LiveChatController::class, 'connectToUser'])->name('connect-to-user');
            Route::post('/disconnect_to_user', [App\Http\Controllers\Admin\LiveChatController::class, 'disconnectToUser'])->name('disconnect-chat');
            Route::post('/chat/user/store', [App\Http\Controllers\Admin\LiveChatController::class, 'chatWithUser'])->name('chat-with-user');            
        });
        Route::name('transaksi.')->prefix('transaksi')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\TransaksiController::class, 'index'])->name('index');
        });
        Route::name('order.')->prefix('order')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
            Route::get('/{kode_pesanan}/destroy', [App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('destroy');
            Route::get('/{kode_pesanan}/{type}/ship', [App\Http\Controllers\Admin\OrderController::class, 'shipmentOut'])->name('shipment');
            Route::get('/{kode_pesanan}/{type}/{type_payment}/payment', [App\Http\Controllers\Admin\OrderController::class, 'confirmPayment'])->name('confirm.payment');
            Route::get('/v/{kode_pesanan}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('show');
        });
        Route::name('sewa.')->prefix('sewa')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\SewaController::class, 'index'])->name('index');
            Route::get('/{id}/complete', [App\Http\Controllers\Admin\SewaController::class, 'complete'])->name('complete');
        });
        Route::name('search.')->prefix('search')->group(function() {
            Route::get('/', [App\Http\Controllers\Admin\GeneralSearchController::class, 'index'])->name('index');
        });
    });


    Route::resource('admin/kategori', \App\Http\Controllers\Admin\KategoriController::class);
    Route::resource('admin/produk', \App\Http\Controllers\Admin\ProdukController::class);
});

// end admin route

// global api request data kolektor buat javascript
Route::get('/user/collect', [App\Http\Controllers\CollectorController::class, 'collectUser'])->name('user.collect');
Route::get('/sesi/collector', [App\Http\Controllers\CollectorController::class, 'collectSesi'])->name('sesi.collect');
Route::get('/user_sesi/collector', [App\Http\Controllers\CollectorController::class, 'collectUserSesi'])->name('sesi.collect.user');
// end global api

// import route di channel.php
Broadcast::routes();

// Route::get('/test/broadcast/{id}', [App\Http\Controllers\Admin\LiveChatController::class, 'testBroadcast']);