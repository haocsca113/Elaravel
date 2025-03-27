<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;    
use App\Models\CategoryPost;    
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
session_start();

class CategoryPostController extends Controller
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

    public function add_category_post()
    {
        $this->AuthLogin();
        return view('admin.category_post.add_category_post');
    }

    public function all_category_post()
    {
        $this->AuthLogin();
        $all_cate_post = CategoryPost::orderBy('cate_post_id', 'DESC')->paginate(5);
 
        return view('admin.category_post.all_category_post')->with(compact('all_cate_post'));
    }

    public function save_category_post(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $cate_post = new CategoryPost();
        $cate_post->cate_post_name = $data['cate_post_name'];
        $cate_post->cate_post_slug = $data['cate_post_slug'];
        $cate_post->cate_post_desc = $data['cate_post_desc'];
        $cate_post->cate_post_status = $data['cate_post_status'];
        $cate_post->save();

        return redirect()->back()->with('message', 'Thêm danh mục bài viết thành công');
    }

    public function unactive_cate_post($cate_post_id)
    {
        $this->AuthLogin();
        CategoryPost::where('cate_post_id', $cate_post_id)->update(['cate_post_status'=>0]);

        return redirect()->back()->with('message', 'Không kích hoạt danh mục bài viết');
    }

    public function active_cate_post($cate_post_id)
    {
        $this->AuthLogin();
        CategoryPost::where('cate_post_id', $cate_post_id)->update(['cate_post_status'=>1]);

        return redirect()->back()->with('message', 'Kích hoạt danh mục bài viết');

    }

    // public function edit_category_product($category_product_id)
    // {
    //     $this->AuthLogin();
    //     $edit_category_product = DB::table('tbl_category_product')->where('category_id', $category_product_id)->get();
    //     $manager_category_product = view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
    //     return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    // }

    // public function update_category_product(Request $request, $category_product_id)
    // {
    //     $this->AuthLogin();
    //     $data = array();
    //     $data['category_name'] = $request->category_product_name;
    //     $data['category_desc'] = $request->category_product_desc;
    //     $data['meta_keywords'] = $request->category_product_keywords;

    //     DB::table('tbl_category_product')->where('category_id', $category_product_id)->update($data);
    //     Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
    //     return Redirect::to('all-category-product');
    // }

    // public function delete_category_product($category_product_id)
    // {
    //     $this->AuthLogin();
    //     DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
    //     Session::put('message', 'Xóa danh mục sản phẩm thành công');
    //     return Redirect::to('all-category-product');
    // }

    // End Admin Page

    public function danh_muc_bai_viet($cate_post_slug)
    {

    }
}
