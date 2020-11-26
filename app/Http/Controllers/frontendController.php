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
        $notification = array(
            'messege' => 'Thanks for Subscribing',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
    public function OrderTracking(Request $request)
    {
        $code = $request->code;

        $track = DB::table('orders')->where('status_code', $code)->first();
        if ($track) {

            // echo "<pre>";
            // print_r($track);
            return view('pages.tracking', compact('track'));
        }
        $notification = array(
            'messege' => 'Status Code Invalid',
            'alert-type' => 'error'
        );
        return Redirect()->back()->with($notification);
    }
}
