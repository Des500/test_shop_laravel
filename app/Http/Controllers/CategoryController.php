<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        $this->middleware ('auth', [
            'except' => [
                'index',
                'show',
                ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Auth::guest() || (Auth::user()->role !== "admin"))
            return redirect('/products')->with('error', 'you are not authorized');
        $data = [
            'title' => 'Создание категории',
            'message' => ''
        ];
        return view('categories.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required|max:190|min:5',
        ]);
        $category = new Category();
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->public = $request->input('public')==='on' ? true: false;
        $category->created_at = time();
        $category->updated_at = time();
        $category->save();
        return redirect(route('products'))->with(['success' => 'Категория успешно добавлена']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $condition = [
            'public' => true,
            'in_stock' => true
        ];
        $category = Category::find($id);
//        $products = $category->products()->orderBy('id','asc')->paginate(10);
        if(Auth::guest() || (Auth::user()->role !== "admin"))
            $products = $category->products()->where($condition)->orderBy('id','asc')->paginate(10);
        else
            $products = $category->products()->orderBy('id','asc')->paginate(10);
        $data = [
            'title' => $category->title,
            'category_id' => $id,
            'products' => $products,
        ];
        return view('products.index')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Category::find($id);
        $data = [
            'title' => "Редактирование категории",
            'category' => $category,
            'message' => ''
        ];
        return view('categories.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //
        $this->validate($request, [
            'title' => 'required|max:190|min:4',
        ]);
        $category = Category::find($id);
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->public = $request->input('public')==='on' ? true: false;
        $category->updated_at = time();
        $category->save();
        return redirect(route('category.show', ['category' => $id]))->with(['success' => 'Категория успешно изменена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
