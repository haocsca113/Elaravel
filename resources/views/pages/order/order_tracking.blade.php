@extends('welcome')
@section('content')

<div class="container">
    <h2>Theo dõi đơn hàng</h2>
    
    <form action="{{ url('/order-tracking') }}" method="GET">
        <label for="order_code">Nhập mã đơn hàng:</label>
        <input type="text" name="order_code" required>
        <button type="submit">Tra cứu</button>
    </form>

    @if(isset($order))
        <p style="margin-top: 10px;"><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</p>
        <p><strong>Trạng thái:</strong> 
            @if($order->order_status == 1)
                Đơn hàng đang xử lý vui lòng đợi
            @elseif($order->order_status == 2)
                Đơn hàng đã xử lý và sẽ được giao trong vòng 2 đến 3 ngày kể từ ngày đặt hàng
            @elseif($order->order_status == 3)
                Đơn hàng đã hủy
            @endif
        </p>
    @elseif(request()->has('order_code'))
        <p style="color: red;">Không tìm thấy đơn hàng.</p>
    @endif
</div>

@endsection