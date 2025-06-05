<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Social;
use Laravel\Socialite\Facades\Socialite;
use App\Rules\Captcha;
use Validator;
use DB;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Statistic;
use App\Models\Visitors;
use App\Models\Product;
use App\Models\Post;
use App\Models\Order;
use App\Models\Video;
use App\Models\Customer;
session_start();

class AdminController extends Controller
{
    public function login_google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
        // return $users->id;
        $authUser = $this->findOrCreateUser($users,'google'); // Lấy tài khoản từ DB hoặc tạo mới
        if($authUser)
        {
            $account_name = Login::where('admin_id',$authUser->user)->first();
            if($account_name)
            {
                Session::put('admin_name',$account_name->admin_name);
                Session::put('admin_id',$account_name->admin_id);
            }
        }
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    }

    public function findOrCreateUser($users, $provider)
    {
        // Kiểm tra tài khoản social có tồn tại không
        $authUser = Social::where('provider_user_id', $users->id)->first();

        if ($authUser) {
            return $authUser; 
        }

        $orang = Login::where('admin_email', $users->email)->first();

        if (!$orang) {
            $orang = Login::create([
                'admin_name' => $users->name,
                'admin_email' => $users->email,
                'admin_password' => '', 
                'admin_phone' => '',
            ]);
        }

        $customer_new = new Social([
            'provider_user_id' => $users->id,
            'provider' => strtoupper($provider),
        ]);
        $customer_new->login()->associate($orang);
        $customer_new->save();

        return $customer_new;
    }


    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider', 'facebook')
                        ->where('provider_user_id', $provider->getId())
                        ->first();

        if ($account) {
            $account_name = Login::where('admin_id', $account->user)->first();
        } 
        else 
        {
            $customer_new = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email', $provider->getEmail())->first();

            if (!$orang) {
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => '',
                ]);
            }

            // Liên kết tài khoản Facebook với tài khoản Login
            $customer_new->login()->associate($orang);
            $customer_new->save();

            $account_name = $orang;
        }

        Session::put('admin_name', $account_name->admin_name);
        Session::put('admin_id', $account_name->admin_id);

        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    }


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

    public function index()
    {
        return view('admin_login');
    }

    public function show_dashboard(Request $request)
    {
        $this->AuthLogin();

        $user_ip_address = $request->ip();
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDatestring();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDatestring();
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDatestring();
        $oneyears = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDatestring();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDatestring();

        // total last month
        $visitor_of_lastmonth = Visitors::whereBetween('date_visitor', [$early_last_month, $end_of_last_month])->get();
        $visitor_last_month_count = $visitor_of_lastmonth->count();

        // total this month
        $visitor_of_thismonth = Visitors::whereBetween('date_visitor', [$early_this_month, $now])->get();
        $visitor_this_month_count = $visitor_of_thismonth->count();

        // total in one year
        $visitor_of_year = Visitors::whereBetween('date_visitor', [$oneyears, $now])->get();
        $visitor_year_count = $visitor_of_year->count();

        // total visitors
        $visitors = Visitors::all();
        $visitors_total = $visitors->count();

        // current online
        $visitor_current = Visitors::where('ip_address', $user_ip_address)->get();
        $visitor_count = $visitor_current->count();

        if($visitor_count < 1)
        {
            $visitor = new Visitors();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_visitor = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();
        }

        // Total
        $product_count = Product::all()->count();
        $post_count = Post::all()->count();
        $order_count = Order::all()->count();
        $video_count = Video::all()->count();
        $customer_count = Customer::all()->count();

        $product_views = Product::orderBy('product_views', 'DESC')->take(20)->get();
        // $post_views = Post::orderBy('post_views', 'DESC')->take(20)->get();
        $post_views = Post::orderByRaw('CAST(post_views AS UNSIGNED) DESC')->take(20)->get();
        // $product_views = Post::orderByRaw('CAST(product_views AS UNSIGNED) DESC')->take(20)->get();

        return view('admin.dashboard')->with(compact('visitor_last_month_count', 'visitor_this_month_count', 'visitor_year_count', 'visitor_count', 'visitors_total', 'product_count', 'post_count', 'order_count', 'video_count', 'customer_count', 'product_views', 'post_views'));
    }

    public function dashboard(Request $request)
    {
        $data = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => ['required', new Captcha()],
        ]);


        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email', $admin_email)
                ->where('admin_password', $admin_password)
                ->first();

        if($login)
        {
            Session::put('admin_name', $login->admin_name);
            Session::put('admin_id', $login->admin_id);
            return Redirect::to('/dashboard');
        }
        else
        {
            Session::put('message', 'Mật khẩu hoặc tài khoản không hợp lệ. Vui lòng nhập lại!');
            return Redirect::to('/admin');
        }
    }

    public function logout()
    {
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }

    public function filter_by_date(Request  $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = Statistic::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();
        foreach($get as $key => $val)
        {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function days_order()
    {
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistic::whereBetween('order_date', [$sub30days, $now])->orderBy('order_date', 'ASC')->get();

        foreach($get as $key => $val)
        {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
}
