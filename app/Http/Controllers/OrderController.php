<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Coupon;

class OrderController extends Controller
{
    public function view_order($order_code)
    {
        // $order_details = OrderDetails::where('order_code', $order_code)->get();
        $order = Order::where('order_code', $order_code)->get();
        foreach($order as $key => $ord)
        {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();

        $order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
        foreach($order_details as $key => $order_d)
        {
            $product_coupon = $order_d->product_coupon;
        }
        
        $coupon = Coupon::where('coupon_code', $product_coupon)->first();
        if($coupon)
        {
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }
        else
        {
            $coupon_condition = 0;
            $coupon_number = 0;
        }

        return view('admin.view_order2')->with(compact('order_details', 'customer', 'shipping', 'coupon_condition', 'coupon_number'));
    }

    public function manage_order2()
    {
        $order = Order::orderBy('created_at', 'desc')->get();
        return view('admin.manage_order2')->with(compact('order'));
    }
}
