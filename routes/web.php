<?php

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

Route::get('/', function () {
    return redirect(\route('products'));
});

//Route::get('/', 'ProductController@index')->name('main_products');

Route::get('/contact', 'ContactController@index')->name('contact_form');
Route::post('/contactsend', 'ContactController@sendmessage')->name('contact_form_send');
Route::get('/about', 'ContactController@about')->name('about');

Route::resource('products', 'ProductController')->
names([
    'index' => 'products',
]);

Route::resource('category', 'CategoryController')->
names([
    'index' => 'category',
]);


Route::post('/addcart', 'CartController@addcart')->name('addcart');
Route::post('/getquantity', 'CartController@getquantity')->name('getquantity');
Route::post('/setquantity', 'CartController@setquantity')->name('setquantity');
Route::post('/getprice', 'CartController@getprice')->name('getprice');
Route::post('/delcart', 'CartController@delcart')->name('delcart');
Route::get('/showcart', 'CartController@index')->name('showcart');
Route::get('/buycart', 'CartController@buycart')->name('buycart');
Route::get('/clearcart', 'CartController@clearcart')->name('clearcart');

Route::get('/showorder/{id}', 'OrderController@show')->name('showorder');
Route::get('/ordertocart/{id}', 'OrderController@ordertocart')->name('ordertocart');
Route::post('/changeorderstatus', 'OrderController@changeOrderStatus')->name('changeorderstatus');

Route::get('/paymentorder/{id}', 'PaymentController@paymentorder')->name('paymentorder');
Route::get('/newpaymentsystem/', 'PaymentController@newpaymentsystem')->name('newpaymentsystem');
Route::post('/getnotification_yoomoney', 'PaymentController@getnotification')->name('getnotification');
Route::get('/succesurl/{id}', 'PaymentController@succesurl')->name('succesurl');

Route::get('/send', 'MailController@send');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
