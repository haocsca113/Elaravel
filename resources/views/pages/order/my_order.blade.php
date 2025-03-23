@extends('welcome')
@section('content')

<div class="container">
    <h2>Đơn hàng của tôi</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    
    @if($orders->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <table border="1" cellpadding="10">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Trạng thái</th>
                <th>Ngày đặt hàng</th>
                <th>Chi tiết</th>
                <th>Hủy đơn</th>
                <th>Mã giảm giá cho đơn hàng kế tiếp</th>
            </tr>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_code }}</td>
                <td>
                    @if($order->order_status == 1)
                        Đang xử lý
                    @elseif($order->order_status == 2)
                        Đã xử lý
                    @elseif($order->order_status == 3)
                        Hủy đơn hàng
                    @endif
                </td>
                <td>{{ $order->created_at }}</td>
                <td><a href="{{ url('/my-order-detail/'.$order->order_code) }}">Xem</a></td>

                <td>
                    @if($order->order_status == 1) <!-- Chỉ cho hủy khi đang xử lý -->
                        <form action="{{ url('/cancel-order/'.$order->order_code) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">Hủy</button>
                        </form>
                    @else
                        <span style="color: gray;">Không thể hủy</span>
                    @endif
                </td>

                <td>
                    
                    @if($order->order_status == 2)
                        @php
                            $total_after = \App\Models\OrderDetails::where('order_code', $order->order_code)
                                ->selectRaw('SUM(product_price * product_sales_quantity) as total')
                                ->value('total');

                            $coupon = null;

                            if ($total_after >= 1000000 && $total_after < 3000000) 
                            {
                                $coupon = \App\Models\Coupon::where('coupon_condition', 2)->first();
                            } 
                            else if ($total_after >= 3000000) 
                            {
                                $coupon = \App\Models\Coupon::where('coupon_condition', 1)->first();
                            }
                        @endphp
                        @if($coupon)
                            {{ $coupon->coupon_code }}
                        @else
                            Dành cho đơn hàng trên 1tr
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    @endif
</div>

@endsection