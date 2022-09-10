<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if(Auth::guest() || (Auth::user()->role !== "admin"))
            $orders = $user->orders()->orderBy('id','desc')->get();
        else
            $orders = Order::orderBy('id','desc')->get();
        $data = [
            'orders' => $orders,
            'orderstatus' => Order::orderstatus()
        ];
//        $data['orders']->user = auth()->user();
        return view('users.home')->with($data);
    }
}
