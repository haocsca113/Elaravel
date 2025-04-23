<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;    
use App\Models\CategoryPost;    
use App\Models\Post;    
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
session_start();

class PostController extends Controller
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

    public function add_post()
    {
        $this->AuthLogin();
        $cate_post = CategoryPost::orderBy('cate_post_id', 'DESC')->get();

        return view('admin.post.add_post')->with(compact('cate_post'));
    }

    public function all_post()
    {
        $this->AuthLogin();

        // $all_post = Post::with('cate_post')->orderBy('post_id', 'DESC')->paginate(10);
        $all_post = Post::with('cate_post')->orderBy('post_id', 'DESC')->get();

        return view('admin.post.all_post')->with(compact('all_post'));
    }

    public function save_post(Request $request)
    {
        $this->AuthLogin();
        
        $validatedData = $request->validate([
            'post_title' => 'required|min:5',
            'post_slug' => 'required',
            'post_desc' => 'required|min:5',
            'post_content' => 'required|min:5',
            'post_meta_desc' => 'required|min:5',
            'post_meta_keywords' => 'required|min:5',
            'cate_post_id' => 'required', 
            'post_image' => 'required', 
            'post_status' => 'required', 
        ]);

        $data = $request->all();
        $post = new Post();
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->cate_post_id = $data['cate_post_id'];
        $post->post_status = $data['post_status'];

        $get_image = $request->file('post_image');
        if($get_image)
        {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/post', $new_image);
            
            $post->post_image = $new_image;
            $post->save();
            return redirect()->to('/all-post')->with('message', 'Thêm bài viết thành công');
        }
    }

    public function unactive_post($post_id)
    {
        $this->AuthLogin();
        Post::where('post_id', $post_id)->update(['post_status'=>0]);
        return redirect()->back()->with('message', 'Không kích hoạt bài viết');
    }

    public function active_post($post_id)
    {
        $this->AuthLogin();
        Post::where('post_id', $post_id)->update(['post_status'=>1]);
        return redirect()->back()->with('message', 'Kích hoạt bài viết');
    }

    public function edit_post($post_id)
    {
        $this->AuthLogin();
        
        $edit_post = Post::find($post_id);
        $cate_post = CategoryPost::orderBy('cate_post_id', 'DESC')->get();
        
        return view('admin.post.edit_post')->with(compact('edit_post', 'cate_post'));
    }

    public function update_post(Request $request, $post_id)
    {
        $this->AuthLogin();
        $data = $request->all();
        $post = Post::find($post_id);

        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_meta_keywords = $data['post_meta_keywords'];
        $post->cate_post_id = $data['cate_post_id'];
        $post->post_status = $data['post_status'];

        $get_image = $request->file('post_image');
        if($get_image)
        {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); // tách dấu . ra khỏi tên
            $new_image = $name_image.rand(0, 99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/post', $new_image);

            $post->post_image = $new_image;
        }
        $post->save();
        return redirect()->to('/all-post')->with('message', 'Cập nhật bài viết thành công');
    }

    public function delete_post($post_id)
    {
        $this->AuthLogin();

        Post::where('post_id', $post_id)->delete();

        return redirect()->back()->with('message', 'Xóa bài viết thành công');
    }
    // End Admin Page

    public function bai_viet(Request $request, $post_slug)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        $post = Post::with('cate_post')->where('post_status', 1)->where('post_slug', $post_slug)->first();

        // SEO
        $meta_desc = $post->post_meta_desc;
        $meta_keywords = $post->post_meta_keywords;
        $meta_title = $post->post_title;
        $url_canonical = $request->url();
        $cate_post_id = $post->cate_post_id;

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $related = Post::with('cate_post')->where('post_status', 1)->where('cate_post_id', $cate_post_id)->whereNotIn('post_slug', [$post_slug])->take(5)->get();

        return view('pages.baiviet.baiviet')->with(compact('category', 'brand', 'banner', 'cate_post', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'post', 'related'));
    }
}
