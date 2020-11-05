<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;
class WishlistController extends Controller
{
    public function add_to_wish_list($id,request $request){

        $user_id= auth::id();
        $check = DB::table('wishlists')->where('user_id',$user_id)->first();
        $data= ['user_id'=>$user_id,'product_id'=>$id];

        if (Auth::check()) {
            if ($check) {
                // dd($check);
                    DB::table('wishlists')->where('id',$check->id)->delete();
                    return Response::json(['error' =>'product deleted ']);
            }
            else{
                DB::table('wishlists')->insert($data);
                return Response::json(['success' =>'product Added successfully']);
            }
        }
        return Response::json(['error' =>'Please Login To Add It']);

    }

}
