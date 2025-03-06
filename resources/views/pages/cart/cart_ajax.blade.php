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
            <form action="{{ URL::to('/update-cart') }}" method="post">
                {{ csrf_field() }}
                <table class="table table-condensed">
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
                                </td>
                                <td>
                                    <ul>
                                        <li>Tổng tiền: <span>{{ number_format($total, 0, ',', '.').' VNĐ' }}</span></li>
                                        <li>Thuế: <span></span></li>
                                        <li>Phí vận chuyển: <span>Free</span></li>
                                        <li>Tiền sau giảm: <span></span></li>
                                    </ul>
                                </td>
                                <td>
                                    <a class="btn btn-default check_out">Thanh toán</a>
                                    <a class="btn btn-default check_out">Tính mã giảm giá</a>
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
                    
                </table>
                
            </form>
        </div>
    </div>
</section> <!--/#cart_items-->

{{-- <section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng tiền <span>{{ number_format($total, 0, ',', '.').' VNĐ' }}</span></li>
                        <li>Thuế <span></span></li>
                        <li>Phí vận chuyển <span>Free</span></li>
                        <li>Tiền sau giảm <span></span></li>
                    </ul>
                    
                    <a class="btn btn-default check_out">Thanh toán</a>
                
                    <a class="btn btn-default check_out">Tính mã giảm giá</a>

                    
                </div>
            </div>
        </div>
    </div>
</section> --}}

@endsection