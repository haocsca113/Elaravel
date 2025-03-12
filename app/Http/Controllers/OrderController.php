<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Customer;
use App\Models\Coupon;
use PDF;

class OrderController extends Controller
{
    public function print_order($checkout_code)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));
        return $pdf->stream(); 
    }

    public function print_order_convert($checkout_code)
    {
        $order_details = OrderDetails::where('order_code', $checkout_code)->get();
        $order = Order::where('order_code', $checkout_code)->get();
        foreach($order as $key => $ord)
        {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

        foreach($order_details_product as $key => $order_d)
        {
            $product_coupon = $order_d->product_coupon;
        }
        
        $coupon = Coupon::where('coupon_code', $product_coupon)->first();
        if($coupon)
        {
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
            if($coupon_condition == 1)
            {
                $coupon_echo = $coupon_number.'%';
            }
            elseif($coupon_condition == 2)
            {
                $coupon_echo = number_format($coupon_number, 0, ',', '.').' đ';
            }
        }
        else
        {
            $coupon_condition = 0;
            $coupon_number = 0;
            $coupon_echo = 0;
        }

        $output = '';
        $output.= '
                <style>
                    body
                    {
                        font-family: Dejavu Sans;
                    }

                    .table-styling
                    {
                        border: 1px solid #000;
                    }

                    .table-styling tr th,td
                    {
                        border: 1px solid #000;
                    }
                </style>
                <h1><center>Công ty TNHH MTV ABC</center></h1>
                <h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>
                <p>Thông tin người đăng nhập</p>
                <table class="table-styling">
                    <thead>
                        <tr>
                            <th>Tên KH đăng nhập</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                        </tr>
                    </thead>

                    <tbody>';

            $output.='
                        <tr>
                            <td>'.$customer->customer_name.'</td>
                            <td>'.$customer->customer_email.'</td>
                            <td>'.$customer->customer_phone.'</td>
                        </tr>
                    ';

            $output.='
                    </tbody>
                </table>


                <p>Thông tin người đặt hàng</p>
                <table class="table-styling">
                    <thead>
                        <tr>
                            <th>Tên người đặt</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>

                    <tbody>';

            $output.='
                        <tr>
                            <td>'.$shipping->shipping_name.'</td>
                            <td>'.$shipping->shipping_email.'</td>
                            <td>'.$shipping->shipping_address.'</td>
                            <td>'.$shipping->shipping_phone.'</td>
                            <td>'.$shipping->shipping_note.'</td>
                        </tr>
                    ';

            $output.='
                    </tbody>
                </table>


                <p>Thông tin đơn hàng đặt</p>
                <table class="table-styling">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Mã giảm giá</th>
                            <th>Phí ship</th>
                            <th>Số lượng</th>
                            <th>Giá sản phẩm</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>

                    <tbody>';
                    $total = 0;
                    foreach($order_details_product as $key => $product){
                        if($product->product_coupon != 'no')
                        {
                            $product_coupon = $product->product_coupon;
                        }
                        else
                        {
                            $product_coupon = 'Không mã';
                        }
                        $subtotal = $product->product_sales_quantity * $product->product_price;
                        $total += $subtotal;
            $output.='
                        <tr>
                            <td>'.$product->product_name.'</td>
                            <td>'.$product_coupon.'</td>
                            <td>'.number_format($product->product_feeship, 0, ',', '.').' đ'.'</td>
                            <td>'.$product->product_sales_quantity.'</td>
                            <td>'.number_format($product->product_price, 0, ',', '.').' đ'.'</td>
                            <td>'.number_format($subtotal, 0, ',', '.').' đ'.'</td>
                        </tr>
                    ';
                    }

                    if($coupon_condition == 1)
                    {
                        $total_after_coupon = ($total * $coupon_number) / 100;
                        $total-=$total_after_coupon;
                    }
                    elseif($coupon_condition == 2)
                    {
                        $total-=$coupon_number;
                    }
                    elseif($coupon_condition == 0)
                    {
                        $total = $total;
                    }

            $output.='
                        <tr>
                            <td colspan="2">
                                <p>Tổng giảm: '.$coupon_echo.'</p>
                                <p>Phí ship: '.number_format($product->product_feeship, 0, ',', '.').' đ'.'</p>
                                <p>Thanh toán: '.number_format($total + $product->product_feeship, 0, ',', '.').' đ'.'</p>
                            </td>
                        </tr>
                    ';

            $output.='
                    </tbody>
                </table>


                <p>Ký tên</p>
                <table width="100%">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Người lập phiếu</th>
                            <th style="text-align: right;">Người nhận</th>
                        </tr>
                    </thead>

                    <tbody>';

            $output.='
                    </tbody>
                </table>

                ';

        return $output;
    }

    public function view_order($order_code)
    {
        // $order_details = OrderDetails::where('order_code', $checkout_code)->get();
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
