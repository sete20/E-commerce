<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Cart;
use Response;
use Auth;
use Session;

class cartController extends Controller
{
    public function addToCart($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $data = [];
        if ($product->discount_price == null) {
            $data['id'] = $product->id;
            $data['name'] = $product->product_name;
            $data['qty'] = 1;
            $data['price'] = $product->selling_price;
            $data['weight'] = 1;
            $data['options']['image'] = $product->image_one;
            $data['options']['color'] = '';
            $data['options']['size'] = '';
            Cart::add($data);
            return Response::json(['success' => 'Successfully Added on your Cart']);            // dd($data);
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
        return Response::json(['success' => 'Successfully Added on your Cart']);
    }
    public function check()
    {
        $content = Cart::content();
        return response()->json($content);
    }
    public function ShowCart()
    {
        $cart = Cart::content();
        return view('pages.cart', compact('cart'));
    }
    public function removeItem($rowId)
    {
        Cart::remove($rowId);
        $notification = array(
            'messege' => 'Product Remove form Cart',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function updateItem(request $request)
    {
        $rowId = $request->productid;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        $notification = array(
            'messege' => 'Product updated successfully',
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

        return Response::json(array(
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size,
        ));
    }
    public function insertCart(Request $request)
    {
        $id = $request->product_id;
        $product = DB::table('products')->where('id', $id)->first();
        $color = $request->color;
        $size = $request->size;
        $qty = $request->qty;

        $data = array();

        if ($product->discount_price == NULL) {
            $data['id'] = $product->id;
            $data['name'] = $product->product_name;
            $data['qty'] = $request->qty;
            $data['price'] = $product->selling_price;
            $data['weight'] = 1;
            $data['options']['image'] = $product->image_one;
            $data['options']['color'] = $request->color;
            $data['options']['size'] = $request->size;
            Cart::add($data);
            $notification = array(
                'messege' => 'Product Added Successfully',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        } else {

            $data['id'] = $product->id;
            $data['name'] = $product->product_name;
            $data['qty'] = $request->qty;
            $data['price'] = $product->discount_price;
            $data['weight'] = 1;
            $data['options']['image'] = $product->image_one;
            $data['options']['color'] = $request->color;
            $data['options']['size'] = $request->size;
            Cart::add($data);
            $notification = array(
                'messege' => 'Product Added Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function checkout()
    {
        if (Auth::check()) {
            $cart = Cart::content();
            return view('pages.checkout', compact('cart'));
        }
        $notification = array(
            'messege' => 'Please login',
            'alert-type' => 'error'
        );
        return Redirect()->route('login')->with($notification);
    }
    public function Coupon(request $request)
    {
        $coupon = $request->coupon;
        $check = DB::table('coupons')->where('coupon', $coupon)->first();
        if ($check) {
            Session::put('coupon', [
                'name' => $check->coupon,
                'discount' => $check->discount,
                'balance' => Cart::Subtotal() - $check->discount,
            ]);

            $notification = array(
                'messege' => 'Successfully Coupon Applied',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($notification);
        }
        $notification = array(
            'messege' => 'Invalid Coupon',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }

    public function PaymentPage()
    {

        $cart = Cart::Content();
        return view('pages.payment', compact('cart'));
    }
    public function CouponRemove()
    {
        Session::forget('coupon');
        $notification = array(
            'messege' => 'Coupon remove Successfully',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function wishlist()
    {
        $userid = Auth::id();
        $product = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', 'products.id')
            ->select('products.*', 'wishlists.user_id')
            ->where('wishlists.user_id', $userid)
            ->get();
        // return response()->json($product);
        return view('pages.wishlist', compact('product'));
    }
}
