<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Brand;
use App\Models\CategoryPost;
use App\Models\Contact;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class ContactController extends Controller
{
    public function AuthLogin()
    {
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

    public function lien_he(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Liên hệ';
        $meta_keywords = 'Liên hệ';
        $meta_title = 'Liên hệ';
        $url_canonical = $request->url();

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $contact = Contact::where('info_id', 2)->get();

        return view('pages.contact.lienhe')->with(compact('category', 'brand', 'banner', 'cate_post', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'contact'));
    }

    public function information()
    {
        $contact = Contact::where('info_id', 2)->get();
        return view('admin.information.add_information')->with(compact('contact'));
    }

    public function save_info(Request $request)
    {
        $data = $request->all();
        $contact = new Contact();
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fanpage = $data['info_fanpage'];

        $get_image = $request->file('info_logo');
        // $path = 'upload/contact';
        if($get_image)
        {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/contact', $new_image);
            $contact->info_logo = $new_image;
            $contact->save();
            return redirect()->back()->with('message', 'Thêm thông tin website thành công');
        }
    }

    public function update_info(Request $request, $info_id)
    {
        $data = $request->all();
        $contact = Contact::find($info_id);
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fanpage = $data['info_fanpage'];

        $get_image = $request->file('info_logo');
        if($get_image)
        {
            unlink('upload/contact/'.$contact->info_logo);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/contact', $new_image);
            $contact->info_logo = $new_image;
        }
        $contact->save();
        return redirect()->back()->with('message', 'Cập nhật thông tin website thành công');
    }
}
