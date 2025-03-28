<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\CategoryPost;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

session_start();

class BrandProduct extends Controller
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

    public function add_brand_product()
    {
        $this->AuthLogin();
        return view('admin.add_brand_product');
    }

    public function all_brand_product()
    {
        $this->AuthLogin();
        // $all_brand_product = DB::table('tbl_brand_product')->get(); // static huong doi tuong
        // $all_brand_product = Brand::all();
        $all_brand_product = Brand::orderBy('brand_id', 'desc')->get();
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product', $all_brand_product);
        return view('admin_layout')->with('admin.all_brand_product', $manager_brand_product);
    }

    public function save_brand_product(Request $request)
    {
        $this->AuthLogin();

        $data = $request->all();
        $brand = new Brand();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->save();

        Session::put('message', 'Thêm thương hiệu sản phẩm thành công');
        return Redirect::to('/add-brand-product');
    }

    public function unactive_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_brand_product')->where('brand_id', $brand_product_id)->update(['brand_status'=>0]);
        Session::put('message', 'Không kích hoạt thương hiệu sản phẩm');
        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_brand_product')->where('brand_id', $brand_product_id)->update(['brand_status'=>1]);
        Session::put('message', 'Kích hoạt thương hiệu sản phẩm');
        return Redirect::to('all-brand-product');
    }

    public function edit_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        // $edit_brand_product = DB::table('tbl_brand_product')->where('brand_id', $brand_product_id)->get();
        // $edit_brand_product = Brand::find($brand_product_id);
        $edit_brand_product = Brand::where('brand_id', $brand_product_id)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product', $edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product', $manager_brand_product);
    }

    public function update_brand_product(Request $request, $brand_product_id)
    {
        $this->AuthLogin();
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // DB::table('tbl_brand_product')->where('brand_id', $brand_product_id)->update($data);

        $data = $request->all();
        $brand = Brand::find($brand_product_id);
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->save();

        Session::put('message', 'Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function delete_brand_product($brand_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_brand_product')->where('brand_id', $brand_product_id)->delete();
        Session::put('message', 'Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    // End Function Admin Page

    public function show_brand_home(Request $request, $brand_id)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Thương hiệu sản phẩm';
        $meta_keywords = 'Thương hiệu sản phẩm';
        $meta_title = 'Thương hiệu sản phẩm';
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $brand_by_id = DB::table('tbl_product')->join('tbl_brand_product', 'tbl_product.brand_id', '=', 'tbl_brand_product.brand_id')->where('tbl_product.brand_id', $brand_id)->get();

        $brand_name = DB::table('tbl_brand_product')->where('tbl_brand_product.brand_id', $brand_id)->limit(1)->get();

        return view('pages.brand.show_brand')->with('category', $cate_product)->with('brand', $brand_product)->with('brand_by_id', $brand_by_id)->with('brand_name', $brand_name)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('banner', $banner)->with('cate_post', $cate_post);
    }
}
