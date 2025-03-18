@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
              <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>

        <div class="register-req">
            <p>Đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin gửi hàng</p>
                        <div class="form-one">
                            <form action="" method="post">
                                @csrf
                                <input type="text" name="shipping_email" class="shipping_email" placeholder="Email">
                                <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên">
                                <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ">
                                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại">
                                <textarea name="shipping_note" class="shipping_note" placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>

                                @if(Session::get('fee'))
                                    <input type="hidden" name="order_fee" class="order_fee" value="{{ Session::get('fee') }}">
                                @else
                                    <input type="hidden" name="order_fee" class="order_fee" value="20000">
                                @endif

                                @if(Session::get('coupon'))
                                    @foreach(Session::get('coupon') as $key => $cou)
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="{{ $cou['coupon_code'] }}">
                                    @endforeach
                                @else
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                                @endif
                                
                                <div class="">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                                        <select name="payment_select" class="form-control input-sm m-bot15 payment_select">
                                            <option value="0">Chuyển khoản</option>
                                            <option value="1">Tiền mặt</option>
                                            <option value="2">VN Pay</option>
                                            <option value="3">Momo</option>
                                        </select> 
                                    </div>
                                </div>

                                <input type="button" name="send_order" value="Xác nhận đơn hàng" class="btn btn-primary btn-sm send_order">
                            </form>

                            <form>
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn thành phố</label>
                                    <select id="city" name="city" class="form-control input-sm m-bot15 choose city">
                                        <option value="0">--------Chọn tỉnh thành phố--------</option>
                                        @foreach($city as $key => $ci)
                                            <option value="{{ $ci->matp }}">{{ $ci->name_city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn quận huyện</label>
                                    <select id="province" name="province" class="form-control input-sm m-bot15 choose province">
                                        <option value="0">--------Chọn quận huyện--------</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn xã phường</label>
                                    <select id="ward" name="ward" class="form-control input-sm m-bot15 ward">
                                        <option value="0">--------Chọn xã phường--------</option>
                                    </select>
                                </div>
                                
                                <input type="button" name="calculate_delivery" value="Tính phí vận chuyển" class="btn btn-primary btn-sm calculate_delivery">
                            </form>
                               
                        </div>  
                    </div>
                </div>

                <div class="col-sm-12 clearfix">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @elseif(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <div class="table-responsive cart_info">
                        <table class="table table-condensed">
                            <form action="{{ URL::to('/update-cart') }}" method="post">
                                {{ csrf_field() }}
                                <thead>
                                    <tr class="cart_menu">
                                        <td class="image">Hình ảnh</td>
                                        <td class="name">Tên sản phẩm</td>
                                        <td class="price">Giá sản phẩm</td>
                                        <td class="quantity">Số lượng</td>
                                        <td class="total">Thành tiền</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(Session::get('cart') == true)
                                        @php
                                            $total = 0;
                                        @endphp
            
                                        @foreach(Session::get('cart') as $key => $cart)
                                        @php
                                            $subtotal = $cart['product_price'] * $cart['product_qty'];
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td class="cart_product">
                                                <a href=""><img src="{{ asset('upload/product/'.$cart['product_image']) }}" width="50" alt="{{ $cart['product_name'] }}"></a>
                                            </td>
                                            <td class="cart_name">
                                                <h4><a href=""></a></h4>
                                                <p>{{ $cart['product_name'] }}</p>
                                            </td>
                                            <td class="cart_price">
                                                <p>{{ number_format($cart['product_price'], 0, ',', '.').' VNĐ' }}</p>
                                            </td>
                                            <td class="cart_quantity">
                                                <div class="cart_quantity_button">
                                                    
                                                    <input class="cart_quantity" type="number" min="1" name="cart_qty[{{ $cart['session_id'] }}]" value="{{ $cart['product_qty'] }}">
                                                        
                                                </div>
                                            </td>
                                            <td class="cart_total">
                                                <p class="cart_total_price">
                                                    {{ number_format($subtotal, 0, ',', '.').' VNĐ' }}
                                                </p>
                                            </td>
                                            <td class="cart_delete">
                                                <a class="cart_quantity_delete" href="{{ URL::to('/delete-cart-product/'.$cart['session_id']) }}"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <input type="submit" name="update_qty" value="Cập nhật giỏ hàng" class="btn btn-default btn-sm check_out">
                                            </td>
                                            <td>
                                                <a class="btn btn-default check_out" href="{{ URL::to('/delete-all-cart-product') }}">Xóa tất cả</a>
                                                @if(Session::get('coupon'))
                                                    <a class="btn btn-default check_out" href="{{ URL::to('/delete-cart-coupon') }}">Xóa mã khuyến mãi</a>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                <ul>
                                                    <li>Tổng tiền: <span>{{ number_format($total, 0, ',', '.').' VNĐ' }}</span></li>
                                
                                                    <li style="display: flex; flex-direction: column;"> 
                                                        @if(Session::get('coupon'))
                                                            @foreach(Session::get('coupon') as $key => $cou)
                                                                @if($cou['coupon_condition'] == 1)
                                                                    <span>Mã giảm giá: {{ $cou['coupon_number'] }}%</span>
                                                                  
                                                                    @php
                                                                        $total_coupon = ($total * $cou['coupon_number']) / 100;
                                                                        echo '<span>Tổng giảm: '.number_format($total_coupon, 0, ',', '.').' VNĐ</span>';
                                                                    @endphp

                                                                    @php
                                                                        $total_after_coupon = $total - $total_coupon;
                                                                    @endphp
                                                                  
                                                                    {{-- <span>Tổng tiền sau khi giảm: {{ number_format(($total - $total_coupon), 0, ',', '.') }} VNĐ</span> --}}
                                                                @elseif($cou['coupon_condition'] == 2)
                                                                    <span>Mã giảm giá: {{ number_format($cou['coupon_number'], 0, ',', '.') }} VNĐ</span>
                                                                    
                                                                    @php
                                                                        $total_coupon = $cou['coupon_number'];
                                                                        echo '<span>Tổng giảm: '.number_format($total_coupon, 0, ',', '.').' VNĐ</span>';
                                                                    @endphp

                                                                    @php
                                                                        $total_after_coupon = $total - $total_coupon;
                                                                    @endphp
                                                                  
                                                                    {{-- <span>Tổng tiền sau khi giảm: {{ number_format(($total - $total_coupon), 0, ',', '.') }} VNĐ</span> --}}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </li>

                                                    @if(Session::get('fee'))
                                                        <li>
                                                            <a class="cart_quantity_delete" href="{{ URL::to('/del-fee') }}"><i class="fa fa-times"></i></a>
                                                            Phí vận chuyển: <span>{{ number_format(Session::get('fee'), 0, ',', '.')}} VNĐ</span>

                                                            @php
                                                                $total_after_fee = $total + Session::get('fee');
                                                            @endphp
                                                        </li>
                                                    @endif

                                                    <li>
                                                        Tổng tiền sau khi giảm:
                                                        @php
                                                            if(Session::get('fee') && !Session::get('coupon'))
                                                            {
                                                                $total_after = $total + Session::get('fee');
                                                                echo '<span>'.number_format($total_after, 0, ',', '.'). ' VNĐ'. '</span>';
                                                            }
                                                            elseif(!Session::get('fee') && Session::get('coupon'))
                                                            {
                                                                $total_after = $total - $total_coupon;
                                                                echo '<span>'.number_format($total_after, 0, ',', '.'). ' VNĐ'. '</span>';
                                                            }
                                                            elseif(Session::get('fee') && Session::get('coupon'))
                                                            {
                                                                $total_after = $total - $total_coupon + Session::get('fee');
                                                                echo '<span>'.number_format($total_after, 0, ',', '.'). ' VNĐ'. '</span>';
                                                            }
                                                            elseif(!Session::get('fee') && !Session::get('coupon'))
                                                            {
                                                                $total_after = $total;
                                                                echo '<span>'.number_format($total_after, 0, ',', '.'). ' VNĐ'. '</span>';
                                                            }
                                                        @endphp

                                                        @php
                                                            Session::put('total_after', $total_after);
                                                        @endphp
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>
                                                <p class="">Không có sản phẩm nào trong giỏ hàng</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>  
                            </form>
            
                            @if(Session::get('cart'))
                                <tr>
                                    <td>
                                        {{-- <a class="btn btn-default check_out">Thanh toán</a> --}}
                                        <form action="{{ URL::to('/check-coupon') }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="text" name="coupon" class="form-control" placeholder="Nhập mã giảm giá">
                                            <br>
                                            <input type="submit" name="check_coupon" class="btn btn-default check_coupon" value="Tính mã giảm giá">
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!--/#cart_items-->

@endsection