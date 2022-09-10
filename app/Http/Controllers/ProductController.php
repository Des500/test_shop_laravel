<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
        $this->middleware('auth', [
            'except' => [
                'index',
                'show',
            ]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $condition = [
            'public' => true,
            'in_stock' => true
        ];
        $data = [
            'title' => 'Все товары',
            'category' => null,

//            'products' => Product::orderBy('id', 'desc')->paginate(10),
//            'products' => Product::where($condition)->paginate(10),
            'products' => null

        ];

        if(Auth::guest() || (Auth::user()->role !== "admin"))
            $data['products'] = Product::where($condition)->orderBy('id','asc')->paginate(10);
        else
            $data['products'] = Product::orderBy('id', 'asc')->paginate(10);

        return view('products.index')->with($data);

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
            return redirect(route('products'))->with('error', 'you are not authorized');

        $categories = Category::getlistnavbar();
        $form = [
            'cat_id' => 1,
            'categories' => $categories,
            'title' => 'lorem lorem',
            'shot_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae, quos.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquam aliquid, aperiam, at blanditiis, delectus facere illum modi obcaecati perferendis quaerat temporibus tenetur. Atque dolorem ea eos molestiae quo voluptates.',
            'image' => 'no_image.jpg',
            'price' => 10,
            'in_stock' => 'checked',
            'public' => 'checked',
        ];
        $data = [
            'title' => 'Создание товара',
            'form' => $form,
            'message' => ''
        ];
        return view('products.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required|min:4',
            'title' => 'required|max:190|min:5',
            'shot_desc' => 'required|max:190|min:5',
            'description' => 'required|max:1024|min:10',
            'price' => 'required|max:6|min:1',
            'image' => 'nullable|image|max:1999'
        ]);
        if($request->hasFile('image') == true) {
            $file = $request->file('image')->getClientOriginalName();
            $image_name_without_ext = pathinfo($file, PATHINFO_FILENAME);
            $ext = $request->file('image')->getClientOriginalExtension();
            $image_name = str_slug($request->input('title'))."_".str_slug($image_name_without_ext)."_".time().".".$ext;
            $path = $request->file('image')->storeAs('public/images/products/', $image_name);

        } else {
            $image_name = 'no_image.jpg';
        }

        $product = new Product();
        $product->title = $request->input('title');
        $product->category_id = explode(' - ',$request->input('category'))[0];
        $product->shot_desc = $request->input('shot_desc');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->user_id = auth()->user()->id;
        $product->image = $image_name;
        $product->in_stock = $request->input('in_stock')==='on' ? true: false;
        $product->public = $request->input('public')==='on' ? true: false;
        $product->created_at = time();
        $product->updated_at = time();

        $product->save();
        return redirect(route('products'))->with(['success' => 'Товар успешно добавлен']);
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
        $product = Product::find($id);
        $data = [
            'product' => $product,
            'user' => User::find($product->user_id)
        ];
        return view('products.showproduct')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if(Auth::guest() || (Auth::user()->role !== "admin"))
            return redirect(route('products'))->with('error', 'you are not authorized');

        $product = Product::find($id);

        $categories = Category::getlistnavbar();
        $data = [
            'title' => 'редактирование товара',
            'product' => $product,
            'categories' => $categories,
            'message' => ''
        ];

        return view('products.edit')->with($data);
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
        $this->validate($request, [
            'title' => 'required|max:190|min:5',
            'shot_desc' => 'required|max:190|min:5',
            'description' => 'required|max:1024|min:10',
            'price' => 'required|max:6|min:1',
            'image' => 'nullable|image|max:1999'
        ]);
        if($request->hasFile('image') == true) {
            $file = $request->file('image')->getClientOriginalName();
            $image_name_without_ext = pathinfo($file, PATHINFO_FILENAME);
            $ext = $request->file('image')->getClientOriginalExtension();
            $image_name = str_slug($request->input('title'))."_".str_slug($image_name_without_ext)."_".time().".".$ext;
            $path = $request->file('image')->storeAs('public/images/products/', $image_name);
        }

        $product = Product::find($id);;
        $product->title = $request->input('title');
        $product->category_id = explode(' - ',$request->input('category'))[0];
        $product->shot_desc = $request->input('shot_desc');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->user_id = auth()->user()->id;
        if($request->hasFile('image')) {
            if($product->image!='no_image.jpg')
                Storage::delete('public/images/products/'.$product->image);
            $product->image = $image_name;
        }
        $product->in_stock = $request->input('in_stock')==='on' ? true: false;
        $product->public = $request->input('public')==='on' ? true: false;
        $product->updated_at = time();

        $product->save();
        return redirect(route('products.show', ['product'=>$id]))->with(['success' => 'Товар успешно изменен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(Auth::guest() || (Auth::user()->role !== "admin"))
            return redirect(route('products'))->with('error', 'you are not authorized');

//        if($product->image!='no_image.jpg')
//            Storage::delete('public/images/products/'.$product->image);
//        $product->delete();
        $product->public = false;
        $product->save();

        return redirect(route('products'))->with(['success' => 'product "'. $product->title.'" was deleted']);
    }
}
