<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Image;
use request;
use Cart;

class ProductController extends Controller
{
    public function productView($id, $product_name)
    {
        $product = DB::table('products')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('sub_categories', 'products.subcategory_id', 'sub_categories.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->select('products.*', 'categories.category_name', 'sub_categories.subcategory_name', 'brands.brand_name')
            ->where('products.id', $id)
            ->first();

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        return view('pages.product_details', compact('product', 'product_color', 'product_size'));
    }
    public function addToCart($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $data = [];
        // $data = $product->all();

        if ($product->discount_price == null) {
            $data->except('discount_price');
            $data['name'] = $product->product_name;
            $data['qty'] = 1;
            $data['price'] = $product->selling_price;
            $data['weight'] = 1;
            $data['options']['image'] = $product->image_one;
            $data['options']['color'] = '';
            $data['options']['size'] = '';
            Cart::add($data);
            $notification = array(
                'messege' => 'Product Successfully Added',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        }

        $data['id'] = $product->id;
        $data['name'] = $product->product_name;
        $data['qty'] = 1;
        $data['price'] = $product->discount_price;
        $data['weight'] = 1;
        $data['options']['image'] = $product->image_one;
        $data['options']['color'] = '';
        $data['options']['size'] = '';
        Cart::add($data);
        $notification = array(
            'messege' => 'Product Successfully Added',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function viewProduct($id)
    {
        $product = DB::table('products')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('sub_categories', 'products.subcategory_id', 'sub_categories.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->select('products.*', 'categories.category_name', 'sub_categories.subcategory_name', 'brands.brand_name')
            ->where('products.id', $id)
            ->first();

        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        return response::json(array(
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size,
        ));
    }

    public function ProductsView($id)
    {

        $products = DB::table('products')->where('subcategory_id', $id)->paginate(5);

        $categorys = DB::table('categories')->get();

        $brands = DB::table('products')->where('subcategory_id', $id)->select('brand_id')->groupBy('brand_id')->get();

        return view('pages.all_products', compact('products', 'categorys', 'brands'));
    }
    public function allCategories($id)
    {
        $all_categories = DB::table('products')->where('category_id', $id)->paginate(5);
        return view('pages.all_categories', compact('all_categories'));
    }
}
