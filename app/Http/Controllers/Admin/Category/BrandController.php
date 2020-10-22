<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\admin\brand;

use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function brand(){

 	$brand = brand::all();
  	return view('admin.category.brand',compact('brand'));

    }

    public function storeBrand(request $request){
        $data = $request->validate([
            'brand_name' => 'required|unique:brands|max:55',
            'brand_logo' =>'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);
        if($data['brand_logo']){
            $imageName = date('dmy_h_s_i');
            $ext = strtolower($data['brand_logo']->getClientOriginalExtension());
            $image_full_name = $imageName.'.'.$ext;
            $upload_path = 'public/media/brand/';
            $image_url = $upload_path.$image_full_name;
            $success =$data['brand_logo']->move($upload_path,$image_full_name);

            $data['brand_logo'] = $image_url;
            $brand = brand::create($data);

 	   $notification=array(
            'messege'=>'Brand Inserted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);
 	}else{
        $brand = brand::create($data);
 		 $notification=array(
            'messege'=>'Its Done',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);
 	}

 }

    public function deleteBrand($id){
        $data = brand::where('id',$id)->first();
        $image = $data->brand_logo;
        unlink($image);
        $brand = brand::where('id',$id)->delete();
        $notification=array(
                 'messege'=>'Brand Deleted Successfully',
                 'alert-type'=>'success'
                  );
                return Redirect()->back()->with($notification);
       }



    public function editBrand($id){
        $brand = DB::table('brands')->where('id',$id)->first();
        return view('admin.category.edit_brand',compact('brand'));

    }

    public function updateBrand(Request $request, $id){
        $old_logo = $request->old_logo;
        $data= [];
        $data['brand_name'] = $request->brand_name;
        $image = $request->file('brand_logo');
 	if ($image) {
 		unlink($old_logo);
 	  $image_name = date('dmy_H_s_i');
 	  $ext = strtolower($image->getClientOriginalExtension());
 	  $image_full_name = $image_name.'.'.$ext;
 	  $upload_path = 'public/media/brand/';
 	  $image_url = $upload_path.$image_full_name;
 	  $success = $image->move($upload_path,$image_full_name);

 	  $data['brand_logo'] = $image_url;
 	  $brand = DB::table('brands')->where('id',$id)->update($data);
 	   $notification=array(
            'messege'=>'Brand Updated Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->route('brands')->with($notification);
 	}else{
 		 $brand = DB::table('brands')->where('id',$id)->update($data);
 		 $notification=array(
            'messege'=>'Update Without Images',
            'alert-type'=>'success'
             );
           return Redirect()->route('brands')->with($notification);
 	}

  }

}
