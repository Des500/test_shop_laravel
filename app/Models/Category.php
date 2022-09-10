<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public static function getlistnavbar () {
        $condition = [
            'public' => true,
        ];

        $categories = Self::where($condition)->orderBy('id','asc')->get();
        return $categories;
    }

    public function products () {
        return $this->hasMany('App\Models\Product');
    }

    public static function countProducts ($id) {
        $category = Category::find($id);
        $products = $category->products()->get();
        return count($products);
    }
}
