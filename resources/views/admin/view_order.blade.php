@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thông tin khách hàng
        </div>
     
        <div class="table-responsive">
            <?php
                $message = Session::get('message');
                if($message)
                {
                    echo '<span class="text-alert" style="color: red; width: 100%; text-align: center;">'.$message.'</span>';
                    Session::put('message', null);
                }
            ?>
            <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
            
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order_by_id->customer_name }}</td>
                    <td>{{ $order_by_id->customer_phone }}</td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>

<br>

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thông tin vận chuyển
        </div>
     
        <div class="table-responsive">
            <?php
                $message = Session::get('message');
                if($message)
                {
                    echo '<span class="text-alert" style="color: red; width: 100%; text-align: center;">'.$message.'</span>';
                    Session::put('message', null);
                }
            ?>
            <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                    <th>Tên người nhận hàng</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
            
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order_by_id->shipping_name }}</td>
                    <td>{{ $order_by_id->shipping_address }}</td>
                    <td>{{ $order_by_id->shipping_phone }}</td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>

<br>

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê chi tiết đơn hàng
        </div>
       
        <div class="table-responsive">
            <?php
                $message = Session::get('message');
                if($message)
                {
                    echo '<span class="text-alert" style="color: red; width: 100%; text-align: center;">'.$message.'</span>';
                    Session::put('message', null);
                }
            ?>
            <table class="table table-striped b-t b-light">
            <thead>
                <tr>
                <th style="width:20px;">
                    <label class="i-checks m-b-none">
                    <input type="checkbox"><i></i>
                    </label>
                </th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng tiền</th>
                {{-- <th>Quản lý</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($order_details as $order_details)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{ $order_details->product_name }}</td>
                    <td>{{ $order_details->product_sales_quantity }}</td>
                    <td>{{ $order_details->product_price }}</td>
                    <td>{{ number_format($order_details->product_sales_quantity * $order_details->product_price).' '. 'VNĐ' }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="row">
            
            <div class="col-sm-5 text-center">
                <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
            </div>
            <div class="col-sm-7 text-right text-center-xs">                
                <ul class="pagination pagination-sm m-t-none m-b-none">
                <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                <li><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                </ul>
            </div>
            </div>
        </footer>
    </div>
</div>
@endsection
