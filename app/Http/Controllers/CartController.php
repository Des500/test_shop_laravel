<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{

    public function index () {
        $cart = new Cart();
        $data = [
            'products' => $cart->summaProductsInCart(),
            'title' => 'Корзина'
        ];
        $cart_items = $data['products']['cart'];
        foreach ($cart_items as $key => $product)
            $cart_items[$key]['product'] = Product::find($key);
        $data['products']['cart']=$cart_items;
//        $data = $cart->summaProductsInCart();
        return view('cart.index')->with($data);
    }

    public function addcart (Request $request)
    {
        $cart = new Cart();
        $data = [
            'session' => json_encode($cart->addToCart($request->input('product_id'), $request->input('product_quantity')))
        ];
        return die($data['session']);
//        return view('cart.addcart')->with($data);
    }

    public function getquantity (Request $request) {
        $cart = new Cart();
        $data = [
            'session' => json_encode($cart->summaProductsInCart())
        ];
        return die($data['session']);
    }

    public function getprice (Request $request) {
        $product = Product::find($request->input('product_id'));
        $data = [
            'product' => json_encode([
                'price' => $product->price,
                'summa' => $product->price*$request->input('product_quantity')
            ])
        ];
        return die($data['product']);
    }

    public function setquantity (Request $request) {
        $cart = new Cart();
        $data = [
            'session' => json_encode($cart->setQuantityProductInCart($request->input('product_id'), $request->input('product_quantity')))
        ];
        return die($data['session']);
    }

    public function delcart (Request $request) {
        $cart = new Cart();
        $data = [
            'session' => json_encode($cart->deleteFromCart($request->input('product_id')))
        ];
        return die($data['session']);
    }

    public function clearcart (Request $request) {
        $cart = new Cart();
        $data = [
            'products' => $cart->clearCart(),
            'title' => 'Корзина'
        ];
        return view('cart.index')->with($data);
    }

    public function buycart (Request $request) {

        if(Auth::guest())
            return redirect(route('showcart'))->with('error', 'Необходимо зарегистрироваться или авторизоваться на сайте перед покупкой');
        return redirect( route('adresses.select') );
    }

}

