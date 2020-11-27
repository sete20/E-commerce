<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function UserRole()
    {
        $user = DB::table('admins')->where('type', 2)->get();
        return view('admin.role.all_role', compact('user'));
    }


    public function UserCreate()
    {

        return view('admin.role.create_role');
    }
    public function UserStore(Request $request)
    {

        $data = $request->except('_token');
        $data['type'] = 2;

        DB::table('admins')->insert($data);
        $notification = array(
            'messege' => 'Child Admin Inserted Successfully',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function UserEdit($id)
    {

        $user = DB::table('admins')->where('id', $id)->first();
        return view('admin.role.edit_role', compact('user'));
    }
    public function UserUpdate(Request $request)
    {

        $id = $request->id;

        $data = $request->except('_token');



        DB::table('admins')->where('id', $id)->update($data);
        $notification = array(
            'messege' => 'Child Admin Updated Successfully',
            'alert-type' => 'success'
        );
        return Redirect()->route('admin.all.user')->with($notification);
    }
    public function ProductStock()
    {

        $product = DB::table('products')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->select('products.*', 'categories.category_name', 'brands.brand_name')
            ->get();
        // return response()->json($product);
        return view('admin.stock.stock', compact('product'));
    }
}
