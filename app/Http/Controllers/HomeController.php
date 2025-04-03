<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Brand;
use App\Models\CategoryPost;
use Mail;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use OpenAI\Laravel\Facades\OpenAI;
// use GeminiAPI\Client;
// use GeminiAPI\Resources\Parts\TextPart;

// use Google\AI\GenerativeLanguage\Client;
// use Google\AI\GenerativeLanguage\TextPart;
session_start();

class HomeController extends Controller
{
    public function send_mail()
    {
        $to_name = "Poghao2";
        $to_email = "haocsca113@gmail.com";

        $data = array("name" => "Mail từ tài khoản khách hàng", "body" => 'Mail về vấn đề hàng hóa');
        Mail::send('pages.send_mail', $data, function($message) use($to_name, $to_email){
            $message->to($to_email)->subject('Test gửi mail google');
            $message->from($to_email, $to_name);
        });
        // return redirect::to('/')->with('message', '');
    }

    public function index(Request $request)
    {
        // Seo
        $meta_desc = "Chuyên bán tay cầm, phụ kiện game, gaming gear cho pc laptop điện thoại | Địa chỉ mua bán tay cầm, phụ kiện game, gaming gear cho pc laptop điện thoại rẻ ở TP.HCM";
        $meta_keywords = "tay cam, tay cầm chơi game, gaming gear cho pc laptop điện thoại";
        $meta_title = "Tay Cầm Chơi Game PC Điện Thoại | Mua Tay Cầm Xbox 360 One S PS4 Giá Rẻ Ở Đâu Tại TPHCM";
        $url_canonical = $request->url();

        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->where('banner_status', '1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        // ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        // ->orderby('tbl_product.product_id', 'desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '1')->orderby('product_id', 'desc')->limit(12)->get();

        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('banner', $banner)->with('cate_post', $cate_post);
    }

    public function search(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Tìm kiếm sản phẩm';
        $meta_keywords = 'Tìm kiếm sản phẩm';
        $meta_title = 'Tìm kiếm sản phẩm';
        $url_canonical = $request->url();

        $keywords = $request->keywords;
        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%'.$keywords.'%')->where('product_status', '1')->get();

        return view('pages.product.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('banner', $banner)->with('cate_post', $cate_post);
    }

    public function contact_us(Request $request)
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

        return view('pages.contact.contact_us')->with(compact('category', 'brand', 'banner', 'cate_post', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));
    }
}
