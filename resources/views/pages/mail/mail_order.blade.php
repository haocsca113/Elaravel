<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác nhận đơn hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>
<body>
    <div class="container" style="background: #222; border-radius: 12px; padding: 15px;">
        <div class="col-md-12">
            <p style="text-align: center; color: fff;">Đây là email tự động. Quý khách vui lòng không trả lời email này</p>
            <div class="row" style="background: cadetblue; padding: 15px;">
                <div class="col-md-6" style="text-align: center; color: #fff; font-weight: bold; font-size: 30px;">
                    <h4>CÔNG TY BÁN HÀNG POGSHOP</h4>
                    <h6>DỊCH VỤ BÁN HÀNG - VẬN CHUYỂN - NHẬP KHẨU CHUYÊN NGHIỆP</h6>
                </div>

                <div class="col-md-6">
                    <p>Chào bạn<strong>{{ $shipping_array['customer_name'] }}</strong></p>
                </div>

                <div class="col-md-12">
                    <p>Bạn hoặc ai đó đã đăng ký dịch vụ tại shop với thông tin như sau:</p>
                    <h4>Thông tin đơn hàng</h4>
                    <p>Mã đơn hàng: <strong>{{ $code['order_code'] }}</strong></p>
                    <p>Mã khuyến mãi áp dụng: <strong>{{ $code['coupon_code'] }}</strong></p>
                    <p>Dịch vụ: <strong>Đặt hàng trực tuyến</strong></p>

                    <h4>Thông tin người nhận</h4>
                    <p>Email:
                        @if($shipping_array['shipping_email'] == '')
                            không có
                        @else
                            <span style="color: #fff;">{{ $shipping_array['shipping_email'] }}</span>
                        @endif
                    </p>

                    <p>Họ tên người gửi:
                        @if($shipping_array['shipping_name'] == '')
                            không có
                        @else
                            <span style="color: #fff;">{{ $shipping_array['shipping_name'] }}</span>
                        @endif
                    </p>

                    <p>Địa chỉ nhận hàng:
                        @if($shipping_array['shipping_address'] == '')
                            không có
                        @else
                            <span style="color: #fff;">{{ $shipping_array['shipping_address'] }}</span>
                        @endif
                    </p>

                    <p>Số điện thoại:
                        @if($shipping_array['shipping_phone'] == '')
                            không có
                        @else
                            <span style="color: #fff;">{{ $shipping_array['shipping_phone'] }}</span>
                        @endif
                    </p>

                    <p>Ghi chú đơn hàng:
                        @if($shipping_array['shipping_note'] == '')
                            không có
                        @else
                            <span style="color: #fff;">{{ $shipping_array['shipping_note'] }}</span>
                        @endif
                    </p>

                    <p>Hình thức thanh toán: <strong style="text-transform: uppercase; color: #fff;">
                        @if($shipping_array['shipping_method'] == 0)
                            Chuyển khoản
                        @elseif($shipping_array['shipping_method'] == 1)
                            Tiền mặt
                        @elseif($shipping_array['shipping_method'] == 2)
                            VNPay
                        @elseif($shipping_array['shipping_method'] == 3)
                            Momo
                        @endif
                    </strong></p>

                    <p>Nếu thông tin người nhận hàng không có chúng tôi sẽ liên hệ với người đặt hàng để trao đổi thông tin về đơn hàng đã đặt.</p>

                    <h4>Sản phẩm đã đặt</h4>
                    <table class="table table-striped" style="border: 1px;">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá tiền</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $sub_total = 0;
                                $total = 0;
                            @endphp

                            @foreach($cart_array as $cart)    
                                @php
                                    $sub_total = $cart['product_qty'] * $cart['product_price'];
                                    $total += $sub_total;
                                @endphp
                                <tr>
                                    <td>{{ $cart['product_name'] }}</td>
                                    <td>{{ number_format($cart['product_price'], 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $cart['product_qty'] }}</td>
                                    <td>{{ number_format($sub_total, 0, ',', '.') }} VNĐ</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="4" align="right">
                                    Tổng tiền thanh toán: 
                                    {{ number_format($total, 0, ',', '.') }} VNĐ
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" align="right">
                                    @php
                                        $total_after = Session::get('total_after');
                                        $order_fee = Session::get('order_fee');
                                    @endphp
                                    Tổng tiền thực sự cần thanh toán nếu có mã giảm giá hoặc không: 
                                    {{ number_format($total_after + $order_fee , 0, ',', '.'). ' VNĐ' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p style="color: #fff;"> Mọi chi tiết xin liên hệ tại website: <a target="_blank" href="https://pogshop.online/">Pogshop</a>, hoặc liên hệ qua số: 0988820943. Xin cảm ơn quý khách đã đặt hàng tại shop chúng tôi</p>
            </div>
        </div>
    </div>
</body>
</html>