<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Social;
use Laravel\Socialite\Facades\Socialite;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
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
        $admin_id = Session::get('admin_id');
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

    public function show_dashboard()
    {
        $this->AuthLogin();
        return view('admin.dashboard');
    }

    public function dashboard(Request $request)
    {
        $data = $request->all();
        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        $login_count = $login->count();
        if($login_count)
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

        // $admin_email = $request->admin_email;
        // $admin_password = md5($request->admin_password);
        // $result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        // if($result)
        // {
        //     Session::put('admin_name', $result->admin_name);
        //     Session::put('admin_id', $result->admin_id);
        //     return Redirect::to('/dashboard');
        // }
        // else
        // {
        //     Session::put('message', 'Mật khẩu hoặc tài khoản không hợp lệ. Vui lòng nhập lại!');
        //     return Redirect::to('/admin');
        // }
    }

    public function logout()
    {
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }
}
