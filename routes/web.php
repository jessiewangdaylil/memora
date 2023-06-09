<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::namespace ('App\Http\controllers')->group(function () {
        Route::get('/dashboard', 'AuthController@dashboard')->name('dashboard');
        Route::get('/member_rigister', 'AuthController@authLevel2');
        Route::post('/member_rigister', 'AuthController@authLevel2Store');
        Route::get('/like_item_list', 'AuthController@likeItemList');
        Route::get('/recommend_relation', 'AuthController@recommendRelation');

    });
    Route::namespace ('App\Http\controllers')->group(function () {
        Route::get('/product_details/{item}', 'SiteController@product_details');
        Route::get('/add_item/{item}', 'SiteController@addItem');
        Route::get('/checkout', 'SiteController@checkout');
        Route::get('/confirmation', 'SiteController@confirmation');

    });
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::namespace ('App\Http\controllers')->group(function () {
    Route::get('/about', 'SiteController@about');
    Route::get('/', 'SiteController@index');
    Route::get('/shop', 'SiteController@shop');
    Route::get('/elements', 'SiteController@elements');
    Route::get('/cart', 'SiteController@cart');
    Route::get('/logout1', 'SiteController@logout');

    Route::get('/contact', 'SiteController@contact');
    Route::post('/contactstored', 'SiteController@storeContact');
    Route::get('/blogsidebar', 'SiteController@blogSidebar');
    Route::get('/blog_details/{id}', 'SiteController@blog_details');
    Route::get('/blog/{cgies?}', 'SiteController@blog');
    Route::post('/commentstored', 'SiteController@StoreComment');
    Route::get('/contact2', 'SiteController@contact2'); //表單元素集測試
    Route::post('/contactstored2', 'SiteController@storeContactTest'); //表單元素集測試
    Route::get('getcart', function () {
        $cart = \Cart::session(Auth::user()->id)->getContent();
        dd($cart);

    });

    Route::view('/livewire', 'counter');

    Route::get('/clean', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:cache');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        Artisan::call('optimize:clear');

        return "all cleared ...";
    });
    Route::get('/test', function () {
        $Items = \Cart::session(Auth::user()->id)->getContent();
        return \Cart::session(Auth::user()->id)->getTotal();
    });

});