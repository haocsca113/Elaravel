@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê mã giảm giá
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
                {{-- <select class="input-sm form-control w-sm inline v-middle">
                    <option value="0">Bulk action</option>
                    <option value="1">Delete selected</option>
                    <option value="2">Bulk edit</option>
                    <option value="3">Export</option>
                </select>
                <button class="btn btn-sm btn-default">Apply</button> --}}
                <p><a href="{{ url('/send-coupon') }}" class="btn btn-default">Gửi giảm giá khách vip</a></p>                
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
            <div class="input-group">
                <input type="text" class="input-sm form-control" placeholder="Search">
                <span class="input-group-btn">
                <button class="btn btn-sm btn-default" type="button">Go!</button>
                </span>
            </div>
            </div>
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
                <th>Tên mã giảm giá</th>
                <th>Mã giảm giá</th>
                <th>Số lượng</th>
                <th>Điều kiện giảm giá</th>
                <th>Số % hoặc tiền giảm</th>
            
                </tr>
            </thead>
            <tbody>
                @foreach($coupon as $key => $cou)
                <tr>
                    <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                    <td>{{ $cou->coupon_name }}</td>
                    <td>{{ $cou->coupon_code }}</td>
                    <td>{{ $cou->coupon_time }}</td>
                    
                    <td><span class="text-ellipsis">
                        <?php
                        if($cou->coupon_condition == 1){
                        ?>
                            Giảm theo %
                        <?php
                        }    
                        else{
                        ?>
                            Giảm theo tiền
                        <?php
                        }
                        ?>
                    </span></td>

                    <td><span class="text-ellipsis">
                        <?php
                        if($cou->coupon_condition == 1){
                        ?>
                            Giảm {{ $cou->coupon_number }}%
                        <?php
                        }    
                        else{
                        ?>
                            Giảm {{ number_format($cou->coupon_number, 0, ',', '.') }} VNĐ
                        <?php
                        }
                        ?>
                    </span></td>
                    
                    <td>
                        {{-- <a href="{{ URL::to('/edit-coupon/'.$cou->coupon_id) }}" class="active styling-edit" ui-toggle-class="">
                            <i class="fa fa-pencil-square-o text-success text-active"></i>
                        </a> --}}
                        <a href="{{ URL::to('/delete-coupon/'.$cou->coupon_id) }}" class="active styling-edit" ui-toggle-class="" onclick="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này không?')">
                            <i class="fa fa-times text-danger text"></i>
                        </a>
                    </td>
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
