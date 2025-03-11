@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê đơn hàng
        </div>
        <div class="row w3-res-tb">

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
                <th>Mã đơn hàng</th>
                <th>Ngày tháng đặt hàng</th>
                <th>Tình trạng đơn hàng</th>
                <th style="width:30px;"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                @endphp

                @foreach($order as $key => $ord)
                @php
                    $i++;
                @endphp
                <tr>
                    <td><i>{{ $i }}</i></td>
                    <td>{{ $ord->order_code }}</td>
                    <td>{{ $ord->created_at }}</td>
                    <td>
                        @if($ord->order_status == 1)
                            Đơn hàng mới
                        @else
                            Đã xử lý
                        @endif
                    </td>
                   
                    <td>
                        <a href="{{ URL::to('/view-order/'.$ord->order_code) }}" class="active styling-edit" ui-toggle-class="">
                            <i class="fa fa-eye text-success text-active"></i>
                        </a>
                        <a href="{{ URL::to('/delete-order/'.$ord->order_code) }}" class="active styling-edit" ui-toggle-class="" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')">
                            <i class="fa fa-times text-danger text"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>

        {{-- <footer class="panel-footer">
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
        </footer> --}}
    </div>
</div>
@endsection
