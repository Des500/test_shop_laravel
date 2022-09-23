<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    public function addOrder($userdata_id) {
        $cart = new Cart();
        $current_cart = $cart->summaProductsInCart();
        $cart_items = $current_cart->cart;
//        foreach ($cart_items as $key => $item){
//            unset($cart_items[$key]['price']);
//            unset($cart_items[$key]['summa']);
//        }
        $order_content = json_encode($cart_items);
        $this->user_id = Auth::user()->id;
        $this->order_id = Auth::user()->email.time();
        $this->order_content = $order_content;
        $this->summa = $current_cart->summa;
        $this->userdata_id = $userdata_id;
        $this->order_status = "new";
        $this->created_at = time();
        $this->updated_at = time();
        $this->save();
    }

    public static function orderstatus () {
        $data = [
            'new' => 'Новый',
            'paid' => 'Оплачен',
            'shipped' => 'Отгружен',
            'delivered' => 'Доставлен',
        ];
        return $data;
    }

    public static function orderWithProducts ($order) {
        $order_content = (array)json_decode($order->order_content);
        foreach ($order_content as $product_id => $cart_item) {
            $product = Product::find($product_id);
            $order_content[$product_id]->product = $product;
        }
        return $order_content;
    }

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function products () {
        return $this->hasMany(Product::class);
    }

    public function userdata () {
        return $this->belongsTo(UserData::class);
    }
}
