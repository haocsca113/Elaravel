@extends('welcome')
@section('content')

<div class="container">
    <h2>Thông tin chuyển khoản</h2>
    <p>Vui lòng chuyển khoản theo thông tin sau:</p>
    
    <table class="table">
        @php
            $total_after = Session::get('total_after');
            $order_fee = Session::get('order_fee');
        @endphp
        <tr>
            <td><strong>Thanh toán:</strong></td>
            <td>{{ number_format($total_after + $order_fee , 0, ',', '.'). ' VNĐ' }}</td>
        </tr>
        <tr>
            <td><strong>Ngân hàng:</strong></td>
            <td>Vietcombank</td>
        </tr>
        <tr>
            <td><strong>Chủ tài khoản:</strong></td>
            <td>Trương Huỳnh Hào</td>
        </tr>
        <tr>
            <td><strong>Số tài khoản:</strong></td>
            <td>3988820943</td>
        </tr>
        <tr>
            <td><strong>Nội dung chuyển khoản:</strong></td>
            <td>Thanh toán đơn hàng #{{ Session::get('order_code') }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Vui lòng nhập đúng nội dung để đơn hàng được xác nhận.</strong></td>
        </tr>
    </table>

    <a href="{{ url('/') }}" class="btn btn-primary">Quay lại trang chủ</a>
</div>

@endsection