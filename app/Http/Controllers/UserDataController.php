<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;

class UserDataController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adressSelect () {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $data = [
            'adresses' => $user->adresses()->orderBy('id','desc')->get(),
            'title' => 'Оформление заказа - выбор адреса'
        ];
        return view('users.userdata.select')->with($data);
    }

    public function showAjax (Request $request) {
        $adress = UserData::find($request->input('id'));
        die(json_encode($adress));
    }

    public function index()
    {
        //
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $data = [
          'adresses' => $user->adresses()->orderBy('id','desc')->get(),
          'title' => 'Личный кабинет - Данные заказчика'
        ];
        return view('users.userdata.index')->with($data);
    }


    public function create()
    {
        $adress = new \stdClass();
        $adress->contact_phone = '';
        $adress->contact_adress = '';
        $adress->contact_name = '';
        $data = [
            'form_action' => route('adresses.store'),
            'method_put' => false,
            'adress' => $adress,
            'title' => 'Личный кабинет - Добавить адрес заказчика',
            'message' => ''
        ];
        return view('users.userdata.edit')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'contact_name' => 'required|min:5',
            'contact_phone' => 'required|min:6',
            'contact_adress' => 'required|min:20'
        ]);
        $adress = new UserData();
        $adress->contact_name = $request->input('contact_name');
        $adress->contact_phone = $request->input('contact_phone');
        $adress->contact_adress = $request->input('contact_adress');
        $adress->user_id = auth()->user()->id;
        $adress->created_at = time();
        $adress->updated_at = time();

        $adress->save();
        return redirect(route('adresses'))->with(['success' => 'Адрес успешно добавлен']);
    }


    public function show($id)
    {

    }

    public function edit($id)
    {
        $adress = UserData::find($id);
        $data = [
            'form_action' => route('adresses.update', ['adress' => $id]),
            'method_put' => true,
            'adress' => $adress,
            'title' => 'Личный кабинет - Изменить адрес заказчика',
            'message' => ''
        ];
        return view('users.userdata.edit')->with($data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'contact_name' => 'required|min:5',
            'contact_phone' => 'required|min:6',
            'contact_adress' => 'required|min:20'
        ]);
        $adress = UserData::find($id);;
        $adress->contact_name = $request->input('contact_name');
        $adress->contact_phone = $request->input('contact_phone');
        $adress->contact_adress = $request->input('contact_adress');
        $adress->updated_at = time();

        $adress->save();
        return redirect(route('adresses'))->with(['success' => 'Адрес успешно изменен']);
    }

    public function destroy($id)
    {
        //
    }
}
