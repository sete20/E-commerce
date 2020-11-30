<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function SiteSetting()
    {

        $setting = DB::table('site_settings')->first();
        return view('admin.setting.site_setting', compact('setting'));
    }
    public function UpdateSiteSetting(Request $request)
    {
        $data = $request->except("_token");
        DB::table('site_settings')->where('id', $request->id)->update($data);
        $notification = array(
            'messege' => 'Site Setting Updated Successfully',
            'alert-type' => 'success'
        );
        return Redirect()->back()->with($notification);
    }
}
