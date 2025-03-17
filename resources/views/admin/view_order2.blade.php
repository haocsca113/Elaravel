@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thông tin đăng nhập
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
                <th>Email</th>
                <th>Số điện thoại</th>
            
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $customer->customer_name }}</td>
                    <td>{{ $customer->customer_email }}</td>
                    <td>{{ $customer->customer_phone }}</td>
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
            Thông tin vận chuyển hàng
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
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Ghi chú</th>
                    <th>Hình thức thanh toán</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $shipping->shipping_name }}</td>
                    <td>{{ $shipping->shipping_email }}</td>
                    <td>{{ $shipping->shipping_address }}</td>
                    <td>{{ $shipping->shipping_phone }}</td>
                    <td>{{ $shipping->shipping_note }}</td>
                    <td>
                        @if($shipping->shipping_method == 0)
                            Chuyển khoản
                        @elseif($shipping->shipping_method == 1)
                            Tiền mặt
                        @endif
                    </td>
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
                        <th>Thứ tự</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng kho còn</th>
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
                    <tr class="color_qty_{{ $details->product_id }}">
                        <td><i>{{ $i }}</i></td>
                        <td>{{ $details->product_name }}</td>
                        <td>{{ $details->product->product_quantity }}</td>
                        <td>
                            @if($details->product_coupon != 'no')
                                {{ $details->product_coupon }}
                            @else   
                                Không mã
                            @endif
                        </td>
                        <td>{{ number_format($details->product_feeship). ' VNĐ' }}</td>
                        <td>
                            <input type="number" min="1" {{ $order_status == 2 ? 'disabled' : '' }} class="order_qty_{{ $details->product_id }}" value="{{ $details->product_sales_quantity }}" name="product_sales_quantity" style="width: 50%;">

                            <input type="hidden" name="order_product_id" class="order_product_id" value="{{ $details->product_id }}">
                            <input type="hidden" name="order_code" class="order_code" value="{{ $details->order_code }}">
                            <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{ $details->product_id }}" value="{{ $details->product->product_quantity }}">

                            @if($order_status != 2)
                                <button class="btn btn-default update_quantity_order" data-product_id={{ $details->product_id }} name="update_quantity_order">Cập nhật</button>
                            @endif
                        </td>
                        <td>{{ number_format($details->product_price, 0, ',', '.'). ' VNĐ' }}</td>
                        <td>{{ number_format($subtotal, 0, ',', '.'). ' VNĐ' }}</td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="2">
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

                    <tr>
                        <td colspan="6">
                            @foreach($order as $key => $or)
                                @if($or->order_status == 1)
                                    <form action="">
                                        @csrf
                                        <select class="form-control order_details">
                                            <option value="">------Chọn hình thức đơn hàng------</option>
                                            <option id="{{ $or->order_id }}" value="1" selected>Chưa xử lý</option>
                                            <option id="{{ $or->order_id }}" value="2">Đã xử lý</option>
                                            <option id="{{ $or->order_id }}" value="3">Hủy đơn hàng</option>
                                        </select>
                                    </form>
                                @elseif($or->order_status == 2)
                                    <form action="">
                                        @csrf
                                        <select class="form-control order_details">
                                            <option value="">------Chọn hình thức đơn hàng------</option>
                                            <option id="{{ $or->order_id }}" value="1">Chưa xử lý</option>
                                            <option id="{{ $or->order_id }}" value="2" selected>Đã xử lý</option>
                                            <option id="{{ $or->order_id }}" value="3">Hủy đơn hàng</option>
                                        </select>
                                    </form>
                                @else
                                    <form action="">
                                        @csrf
                                        <select class="form-control order_details">
                                            <option value="">------Chọn hình thức đơn hàng------</option>
                                            <option id="{{ $or->order_id }}" value="1">Chưa xử lý</option>
                                            <option id="{{ $or->order_id }}" value="2">Đã xử lý</option>
                                            <option id="{{ $or->order_id }}" value="3" selected>Hủy đơn hàng</option>
                                        </select>
                                    </form>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>

            <a target="_blank" href="{{ url('/print-order/'.$details->order_code) }}">In đơn hàng</a>
        </div>
    </div>
</div>
@endsection
