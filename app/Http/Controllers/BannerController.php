<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Banner;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class BannerController extends Controller
{
    public function AuthLogin()
    {
        // $admin_id = Session::get('admin_id');
        $admin_id = Auth::id();

        if($admin_id)
        {
            return Redirect::to('dashboard');
        }
        else
        {
            return Redirect::to('admin')->send();
        }
    }

    public function manage_banner()
    {
        $all_banner = Banner::orderBy('banner_id', 'desc')->get();
        return view('admin.banner.list_banner')->with(compact('all_banner'));
    }

    public function add_banner()
    {
        return view('admin.banner.add_banner');
    }

    public function save_banner(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        

        $get_image = $request->file('banner_image');
        if($get_image)
        {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/banner', $new_image);
           
            $banner = new Banner();
            $banner->banner_name = $data['banner_name'];
            $banner->banner_image = $new_image;
            $banner->banner_desc = $data['banner_desc'];
            $banner->banner_status = $data['banner_status'];
            $banner->save();

            Session::put('message', 'Thêm banner thành công');
            return redirect()->back();
        }
        else
        {
            Session::put('message', 'Làm ơn thêm hình ảnh');
            return redirect()->back();
        }
    }

    public function unactive_banner($banner_id)
    {
        $this->AuthLogin();
        $banner = Banner::where('banner_id', $banner_id)->update(['banner_status'=>0]);
        Session::put('message', 'Không kích hoạt banner');
        return redirect()->back();
    }
    public function active_banner($banner_id)
    {
        $this->AuthLogin();
        $banner = Banner::where('banner_id', $banner_id)->update(['banner_status'=>1]);
        Session::put('message', 'Kích hoạt banner');
        return redirect()->back();
    }
}
