@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm vận chuyển
            </header>
            <div class="panel-body">
                <?php
                    $message = Session::get('message');
                    if($message)
                    {
                        echo '<span class="text-alert" style="color: red; width: 100%; text-align: center;">'.$message.'</span>';
                        Session::put('message', null);
                    }
                ?>
                <div class="position-center">
                    <form>
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn thành phố</label>
                            <select id="city" name="city" class="form-control input-sm m-bot15 choose city">
                                <option value="0">--------Chọn tỉnh thành phố--------</option>
                                @foreach($city as $key => $ci)
                                    <option value="{{ $ci->matp }}">{{ $ci->name_city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn quận huyện</label>
                            <select id="province" name="province" class="form-control input-sm m-bot15 choose province">
                                <option value="0">--------Chọn quận huyện--------</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Chọn xã phường</label>
                            <select id="ward" name="ward" class="form-control input-sm m-bot15 ward">
                                <option value="0">--------Chọn xã phường--------</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Phí vận chuyển</label>
                            <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1" placeholder="Nhập phí vận chuyển">
                        </div>
                        
                        <button type="button" name="add_delivery" class="btn btn-info add_delivery">Thêm phí vận chuyển</button>
                    </form>
                </div>

                <div id="load_delivery" style="margin-top: 20px;">

                </div>
    
            </div>
        </section>
    </div>
</div>
@endsection
