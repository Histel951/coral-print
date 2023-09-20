<?php

use App\Http\Controllers\CallController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentDeliveryController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\ReviewsController;
use App\Models\Content;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

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
Route::get('/catalog/vue/new', [OrderController::class, 'vueCatalog']);
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::get('/components', [ComponentsController::class, 'components']);
Route::get('/contacts', [ContactsController::class, 'contacts'])->name('contacts');
Route::get('/order', [OrderController::class, 'order']);
Route::get('/order-thank', [OrderController::class, 'orderThank']);
Route::get('/payment-delivery', [PaymentDeliveryController::class, 'paymentDelivery'])->name('payment-delivery');
Route::get('/reviews/{contentId}', [ReviewsController::class, 'reviews'])->name('reviews');
Route::get('/reviews', [ReviewsController::class, 'reviewsAll'])->name('reviews-all');

Route::post('/send_review', [ReviewsController::class, 'send']);

Route::get('/get_gallery', [GalleryController::class, 'getGallery']);
Route::get('/get_gallery_info', [GalleryController::class, 'getInfo']);

Route::post('/upload_files', [FileController::class, 'upload'])->name('upload');
Route::delete('/delete-file/{id}', [FileController::class, 'delete'])->name('delete-file');
Route::get('/add_gallery_file', [FileController::class, 'add']);

Route::prefix('calc')->name('calc.')->group(function () {
    Route::prefix('test')->name('test.')->group(function () {
        Route::get('/', function () {
            return view('calc.test_calcs');
        });
        // возможно нужно будет для флексы - пока не удалять
    });
});

Route::post('callback', [CallController::class, 'callback']);
Route::post('footer_order_form', [OrderController::class, 'send']);
Route::get('download', [OrderController::class, 'download'])->name('order.download')->middleware('auth');
Route::get('promocodes', [PromocodeController::class, 'index'])->name('promocodes');

$contentRoutes = [];
if (Cache::has('contents')) {
    $contentRoutes = Cache::get('contents');
} elseif (Schema::hasTable('contents')) {
    foreach (Content::where('is_visible', true)->get(['content_id', 'url']) as $model) {
        $contentRoutes[$model->content_id] = $model->url;
    }
    Cache::put('contents', $contentRoutes);
}

foreach ($contentRoutes as $value) {
    Route::get($value, [ContentController::class, 'index']);
}
