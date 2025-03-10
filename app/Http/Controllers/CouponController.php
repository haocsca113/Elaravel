<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Coupon;
session_start();

class CouponController extends Controller
{
    public function delete_cart_coupon()
    {
        $coupon = Session::get('coupon');
        if($coupon == true)
        {
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Xóa mã giảm giá thành công');
        }
    }

    public function insert_coupon()
    {
        return view('admin.coupon.insert_coupon');
    }

    public function delete_coupon($coupon_id)
    {
        $coupon = Coupon::find($coupon_id); // find chi dung de so sanh id, muon so sanh truong khac thi dung where
        $coupon->delete();
        Session::put('message', 'Xóa mã giảm giá thành công');
        return redirect()->to('/list-coupon');
    }

    public function insert_coupon_code(Request $request)
    {
        $data = $request->all();
        $coupon = new Coupon;
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->save();

        Session::put('message', 'Thêm mã giảm giá thành công');
        return redirect()->to('/insert-coupon');
    }

    public function list_coupon()
    {
        $coupon = Coupon::orderBy('coupon_id', 'desc')->get();
        return view('admin.coupon.list_coupon')->with(compact('coupon'));
    }
}
