@extends('welcome')
@section('content')

<div class="container">
    <h2>Chi tiết đơn hàng của tôi</h2>
    
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Thứ tự</th>
                <th>Tên sản phẩm</th>
                <th>Mã giảm giá</th>
                <th>Phí ship</th>
                <th>Số lượng</th>
                <th>Giá sản phẩm</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0; 
                $total = 0;
            @endphp
            @foreach($order_details as $key => $details)
            @php
                $i++;
                $subtotal = $details->product_sales_quantity * $details->product_price;
                $total += $subtotal;
            @endphp
            <tr class="">
                <td>{{ $i }}</td>
                <td>{{ $details->product_name }}</td>
                <td>
                    @if($details->product_coupon != 'no')
                        {{ $details->product_coupon }}
                    @else   
                        Không mã
                    @endif
                </td>
                <td>{{ number_format($details->product_feeship). ' VNĐ' }}</td>
                <td>
                    <input type="number" min="1" class="" value="{{ $details->product_sales_quantity }}" name="product_sales_quantity" style="width: 50%;" readonly>
                </td>
                <td>{{ number_format($details->product_price, 0, ',', '.'). ' VNĐ' }}</td>
                <td>{{ number_format($subtotal, 0, ',', '.'). ' VNĐ' }}</td>
            </tr>
            @endforeach

            <tr>
                <td colspan="7">
                    @if($coupon_condition == 1)
                        Tổng giảm: {{ $coupon_number }}%
                        <br>
                        @php
                            $total_after_coupon = ($total * $coupon_number) / 100;
                            $total-=$total_after_coupon;
                        @endphp
                    @elseif($coupon_condition == 2)
                        Tổng giảm: {{ number_format($coupon_number, 0, ',', '.'). ' VNĐ' }}
                        <br>
                        @php
                            $total-=$coupon_number;
                        @endphp
                    @elseif($coupon_condition == 0)
                        @php
                            $total = $total;
                        @endphp
                    @endif

                    Phí ship: {{ number_format($details->product_feeship). ' VNĐ' }}
                    <br>
                    Thanh toán: {{ number_format($total + $details->product_feeship, 0, ',', '.'). ' VNĐ' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection