@extends('welcome')
@section('content')

<div class="container">
    <h2>Đơn hàng của tôi</h2>
    
    @if($orders->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <table border="1" cellpadding="10">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Trạng thái</th>
                <th>Ngày đặt hàng</th>
                <th>Chi tiết</th>
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
            </tr>
            @endforeach
        </table>
    @endif
</div>

@endsection