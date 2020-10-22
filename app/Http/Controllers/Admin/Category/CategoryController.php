<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\admin\category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function category(){
        $category = category::all();
        return view('admin.category.category',compact('category'));

    }
    public function storeCategory(request $request){
        $request->validate([
            'category_name' => 'required|unique:categories,subcategory_name||max:255',
        ]);
            category::create($request->all());
            $notification=array(
                'messege'=>'Category Added Successfully',
                'alert-type'=>'success'
                 );
               return Redirect()->back()->with($notification);

    }
    public function deleteCategory($id){
        DB::table('categories')->where('id',$id)->delete();
         $notification=array(
              'messege'=>'Category Deleted Successfully',
              'alert-type'=>'success'
               );
             return Redirect()->back()->with($notification);
    }
    public function editCategory($id){
            $category = DB::table('categories')->where('id',$id)->first();
            return view('admin.category.edit_category',compact('category'));
    }



    public function updateCategory(request $request,$id){
        $request->validate([
            'category_name' => 'required|max:255',
             ]);
             $data=array();
             $data['category_name']=$request->category_name;
             $update=DB::table('categories')->where('id',$id)
             ->where('category_name','!=',old('category_name'))
             ->update($data);
             if ($update) {
                $notification=array(
                    'messege'=>'Category Updated Successfully',
                    'alert-type'=>'success'
                     );
                   return Redirect()->route('categories')->with($notification);
           }else{
               $notification=array(
                    'messege'=>'Nothing To Update',
                    'alert-type'=>'error'
                     );
                   return Redirect()->route('categories')->with($notification);
           }
    }
}
