<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\PostsRquest;
use Illuminate\Http\Request;
use DB;
use Image;
use File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

  public function BlogCatList(){
  $blogcat = DB::table('post_category')->get();
  return view('admin.blog.category.index',compact('blogcat'));

  }


  public function BlogCatStore(BlogRequest $request){
  $validateData = $request->validated();
  DB::table('post_category')->insert($validateData);
  $notification=array(
    'messege'=>'Blog Category Added Successfully',
    'alert-type'=>'success'
    );
    return Redirect()->back()->with($notification);
  }



 public function DeleteBlogCat($id){
 	DB::table('post_category')->where('id',$id)->delete();
 	$notification=array(
            'messege'=>'Blog Category Deleted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);

 }



   public function EditBlogCat($id){
   	$blogcatedit = DB::table('post_category')->where('id',$id)->first();
   	return view('admin.blog.category.edit',compact('blogcatedit'));

   }

  public function UpdateBlogCat(BlogRequest $request,$id){
    $validateData = $request->validated();
    DB::table('post_category')->where('id',$id)->update($validateData);
  $notification=array(
            'messege'=>'Blog Category Update Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->route('add.blog.categorylist')->with($notification);

 }


  public function Create(){

   $blogCategory = DB::table('post_category')->get();
   return view('admin.blog.create',compact('blogCategory'));

  }


  public function store(PostsRquest $request){
    $request->validate(['post_image'=>'nullable|image|mimes:jpg,png,jpeg']);
    $data = $request->validated();
    $post_image = $request->file('post_image');

  if ($post_image) {
     $post_image_name = hexdec(uniqid()).'.'.$post_image->getClientOriginalExtension();
     $location='media/post/'. $post_image_name;
     Image::make($post_image)->resize(400,200)->save($location);
     $data['post_image'] =$location;
     DB::table('posts')->insert($data);
     $notification=array(
            'messege'=>'Post Inserted Successfully',
            'alert-type'=>'success'
        );
    return Redirect()->back()->with($notification);
  }
  	$request->post_image='';
  	DB::table('posts')->insert($data);
     $notification=array(
            'messege'=>'Post Inserted Without Image',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);

  }



  public function index(){
     $post = DB::table('posts')
             ->join('post_category','posts.category_id','post_category.id')
             ->select('posts.*','post_category.category_name_en')
             ->get();
            return view('admin.blog.index',compact('post'));
            // return response()->json($post);

  }



  public function DeletePost($id){
  $post = DB::table('posts')->where('id',$id)->first();
  $image = $post->post_image;
  $location='public/media/post/'. $image;
  if (file_exists($location)) {
    unlink($image);
  }
  DB::table('posts')->where('id',$id)->delete();
   $notification=array(
            'messege'=>'Post Deleted Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification);

  }


  public function EditPost($id){
  	$post = DB::table('posts')->where('id',$id)->first();
  	return view('admin.blog.edit',compact('post'));

  }

 public function UpdatePost($id,PostsRquest $request){
    $oldimage = $request->old_image;

    $data = $request->validated();
      $post_image = $request->file('post_image');

    if ($post_image)
    {
      $location_1='public/media/post/'. $oldimage;

      if (file_exists($location_1)) {
            unlink($oldimage);
        }
        // dd($data);
      $post_image_name = hexdec(uniqid()).'.'.$post_image->getClientOriginalExtension();
      $location='media/post/'. $post_image_name;
      Image::make($post_image)->resize(400,200)->save($location);
      $data['post_image'] =$location;
         DB::table('posts')->where('id',$id)->update($data);
     $notification=array(
            'messege'=>'Post Updated Successfully',
            'alert-type'=>'success'
             );
           return Redirect()->route('all.blogpost')->with($notification);

  }else{
  	$data['post_image']= $oldimage;
  	 DB::table('posts')->where('id',$id)->update($data);
     $notification=array(
            'messege'=>'Post Updated Without Image',
            'alert-type'=>'success'
             );
            return Redirect()->route('all.blogpost')->with($notification);

       }
 }



}
