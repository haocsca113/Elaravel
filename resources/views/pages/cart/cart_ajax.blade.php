@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
              <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>

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
                            {{-- <td class="storage_quantity">Số lượng tồn</td> --}}
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
                                {{-- <td class="cart_storage_quantity">
                                    <h4><a href=""></a></h4>
                                    <p>{{ $cart['product_quantity'] }}</p>
                                </td> --}}
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
                                    @if(Session::get('customer_id'))
                                        <a class="btn btn-default check_out" href="{{ URL::to('/checkout') }}">Đặt hàng</a>
                                    @else
                                        <a class="btn btn-default check_out" href="{{ URL::to('/login-checkout') }}">Đặt hàng</a>
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
                                                      
                                                        <span>Tổng tiền sau khi giảm: {{ number_format(($total - $total_coupon), 0, ',', '.') }} VNĐ</span>
                                                    @elseif($cou['coupon_condition'] == 2)
                                                        <span>Mã giảm giá: {{ number_format($cou['coupon_number'], 0, ',', '.') }} VNĐ</span>
                                                        
                                                        @php
                                                            $total_coupon = $cou['coupon_number'];
                                                            echo '<span>Tổng giảm: '.number_format($total_coupon, 0, ',', '.').' VNĐ</span>';
                                                        @endphp
                                                      
                                                        <span>Tổng tiền sau khi giảm: {{ number_format(($total - $total_coupon), 0, ',', '.') }} VNĐ</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </li>
                                        {{-- <li>Phí vận chuyển: <span>Free</span></li> --}}
                                       
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
</section> <!--/#cart_items-->

{{-- <section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area1">
                    
                        
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action--> --}}

@endsection