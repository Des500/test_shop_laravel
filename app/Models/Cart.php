<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    private $session_name = 'cart';

    public function isSetSession () {
        return !empty($this->getSession());
    }

    public function deleteSession () {
        session([
            $this->session_name => null
        ]);
    }

    public function getSession () {
        return session($this->session_name, []);
    }

    public function addToCart ($product_id, $quantity = 1) {
        $price = Product::find($product_id)->price;
        $cart_session = $this->getSession();
        if ((!$this->isSetSession())|| (!array_key_exists($product_id, $cart_session))) {
            $cart_session[$product_id] = [
                'quantity' => $quantity,
                'price' => $price,
                'summa' => ($price*$quantity)
            ];
        }
        else{
            $cart_session[$product_id]['quantity'] +=$quantity;
            $cart_session[$product_id]['summa'] += $price*$quantity;
        }

        session([$this->session_name => $cart_session]);
        session()->save();

        return $this->summaProductsInCart();
    }

    public function setQuantityProductInCart ($product_id, $quantity) {
        $price = Product::find($product_id)->price;
        $cart_session = $this->getSession();
        if (($this->isSetSession()) && (array_key_exists($product_id, $cart_session))) {
            {
                $cart_session[$product_id]['quantity'] =$quantity;
                $cart_session[$product_id]['summa'] = $price*$quantity;
                session([$this->session_name => $cart_session]);
                session()->save();
            }
        }
        return $this->summaProductsInCart();
    }

    public function deleteFromCart ($product_id) {
        $cart_session = $this->getSession();
        if (($this->isSetSession()) && (array_key_exists($product_id, $cart_session))) {
            {
                unset($cart_session[$product_id]);
                session([$this->session_name => $cart_session]);
                session()->save();
            }
        }
        return $this->summaProductsInCart();
    }

    public function clearCart () {
        $this->deleteSession();
        return $this->summaProductsInCart();
    }

    public function summaProductsInCart () {

        $this->summa_quantity = 0;
        $this->summa = 0;
        $this->cart = [];

//        $data = [
//            'summa_quantity' => 0,
//            'summa' => 0,
//            'cart' => [],
//        ];
        if ($this->isSetSession()) {
            {
                $cart_session = $this->getSession();
                foreach ($cart_session as $item) {
//                    $data['summa_quantity'] += $item['quantity'];
//                    $data['summa'] += $item['quantity']*$item['price'];

                    $this->summa_quantity += $item['quantity'];
                    $this->summa += $item['quantity']*$item['price'];
                }
//                $data['cart'] = $cart_session;
                $this->cart = $cart_session;
            }
        }
        return $this;
    }


//
//    public function clearCart () {
//        if ($this->isSetSession())
//            unset($_SESSION[$this->session_name]);
//    }
//
//    public function countItems () {
//        if (!$this->isSetSession())
//            return 0;
//        else
//            return count(array_keys($_SESSION[$this->session_name]));
//    }
}
