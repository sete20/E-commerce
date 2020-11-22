<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\productsRequest;
use App\model\admin\brand;
use App\model\admin\category;
use App\model\admin\subCategory;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {

        $product = DB::table('products')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->select('products.*', 'categories.category_name', 'brands.brand_name')
            ->get();
        return view('admin.product.index', compact('product'));
    }


    public function create()
    {
        $category = category::all();
        $brand = brand::all();

        return view('admin.product.create', compact('category', 'brand'));
    }


    public function GetSubcat($category_id)
    {
        $cat = subCategory::where('category_id', $category_id)->get();
        return json_encode($cat);
    }


    public function store(Request $request)
    {
        $data = [];

        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['product_quantity'] = $request->product_quantity;
        $data['discount_price'] = $request->discount_price;
        $data['category_id'] = $request->category_id;
        $data['subcategory_id'] = $request->subcategory_id;
        $data['brand_id'] = $request->brand_id;
        $data['product_size'] = $request->product_size;
        $data['product_color'] = $request->product_color;
        $data['selling_price'] = $request->selling_price;
        $data['product_details'] = $request->product_details;
        $data['video_link'] = $request->video_link;
        $data['main_slider'] = $request->main_slider;
        $data['hot_deal'] = $request->hot_deal;
        $data['best_rated'] = $request->best_rated;
        $data['trend'] = $request->trend;
        $data['mid_slider'] = $request->mid_slider;
        $data['hot_new'] = $request->hot_new;
        $data['buyone_getone'] = $request->buyone_getone;
        $data['status'] = 1;

        $image_one = $request->image_one;
        $image_two = $request->image_two;
        $image_three = $request->image_three;
        // dd([$image_one,$image_two,$image_three]);
        if ($image_one && $image_two && $image_three) {
            $image_one_name = hexdec(uniqid()) . '.' . $image_one->getClientOriginalExtension();
            $location = public_path('media/product/' . $image_one_name);
            Image::make($image_one)->resize(300, 300)->save($location);
            $data['image_one'] = 'media/product/' . $image_one_name;

            $image_two_name = hexdec(uniqid()) . '.' . $image_two->getClientOriginalExtension();
            $location = public_path('media/product/' .  $image_two_name);
            Image::make($image_two)->resize(300, 300)->save($location);
            $data['image_two'] = 'media/product/' . $image_two_name;


            $image_three_name = hexdec(uniqid()) . '.' . $image_three->getClientOriginalExtension();
            $location = public_path('media/product/' . $image_three_name);
            Image::make($image_three)->resize(300, 300)->save($location);
            $data['image_three'] = 'media/product/' . $image_three_name;
            $product = DB::table('products')->insert($data);
            $notification = array(
                'messege' => 'Product Inserted Successfully',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        }
    }


    public function inactive($id)
    {
        DB::table('products')->where('id', $id)->update(['status' => 0]);
        $notification = array(
            'messege' => 'Product Successfully inactive',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }


    public function active($id)
    {
        DB::table('products')->where('id', $id)->update(['status' => 1]);
        $notification = array(
            'messege' => 'Product Successfully Activated',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }



    public function DeleteProduct($id, request $request)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $image_one = $product->image_one;
        $image_two = $product->image_two;
        $image_three = $product->image_three;
        if ($request->hasFile([$image_one, $image_two, $image_two])) {
            // dd($request->all());
            unlink($image_one);
            unlink($image_two);
            unlink($image_three);
        }

        DB::table('products')->where('id', $id)->delete();

        $notification = array(
            'messege' => 'Product Successfully Deleted',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }


    public function ViewProduct($id)
    {
        $product = DB::table('products')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('sub_categories', 'products.subcategory_id', 'sub_categories.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->select('products.*', 'categories.category_name', 'sub_categories.subcategory_name', 'brands.brand_name')
            ->where('products.id', $id)
            ->first();
        return view('admin.product.show', compact('product'));
    }


    public function EditProduct($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        return view('admin.product.edit', compact('product'));
    }


    public function UpdateProductWithoutPhoto(Request $request, $id)
    {
        $data = [];
        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['product_quantity'] = $request->product_quantity;
        $data['discount_price'] = $request->discount_price;
        $data['category_id'] = $request->category_id;
        $data['subcategory_id'] = $request->subcategory_id;
        $data['brand_id'] = $request->brand_id;
        $data['product_size'] = $request->product_size;
        $data['product_color'] = $request->product_color;
        $data['selling_price'] = $request->selling_price;
        $data['product_details'] = $request->product_details;
        $data['video_link'] = $request->video_link;
        $data['main_slider'] = $request->main_slider;
        $data['hot_deal'] = $request->hot_deal;
        $data['best_rated'] = $request->best_rated;
        $data['trend'] = $request->trend;
        $data['mid_slider'] = $request->mid_slider;
        $data['hot_new'] = $request->hot_new;
        $data['buyone_getone'] = $request->buyone_getone;
        $data['status'] = 1;

        $product_update = DB::table('products')->where('id', $id)->update($data);
        if ($product_update) {
            $notification = array(
                'messege' => 'Product updated Successfully',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.product')->with($notification);
        }
        $notification = array(
            'messege' => 'Nothing TO Update',
            'alert-type' => 'success'
        );
        return Redirect()->route('all.product')->with($notification);
    }


    public function UpdateProductPhoto(Request $request, $id)
    {

        $old_one = $request->old_one;
        $old_two = $request->old_two;
        $old_three = $request->old_three;

        $data = array();

        $image_one = $request->file('image_one');
        $image_two = $request->file('image_two');
        $image_three = $request->file('image_three');


        if ($image_one) {
            unlink($old_one);
            $image_name = date('dmy_H_s_i');
            $ext = strtolower($image_one->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'media/product/';
            $image_url = $upload_path . $image_full_name;
            $success = $image_one->move($upload_path, $image_full_name);

            $data['image_one'] = $image_url;
            $productimg = DB::table('products')->where('id', $id)->update($data);
            $notification = array(
                'messege' => 'Image One Updated Successfully',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.product')->with($notification);
        }
        if ($image_two) {
            unlink($old_two);
            $image_name = date('dmy_H_s_i');
            $ext = strtolower($image_two->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'media/product/';
            $image_url = $upload_path . $image_full_name;
            $success = $image_two->move($upload_path, $image_full_name);

            $data['image_two'] = $image_url;
            $productimg = DB::table('products')->where('id', $id)->update($data);
            $notification = array(
                'messege' => 'Image Two Updated Successfully',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.product')->with($notification);
        }
        if ($image_three) {
            unlink($old_three);
            $image_name = date('dmy_H_s_i');
            $ext = strtolower($image_three->getClientOriginalExtension());
            $image_full_name = $image_name . '.' . $ext;
            $upload_path = 'media/product/';
            $image_url = $upload_path . $image_full_name;
            $success = $image_three->move($upload_path, $image_full_name);

            $data['image_three'] = $image_url;
            $productimg = DB::table('products')->where('id', $id)->update($data);
            $notification = array(
                'messege' => 'Image Three Updated Successfully',
                'alert-type' => 'success'
            );
            return Redirect()->route('all.product')->with($notification);
        }
    }
}
