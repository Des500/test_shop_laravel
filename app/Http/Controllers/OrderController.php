<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * Для неавторизованных - запрет на все функции кроме index, show
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function show ($id) {

        $order = Order::find($id);
        if(Auth::user()->id != $order->user_id && Auth::user()->role !== 'admin')
            return redirect(route('products'))->with('error', 'Вы не формировали данный заказ');

        $order->products = Order::orderwithproducts($order);
        $data = [
            'order' => $order,
            'orderstatus' => Order::orderstatus()
        ];
        return view('orders.showorder')->with($data);
    }
    public function changeOrderStatus (Request $request) {
        $order_id = $request->input('order_id');
        $order_newstatus = $request->input('orderstatus');
        $order = Order::find($order_id);
        $order->order_status = $order_newstatus;
        $order->save();
        $data = ['success' => 'Ордер успешно изменен на '.Order::orderstatus()[$order_newstatus]];
        if($order_newstatus === 'shipped') {
            $ordermail = new MailController();
            $ordermail->sendOrder($order);
            $data['success'] .= '. Сообщение отправлено';
        }
        return redirect(route('showorder', ['id' => $order_id]))->with($data);;
    }

    function ordertocart ($id) {
        echo $id;
        $order = Order::find($id);
        $cart = new Cart();
        $order_content = (array)json_decode($order->order_content);
        foreach ($order_content as $product_id => $cart_item) {
            $cart->addToCart($product_id, $cart_item->quantity);
        }
        return redirect(route('showcart'))->with(['success' => 'Товар из заказа успешно добавлен']);
    }
}
