<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Category;    
use App\Models\CategoryPost;   
use App\Models\Post;   
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

        return redirect()->to('/all-category-post')->with('message', 'Thêm danh mục bài viết thành công');
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

    public function edit_category_post($cate_post_id)
    {
        $this->AuthLogin();

        $cate_post = CategoryPost::find($cate_post_id);

        return view('admin.category_post.edit_category_post')->with(compact('cate_post'));
    }

    public function update_category_post(Request $request, $cate_post_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $cate_post = CategoryPost::find($cate_post_id);

        $cate_post->cate_post_name = $data['cate_post_name'];
        $cate_post->cate_post_slug = $data['cate_post_slug'];
        $cate_post->cate_post_desc = $data['cate_post_desc'];
        $cate_post->cate_post_status = $data['cate_post_status'];
        $cate_post->save();

        return redirect()->to('/all-category-post')->with('message', 'Cập nhật danh mục bài viết thành công');
    }

    public function delete_category_post($cate_post_id)
    {
        $this->AuthLogin();
        
        CategoryPost::where('cate_post_id', $cate_post_id)->delete();
         
        return redirect()->back()->with('message', 'Xóa danh mục bài viết thành công');
    }
    // End Admin Page

    public function danh_muc_bai_viet(Request $request, $cate_post_slug)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        $cate_post_seo = CategoryPost::where('cate_post_status', '1')->where('cate_post_slug', $cate_post_slug)->first();

        // SEO
        $meta_desc = $cate_post_seo->cate_post_desc;
        $meta_keywords = $cate_post_seo->cate_post_slug;
        $meta_title = $cate_post_seo->cate_post_name;
        $url_canonical = $request->url();
        $cate_post_id = $cate_post_seo->cate_post_id;

        $post = Post::with('cate_post')->where('post_status', 1)->where('cate_post_id', $cate_post_id)->paginate(10);

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();
        
        return view('pages.baiviet.danhmucbaiviet')->with(compact('category', 'brand', 'banner', 'cate_post', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'post'));
    }
}
