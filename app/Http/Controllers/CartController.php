<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Banner;
use App\Models\Product;
use App\Models\CategoryPost;
use DB;
use Session;
use Cart;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    // Cart Ajax
    public function check_coupon(Request $request)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');

        $data = $request->all();

        if(Session::get('customer_id'))
        {
            $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->where('coupon_used', 'LIKE', '%'.Session::get('customer_id').'%')->first();

            if($coupon)
            {
                return redirect()->back()->with('error', 'Mã giảm giá đã sử dụng. Vui lòng nhập mã khác');
            }
            else
            {
                $coupon_login = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->first();

                if (!$coupon_login) {
                return redirect()->back()->with('error', 'Mã giảm giá không tồn tại hoặc đã hết hạn');
                }

                if ($coupon_login->coupon_time <= 0) {
                    return redirect()->back()->with('error', 'Mã giảm giá đã hết lượt sử dụng');
                }

                $coupon_session = Session::get('coupon') ?? [];

                // Kiểm tra mã giảm giá đã tồn tại trong session chưa
                $is_available = false;
                foreach ($coupon_session as $cou) {
                    if ($cou['coupon_code'] === $coupon_login->coupon_code) {
                        $is_available = true;
                        break;
                    }
                }

                if ($is_available) {
                    return redirect()->back()->with('error', 'Mã giảm giá này đã được áp dụng.');
                }

                $coupon_data = [
                    'coupon_code' => $coupon_login->coupon_code,
                    'coupon_condition' => $coupon_login->coupon_condition,
                    'coupon_number' => $coupon_login->coupon_number,
                ];

                // Chi lay ma giam gia cuoi cung
                $coupon_session = [$coupon_data];
                Session::put('coupon', $coupon_session);

                return redirect()->back()->with('message', 'Áp dụng mã giảm giá thành công.');
            }
        }

        // Nguoc lai chua dang nhap
        else
        {
            $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->first();

            if (!$coupon) {
                return redirect()->back()->with('error', 'Mã giảm giá không tồn tại hoặc đã hết hạn');
            }

            if ($coupon->coupon_time <= 0) {
                return redirect()->back()->with('error', 'Mã giảm giá đã hết lượt sử dụng');
            }

            // $coupon_session = Session::get('coupon', []);
            $coupon_session = Session::get('coupon') ?? [];

            // Kiểm tra mã giảm giá đã tồn tại trong session chưa
            $is_available = false;
            foreach ($coupon_session as $cou) {
                if ($cou['coupon_code'] === $coupon->coupon_code) {
                    $is_available = true;
                    break;
                }
            }

            if ($is_available) {
                return redirect()->back()->with('error', 'Mã giảm giá này đã được áp dụng.');
            }

            $coupon_data = [
                'coupon_code' => $coupon->coupon_code,
                'coupon_condition' => $coupon->coupon_condition,
                'coupon_number' => $coupon->coupon_number,
            ];

            // Chi lay ma giam gia cuoi cung
            $coupon_session = [$coupon_data];
            Session::put('coupon', $coupon_session);

            return redirect()->back()->with('message', 'Áp dụng mã giảm giá thành công.');
        }
    }

    public function gio_hang(Request $request)
    {
        // Banner
        $banner = Banner::orderBy('banner_id', 'desc')->take(4)->get();

        // SEO
        $meta_desc = 'Hiển thị giỏ hàng ajax';
        $meta_keywords = 'Hiển thị giỏ hàng ajax';
        $meta_title = 'Hiển thị giỏ hàng ajax';
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        $cate_post = CategoryPost::where('cate_post_status', '1')->orderBy('cate_post_id', 'desc')->get();

        return view('pages.cart.cart_ajax')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('banner', $banner)->with('cate_post', $cate_post);
    }

    public function add_cart_ajax(Request $request)
    {
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);

        $cart = Session::get('cart') ?? [];

        $is_available = false;
        foreach ($cart as $key => $val) {
            if ($val['product_id'] == $data['cart_product_id']) {
                $is_available = true;
                break;
            }
        }

        if (!$is_available) {
            $cart[] = [
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_price' => $data['cart_product_price'],
                'product_qty' => $data['cart_product_qty'],
            ];
            Session::put('cart', $cart);
            Session::save();
        }

        return response()->json(['success' => 'Thêm vào giỏ hàng thành công!']);
    }

    public function save_cart(Request $request)
    {
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();

        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        $data['id'] = $productId;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '123';
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);   
        Cart::setGlobalTax(5); 
        return Redirect::to('/show-cart');
        // Cart::destroy();
    }

    public function show_cart(Request $request)
    {
        // SEO
        $meta_desc = 'Hiển thị giỏ hàng';
        $meta_keywords = 'Hiển thị giỏ hàng';
        $meta_title = 'Hiển thị giỏ hàng';
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '1')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand_product')->where('brand_status', '1')->orderby('brand_id', 'desc')->get();

        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    }

    public function update_cart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart == true)
        {
            foreach($data['cart_qty'] as $key => $qty)
            {
                foreach($cart as $session => $val)
                {
                    if($val['session_id'] == $key)
                    {
                        $product = Product::where('product_id', $val['product_id'])->first();
                        if($product)
                        {
                            if($qty > $product->product_quantity)
                            {
                                return redirect()->back()->with('error', 'Số lượng sản phẩm "'.$val['product_name'].'" trong kho không đủ!');
                            }
                            else
                            {
                                $cart[$session]['product_qty'] = $qty; // Update so luong sp cua cart session do = $qty
                            }
                        }
                    }
                }
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Cập nhật số lượng thành công');
        }
        else
        {
            return redirect()->back()->with('error', 'Cập nhật số lượng thất bại');
        }
    }

    public function delete_cart_product($session_id)
    {   
        $cart = Session::get('cart');
        // echo '<pre>';
        // print_r($cart);
        // echo '</pre>';
        if($cart == true)
        {
            foreach($cart as $key => $val)
            {
                if($val['session_id'] == $session_id)
                {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart); // Cap nhat lai cart sau khi xoa VD: 5 sp con 4 sp
            return Redirect::to('/gio-hang')->with('message', 'Xóa sản phẩm thành công');
        }
        else
        {
            return Redirect::to('/gio-hang')->with('message', 'Xóa sản phẩm thất bại');
        }
    }

    public function delete_all_cart_product()
    {
        $cart = Session::get('cart');
        if($cart == true)
        {
            Session::forget('cart');
            Session::forget('coupon');
            return Redirect::to('/gio-hang')->with('message', 'Xóa hết sản phẩm giỏ hàng thành công');
        }
    }

    public function delete_to_cart($rowId)
    {   
        Cart::update($rowId, 0); // Cap nhat so luong = 0 => san pham ko ton tai => bien mat khoi gio hang
        return Redirect::to('/show-cart');
    }

    public function update_cart_quantity(Request $request)
    {   
        $rowId = $request->rowId_cart;
        $quantity = $request->cart_quantity;
        Cart::update($rowId, $quantity);
        return Redirect::to('/show-cart');
    }
}
