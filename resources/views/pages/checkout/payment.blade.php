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

        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>
        <div class="table-responsive cart_info">
            <?php
            $content = Cart::content();
            // echo '<pre>';
            //     print_r($content);
            // echo '</pre>'
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $v_content)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{ URL::to('upload/product/'.$v_content->options->image) }}" width="50" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{ $v_content->name }}</a></h4>
                            <p>Web ID: 1089772</p>
                        </td>
                        <td class="cart_price">
                            <p>{{ number_format($v_content->price).' '.'VNĐ' }}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{ URL::to('/update-cart-quantity') }}" method="post">
                                    {{ csrf_field() }}
                                    <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{ $v_content->qty }}">
                                    <input type="hidden" name="rowId_cart" value="{{ $v_content->rowId }}" class="form-control">
                                    <input type="submit" name="update_qty" value="Cập nhật" class="btn btn-default btn-sm">
                                </form>
                                
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                $subtotal = $v_content->price * $v_content->qty;
                                echo number_format($subtotal).' '.'VNĐ';
                                ?>
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{ URL::to('/delete-to-cart/'.$v_content->rowId) }}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h4 style="margin: 40px 0; font-size: 20px;">Chọn hình thức thanh toán</h4>
        <form action="{{ URL::to('/order-place') }}" method="post">
            {{ csrf_field() }}
            <div class="payment-options" style="margin-bottom: 20px;">
                <span>
                    <label><input type="checkbox" name="payment_option" value="1"> Thanh toán thẻ ATM</label>
                </span>
                <span>
                    <label><input type="checkbox" name="payment_option" value="2"> Nhận tiền sau khi giao hàng</label>
                </span>
                {{-- <span>
                    <label><input type="checkbox" name="payment_option" value="3"> Thanh toán Momo</label>
                </span> --}}
                <input type="submit" name="send_order_place" value="Đặt hàng" class="btn btn-primary btn-sm" style="margin-top: 0;">
            </div>
        </form>

        <div style="display: flex; gap: 10px;">
            <form action="{{ URL::to('/vnpay-payment') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="total_vnpay" value="{{ Cart::total() }}">
                {{-- <button type="submit" class="btn btn-default" name="redirect" href="">Thanh toán VNPay</button> --}}
                <button type="submit" class="btn btn-default" name="payment_option" value="3" href="">Thanh toán VNPay</button>
            </form>
            <form action="{{ URL::to('/momo-payment') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="total_momo" value="{{ Cart::total() }}">
                <button type="submit" class="btn btn-default" name="payUrl" value="4" href="">Thanh toán Momo</button>
                {{-- <button type="submit" class="btn btn-default" name="payment_option" value="4" href="">Thanh toán Momo</button> --}}
            </form>
        </div>
        
        
    </div>
</section> <!--/#cart_items-->

@endsection