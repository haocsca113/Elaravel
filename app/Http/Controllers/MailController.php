<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Customer;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Brand;
use App\Models\CategoryPost;
use Mail;
use Session;
session_start();

class MailController extends Controller
{
    public function send_coupon($coupon_time, $coupon_condition, $coupon_number, $coupon_code)
    {
        $customer = Customer::where('customer_vip', '=' , NULL)->get();
        $coupon = Coupon::where('coupon_code', $coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        
        $title_mail = "Mã khuyến mãi ngày " . $now;

        $data = [];
        foreach($customer as $normal)
        {
            $data['email'][] = $normal->customer_email;
        }
        
        $coupon = array(
            'start_coupon' => $start_coupon,
            'end_coupon' => $end_coupon,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code,
        );

        Mail::send('pages.send_coupon', ['coupon' => $coupon], function($message) use($title_mail, $data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'], $title_mail);
        });

        return redirect()->back()->with('message', 'Gửi mã khuyến mãi khách thường thành công');
    }

    public function send_coupon_vip($coupon_time, $coupon_condition, $coupon_number, $coupon_code)
    {
        $customer_vip = Customer::where('customer_vip', 1)->get();
        $coupon = Coupon::where('coupon_code', $coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        
        $title_mail = "Mã khuyến mãi ngày " . $now;

        $data = [];
        foreach($customer_vip as $vip)
        {
            $data['email'][] = $vip->customer_email;
        }

        $coupon = array(
            'start_coupon' => $start_coupon,
            'end_coupon' => $end_coupon,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code,
        );
        
        Mail::send('pages.send_coupon_vip', ['coupon' => $coupon], function($message) use($title_mail, $data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'], $title_mail);
        });

        return redirect()->back()->with('message', 'Gửi mã khuyến mãi khách vip thành công');
    }

    public function recover_pass(Request $request)
    {
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Lấy lại mật khẩu Pogshop " . $now;
        $customer = Customer::where('customer_email', '=', $data['email_account'])->get();
        foreach($customer as $key => $value)
        {
            $customer_id = $value->customer_id;
        }

        if($customer)
        {
            $count_customer = $customer->count();
            if($count_customer == 0)
            {
                return redirect()->back()->with('error', 'Email chưa được đăng ký để khôi phục mật khẩu');
            }
            else
            {
                $token_random = Str::random();
                $customer = Customer::find($customer_id);
                $customer->customer_token = $token_random;
                $customer->save();

                // Send mail
                $to_email = $data['email_account'];
                $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$token_random);
                $data = array("name" => $title_mail, "body" => $link_reset_pass, 'email' => $data['email_account']);

                Mail::send('pages.checkout.forget_pass_notify', ['data' => $data], function($message) use($title_mail, $data){
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'], $title_mail);
                });

                return redirect()->back()->with('message', 'Gửi mail thành công, vui lòng vào mail để reset password'); 
            }
        }
    }

    public function reset_new_pass(Request $request)
    {
        $data = $request->all();
        $token_random = Str::random();
        $customer = Customer::where('customer_email', '=', $data['email'])->where('customer_token', '=', $data['token'])->get();
        $count = $customer->count();
        if($count > 0)
        {
            foreach($customer as $key => $cus)
            {
                $customer_id = $cus->customer_id;
            }
            $reset = Customer::find($customer_id);
            $reset->customer_password = md5($data['password_account']);
            $reset->customer_token = $token_random;
            $reset->save();
            return redirect()->to('login-checkout')->with('message', 'Mật khẩu mới đã cập nhật, vui lòng đăng nhập');
        }
        else
        {
            return redirect()->to('quen-mat-khau')->with('error', 'Vui lòng nhập lại email vì link đã quá hạn');
        }
    }

    public function update_new_pass(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Quên mật khẩu';
        $meta_keywords = 'Quên mật khẩu';
        $meta_title = 'Quên mật khẩu';
        $url_canonical = $request->url();

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        return view('pages.checkout.new_pass')->with(compact('category', 'brand', 'banner', 'cate_post', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));
    }

    public function mail_example()
    {
        return view('pages.send_coupon');
    }

    public function quen_mat_khau(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Quên mật khẩu';
        $meta_keywords = 'Quên mật khẩu';
        $meta_title = 'Quên mật khẩu';
        $url_canonical = $request->url();

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        return view('pages.checkout.forget_pass')->with(compact('category', 'brand', 'banner', 'cate_post', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical'));
    }
}
