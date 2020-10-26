<?php

namespace App\Http\Controllers;

use App\Http\Requests\newslettersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class frontendController extends Controller
{
    public function  newsletters(newslettersRequest $request)
    {
        $request->validated();
        $data = array();
        $data['email'] = $request->email;
        DB::table('newsletters')->insert($data);
        $notification=array(
            'messege'=>'Thanks for Subscribing',
            'alert-type'=>'success'
             );
             return Redirect()->back()->with($notification);

    }
}
