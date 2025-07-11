<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductDetailsController extends Controller
{
    public function index($slug)
    {

        $query = Product::where('slug', $slug)->first();
        $categories = Category::where('id',$query->category_id)->first();
        $products = Product::where('category_id',$categories->id)->paginate(4);
    return view('landing.detail', compact('query','products'));
    }
}
