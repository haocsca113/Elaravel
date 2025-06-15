<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Customer;
use Carbon\Carbon;
use Mail;
use Session;
session_start();

class MailController extends Controller
{
    public function send_coupon()
    {
        $customer_vip = Customer::where('customer_vip', 1)->get();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        
        $title_mail = "Mã khuyến mãi ngày " . $now;

        $data = [];
        foreach($customer_vip as $vip)
        {
            $data['email'][] = $vip->customer_email;
        }
        // dd($data);
        Mail::send('pages.send_coupon', $data, function($message) use($title_mail, $data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'], $title_mail);
        });

        return redirect()->back()->with('message', 'Gửi mã khuyến mãi khách vip thành công');
    }

    public function mail_example()
    {
        return view('pages.send_coupon');
    }
}
