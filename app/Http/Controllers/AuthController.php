<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ValidatesRequests;

    public function logout_auth()
    {
        Auth::logout();
        return redirect()->to('/login-auth')->with('message', 'Đăng xuất auth thành công!');
    }

    public function login_auth()
    {
        return view('admin.custom_auth.login_auth');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'admin_email' => 'required|email|max:255',
            'admin_password' => 'required|max:255',
        ]);
        
        $admin = Admin::where('admin_email', $request->admin_email)->first();
        if (!$admin) {
            return redirect()->back()->with('error', 'Email không tồn tại!');
        }

        if ($admin->admin_password === md5($request->admin_password)) {
            Auth::login($admin);
            return redirect()->to('/dashboard')->with('success', 'Đăng nhập thành công!');
        } else {
            return redirect()->back()->with('error', 'Sai mật khẩu!');
        }
    }

    public function register_auth()
    {
        return view('admin.custom_auth.register');
    }

    public function register(Request $request)
    {
        $this->validation($request);
        $data = $request->all();

        $admin = new Admin();
        $admin->admin_email = $data['admin_email'];
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->save();

        return redirect()->back()->with('message', 'Đăng ký thành công');
    }

    public function validation(Request $request)
    {
        return $this->validate($request, [
            'admin_email' => 'required|email|max:255',
            'admin_name' => 'required|max:255',
            'admin_phone' => 'required|max:255',
            'admin_password' => 'required|max:255',
        ]);
    }
}
