<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\City;
use App\Models\Province;
use App\Models\Ward;
use App\Models\Feeship;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Banner;
use App\Models\CategoryPost;
use App\Models\Category;
use App\Models\Brand;
use App\Models\VNPay;
use App\Models\Momo;
use App\Models\Coupon;
use App\Models\Customer;
use DB;
use Session;
use Cart;
use Mail;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
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

    public function payment_info(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Đơn hàng của tôi';
        $meta_keywords = 'Đơn hàng của tôi';
        $meta_title = 'Đơn hàng của tôi';
        $url_canonical = $request->url();

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        return view('pages.payment.payment_info')->with(compact('category', 'brand', 'banner', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'cate_post'));
    }

    public function confirm_order(Request $request)
    {
        $data = $request->all();

        // get coupon
        if($data['order_coupon'] != 'no')
        {
            $coupon = Coupon::where('coupon_code', $data['order_coupon'])->first();
            $coupon->coupon_used = $coupon->coupon_used.','.Session::get('customer_id');
            $coupon_time = $coupon->coupon_time;
            $coupon_remain = $coupon_time - 1;
            $coupon->coupon_time = $coupon_remain;

            $coupon_mail = $coupon->coupon_code;
            $coupon->save();
        }
        else
        {
            $coupon_mail = 'không sử dụng';
        }

        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'];
        $shipping->shipping_email = $data['shipping_email'];
        $shipping->shipping_note = $data['shipping_note'];
        $shipping->shipping_address = $data['shipping_address'];
        $shipping->shipping_phone = $data['shipping_phone'];
        $shipping->shipping_method = $data['shipping_method'];
        $shipping->save();
        $shipping_id = $shipping->shipping_id;

        $checkout_code = substr(md5(microtime()), rand(0,26),5);
        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $checkout_code;

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->created_at = now();
        $order->order_date = $order_date;
        $order->save();

        if(Session::get('cart'))
        {
            foreach(Session::get('cart') as $key => $cart)
            {
                $order_details = new OrderDetails();
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }

        // send mail confirm
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Đơn hàng xác nhận ngày".' '.$now;
        $customer = Customer::find(Session::get('customer_id'));

        $data['email'][] = $customer->customer_email;

        if(Session::get('cart') == true)
        {
            foreach(Session::get('cart') as $key => $cart_mail)
            {
                $cart_array[] = array(
                    'product_name' => $cart_mail['product_name'],
                    'product_price' => $cart_mail['product_price'],
                    'product_qty' => $cart_mail['product_qty'],
                );
            }
        }

        $shipping_array = array(
            'customer_name' => $customer->customer_name,
            'shipping_name' => $data['shipping_name'],
            'shipping_email' => $data['shipping_email'],
            'shipping_phone' => $data['shipping_phone'],
            'shipping_address' => $data['shipping_address'],
            'shipping_note' => $data['shipping_note'],
            'shipping_method' => $data['shipping_method']
        );

        $ordercode_mail = array(
            'coupon_code' => $coupon_mail,
            'order_code' => $checkout_code
        );

        Mail::send('pages.mail.mail_order', ['cart_array' => $cart_array, 'shipping_array' => $shipping_array, 'code' => $ordercode_mail], function($message) use($title_mail, $data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'], $title_mail);
        });

        Session::put('order_code', $checkout_code);
        Session::put('order_fee', $data['order_fee']);
        Session::put('shipping_method', $data['shipping_method']);

        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
    }

    public function validation(Request $request)
    {
        return $this->validate($request, [
            'shipping_name' => 'required|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_note' => 'required|max:255',
            'shipping_address' => 'required|max:255',
            'shipping_note' => 'required|max:255',
            'shipping_phone' => 'required|max:255',
        ]);
    }

    public function del_fee()
    {
        Session::forget('fee');
        return redirect()->back();
    }

    public function calculate_fee(Request $request)
    {
        $data = $request->all();
        if($data['matp'])
        {
            $feeship = Feeship::where('fee_matp', $data['matp'])->where('fee_maqh', $data['maqh'])->where('fee_xaid', $data['xaid'])->get();

            if($feeship)
            {
                $count_feeship = $feeship->count();
                if($count_feeship > 0)
                {
                    foreach($feeship as $key => $fee)
                    {
                        Session::put('fee', $fee->fee_feeship);
                        Session::save();
                    }
                }
                else
                {
                    Session::put('fee', 20000);
                    Session::save();
                }
            }

        }
    }

    public function select_delivery_home(Request $request)
    {
        $data = $request->all();
        if($data['action'])
        {
            $output = '';
            if($data['action'] == 'city')
            {
                $select_province = Province::where('matp', $data['ma_id'])->orderBy('maqh', 'asc')->get();
                if ($select_province->isEmpty()) {
                    return response()->json(['error' => 'Không có quận huyện nào.']);
                }

                $output.='<option>-----Chọn quận huyện-----</option>';
                foreach($select_province as $key => $province)
                {
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
            }
            elseif($data['action'] == 'province')
            {
                $select_ward = Ward::where('maqh', $data['ma_id'])->orderBy('xaid', 'asc')->get();
                if ($select_ward->isEmpty()) {
                    return response()->json(['error' => 'Không có xã phường nào.']);
                }

                $output.='<option>-----Chọn xã phường-----</option>';
                foreach($select_ward as $key => $ward)
                {
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
        }

        echo $output;
    }

    public function login_checkout(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = '';
        $meta_keywords = '';
        $meta_title = '';
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        return view('pages.checkout.login_checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('banner', $banner)->with('cate_post', $cate_post);
    }

    public function add_customer(Request $request)
    {
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;

        $customer_id = DB::table('tbl_customer')->insertGetId($data);
        Session::put('message', 'Bạn đã đăng ký thành công');
        return Redirect::to('/login-checkout');
    }

    public function login_checkout_customer(Request $request)
    {
        $customer_email = $request->email_account;
        $customer_password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email', $customer_email)->where('customer_password', $customer_password)->first();

        if(Session::get('coupon'))
        {
            Session::forget('coupon');
        }

        if($result)
        {
            Session::put('customer_id', $result->customer_id);
            Session::put('customer_name', $result->customer_name);
            return Redirect::to('/');
        }
        else
        {
            Session::put('message', 'Mật khẩu hoặc tài khoản không hợp lệ. Vui lòng nhập lại!');
            return Redirect::to('/login-checkout');
        }
    }

    public function checkout(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Thanh toán';
        $meta_keywords = 'Thanh toán';
        $meta_title = 'Thanh toán';
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $city = City::orderBy('matp', 'asc')->get();

        return view('pages.checkout.show_checkout')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('city', $city)->with('banner', $banner)->with('cate_post', $cate_post);
    }

    public function save_checkout_customer(Request $request)
    {
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_note'] = $request->shipping_note;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id', $shipping_id);
        return Redirect::to('/payment');
    }

    public function payment(Request $request)
    {
        // SEO
        $meta_desc = 'Thanh toán đơn hàng';
        $meta_keywords = 'Thanh toán đơn hàng';
        $meta_title = 'Thanh toán đơn hàng';
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        return view('pages.checkout.payment')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    }

    public function logout_checkout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request)
    {
        $data = $request->all();
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        Session::put('payUrl', $request->payUrl);
        $total_pay = Session::get('total_after') + Session::get('order_fee');

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua ATM MoMo";
        // $amount = floatval(str_replace(',', '', $data['total_momo']));
        $amount = floatval(str_replace(',', '', $total_pay));
        $orderId = time() . "";
        // $redirectUrl = "http://localhost:8080/laravel/webbanhang_tutorial/public/momo-online-payment";
        // $ipnUrl = "http://localhost:8080/laravel/webbanhang_tutorial/public/momo-online-payment";

        $redirectUrl = "http://127.0.0.1:8000/momo-online-payment";
        $ipnUrl = "http://127.0.0.1:8000/momo-online-payment";

        // $redirectUrl = "https://pogshop.online/momo-online-payment";
        // $ipnUrl = "https://pogshop.online/momo-online-payment";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        // dd($signature);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
            
        $result = $this->execPostRequest($endpoint, json_encode($data));
        // dd($result);
        $jsonResult = json_decode($result, true);  // decode json

        return redirect()->to($jsonResult['payUrl']);
    }

    public function vnpay_payment(Request $request)
    {
        $data = $request->all();
        $code_cart = rand(00, 9999);

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

        // $vnp_Returnurl = "http://localhost:8080/laravel/webbanhang_tutorial/public/vnpay-online-payment";
        $vnp_Returnurl = "http://127.0.0.1:8000/vnpay-online-payment";
        // $vnp_Returnurl = "https://pogshop.online/vnpay-online-payment";
        
        $vnp_TmnCode = "FY58L6R9";//Mã website tại VNPAY 
        $vnp_HashSecret = "L52E481P39WYAFKDAZUZPHHK0MIPQ4M6"; //Chuỗi bí mật
        
        $vnp_TxnRef = $code_cart; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng test';
        $vnp_OrderType = 'bill payment';
        // $vnp_Amount = floatval(str_replace(',', '', $data['total_vnpay'])) * 100;
        $vnp_Amount = floatval(str_replace(',', '', Session::get('total_after') + Session::get('order_fee'))) * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Billing
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
    
            // if ($request->has('payment_option')) {    
            //     Session::put('payment_option', $request->payment_option); 
            //     Session::save(); 
            //     return redirect()->away($vnp_Url); 
            // }
   
            if($_POST['vnp_Url'])
            {
                return redirect()->away($vnp_Url);
            }
            else {
                echo json_encode($returnData);
            }
            // vui lòng tham khảo thêm tại code demo 
    }

    public function vnpay_online_payment(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Xác nhận đặt hàng VNPay';
        $meta_keywords = 'Xác nhận đặt hàng VNPay';
        $meta_title = 'Xác nhận đặt hàng VNPay';
        $url_canonical = $request->url();

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $shipping_method = Session::get('shipping_method');
        
        if($shipping_method == 2)
        {
            $vnpay = new VNPay();
            $vnpay->vnp_amount = $request->query('vnp_Amount');
            $vnpay->vnp_bankcode = $request->query('vnp_BankCode');
            $vnpay->vnp_banktranno = $request->query('vnp_BankTranNo');
            $vnpay->vnp_cardtype = $request->query('vnp_CardType');
            $vnpay->vnp_orderinfo = $request->query('vnp_OrderInfo');
            $vnpay->vnp_paydate = $request->query('vnp_PayDate');
            $vnpay->vnp_tmncode = $request->query('vnp_TmnCode');
            $vnpay->vnp_transactionno = $request->query('vnp_TransactionNo');
            $vnpay->code_cart = $request->query('vnp_TxnRef');
            $vnpay->save();

            return view('pages.checkout.ttvnpay')->with(compact('category', 'brand', 'banner', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'cate_post'));
        } 
    }

    public function momo_online_payment(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Xác nhận đặt hàng Momo';
        $meta_keywords = 'Xác nhận đặt hàng Momo';
        $meta_title = 'Xác nhận đặt hàng Momo';
        $url_canonical = $request->url();

        $category = Category::where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        $shipping_method = Session::get('shipping_method');
        if($shipping_method == 3)
        {
            $momo = new Momo();
            $momo->partner_code = $request->query('partnerCode');
            $momo->order_id = $request->query('orderId');
            $momo->amount = $request->query('amount');
            $momo->order_info = $request->query('orderInfo');
            $momo->order_type = $request->query('orderType');
            $momo->trans_id = $request->query('transId');
            $momo->pay_type = $request->query('payType');
            $momo->save();

            return view('pages.checkout.ttmomo')->with(compact('category', 'brand', 'banner', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'cate_post'));
        }
    }

    public function order_place(Request $request)
    {
        // SEO
        $meta_desc = 'Xác nhận đặt hàng';
        $meta_keywords = 'Xác nhận đặt hàng';
        $meta_title = 'Xác nhận đặt hàng';
        $url_canonical = $request->url();

        // insert payment method
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        // insert order
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = (Cart::total(0, ',', '.')).' '.'VNĐ';
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        // insert order_details
        $content = Cart::content();
        foreach($content as $v_content)
        {
            $order_details_data = array();
            $order_details_data['order_id'] = $order_id;
            $order_details_data['product_id'] = $v_content->id;
            $order_details_data['product_name'] = $v_content->name;
            $order_details_data['product_price'] = $v_content->price;
            $order_details_data['product_sales_quantity'] = $v_content->qty;
            DB::table('tbl_order_details')->insert($order_details_data);
        }

        if($data['payment_method'] == 1)
        {
            echo 'Thanh toán thẻ ATM';
        }
        elseif($data['payment_method'] == 2)
        {
            $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
            $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

            Cart::destroy();
            
            return view('pages.checkout.handcash')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
        }
        else
        {
            echo 'Momo';
        }
    }

    // Trang Admin
    public function manage_order()
    {
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
        ->select('tbl_order.*', 'tbl_customer.customer_name')
        ->orderby('tbl_order.order_id', 'desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order', $all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }

    public function view_order($orderId)
    {
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
        ->join('tbl_customer', 'tbl_customer.customer_id', '=', 'tbl_order.customer_id')
        ->join('tbl_shipping', 'tbl_shipping.shipping_id', '=', 'tbl_order.shipping_id')
        ->where('tbl_order.order_id', $orderId)
        ->select('tbl_order.*', 'tbl_customer.*', 'tbl_shipping.*')->first();

        $order_details = DB::table('tbl_order_details')
        ->where('order_id', $orderId)
        ->get();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id)->with('order_details', $order_details);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }
}
