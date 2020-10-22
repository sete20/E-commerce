<?php

namespace App\Http\Controllers\Admin\Category;
use App\model\admin\category;
use App\model\admin\subcategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function subcategory(){
        $category = category::all();
        $subcategory = subcategory::
                    join('categories','sub_categories.category_id','categories.id')
                    ->select('sub_categories.*','categories.category_name')
                    ->get();
        return view('admin.category.subcategory',compact('category','subcategory'));
    }
    public function storeSubcategory(request $request){

        $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required'
        ]);
        subcategory::create($request->all());
        $notification=array(
            'messege'=>'Sub Category Inserted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);
    }
    public function editSubcategory($id){
        $subcat = subcategory::where('id',$id)->first();
        $category =category::get();
        return view('admin.category.edit_subcat',compact('subcat','category'));

    }
    public function updateSubcategory(request $request,$id){
        $data= [];
        $data['category_id'] = $request->category_id;
        $data['subcategory_name'] = $request->subcategory_name;
        subcategory::where('id',$id)->update($data);
        $notification=array(
            'messege'=>'Sub Category Updated Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->route('sub.categories')->with($notification);

    }
    public function deleteSubcategory($id){
        subcategory::where('id',$id)->delete();

        $notification=array(
            'messege'=>'Sub Category Deleted Successfully',
            'alert-type'=>'success'
             );
             return Redirect()->back()->with($notification);
    }
}
