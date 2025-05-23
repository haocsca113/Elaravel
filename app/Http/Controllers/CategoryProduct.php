<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryPost;
use App\Imports\ExcelImport;
use App\Exports\ExcelExport;
use Excel;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
session_start();

class CategoryProduct extends Controller
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

    public function arrange_category(Request $request)
    {
        $this->AuthLogin();
        $data =$request->all();
        $cate_id = $data['page_id_array'];
        foreach($cate_id as $key => $value)
        {
            $category = Category::find($value);
            $category->category_order = $key;
            $category->save();
        }
        echo 'Updated';
    }

    public function add_category_product()
    {
        $this->AuthLogin();
        return view('admin.add_category_product');
    }

    public function all_category_product()
    {
        $this->AuthLogin();
        $all_category_product = DB::table('tbl_category_product')->orderBy('category_order', 'ASC')->get();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }

    public function save_category_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['category_status'] = $request->category_product_status;
        $data['meta_keywords'] = $request->category_product_keywords;

        DB::table('tbl_category_product')->insert($data);
        Session::put('message', 'Thêm danh mục sản phẩm thành công');
        return Redirect::to('/add-category-product');
    }

    public function unactive_category_product($category_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status'=>0]);
        Session::put('message', 'Không kích hoạt danh mục sản phẩm');
        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status'=>1]);
        Session::put('message', 'Kích hoạt danh mục sản phẩm');
        return Redirect::to('all-category-product');
    }

    public function edit_category_product($category_product_id)
    {
        $this->AuthLogin();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id', $category_product_id)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }

    public function update_category_product(Request $request, $category_product_id)
    {
        $this->AuthLogin();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_desc'] = $request->category_product_desc;
        $data['meta_keywords'] = $request->category_product_keywords;

        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update($data);
        Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function delete_category_product($category_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
        Session::put('message', 'Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function import_csv(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new ExcelImport, $path);
        return back();
    }

    public function export_csv()
    {
        return Excel::download(new ExcelExport, 'category_product.xlsx');
    }
    // End Function Admin Page

    public function show_category_home(Request $request, $category_id)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        // $category_by_id = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')->where('tbl_product.category_id', $category_id)->get();

        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        $min_price_range = $min_price + 100000;
        $max_price_range = $max_price + 1000000;

        if(isset($_GET['sort_by']))
        {
            $sort_by = $_GET['sort_by'];
            if($sort_by == 'giam_dan')
            {
                $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_price', 'DESC')->paginate(6)->appends(request()->query());
            }
            else if($sort_by == 'tang_dan')
            {
                $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_price', 'ASC')->paginate(6)->appends(request()->query());
            }
            else if($sort_by == 'kytu_za')
            {
                $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_name', 'DESC')->paginate(6)->appends(request()->query());
            }
            else if($sort_by == 'kytu_az')
            {
                $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_name', 'ASC')->paginate(6)->appends(request()->query());
            }
        }
        else if(isset($_GET['start_price']) && $_GET['end_price'])
        {
            $min_price = $_GET['start_price'];
            $max_price = $_GET['end_price'];
            $category_by_id = Product::with('category')->whereBetween('product_price', [$min_price, $max_price])->where('category_id', $category_id)->orderBy('product_id', 'ASC')->paginate(6)->appends(request()->query());
        }
        else
        {
            $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_id', 'DESC')->paginate(6);
        }
        
        $meta_desc = 'Danh mục sản phẩm';
        $meta_keywords = 'Danh mục sản phẩm';
        $meta_title = 'Danh mục sản phẩm';
        $url_canonical = $request->url();
        foreach($category_by_id as $key => $val)
        {
            // Seo
            $meta_desc = $val->category_desc;
            $meta_keywords = $val->meta_keywords;
            $meta_title = $val->category_name;
            $url_canonical = $request->url();
        }

        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id', $category_id)->limit(1)->get();

        return view('pages.category.show_category')->with('category', $cate_product)->with('brand', $brand_product)->with('category_by_id', $category_by_id)->with('category_name', $category_name)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('banner', $banner)->with('cate_post', $cate_post)->with('min_price', $min_price)->with('max_price', $max_price)->with('min_price_range', $min_price_range)->with('max_price_range', $max_price_range);
    }
}
