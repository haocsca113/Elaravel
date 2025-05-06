@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm thông tin website
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
                    @foreach($contact as $key => $val)    
                        <form role="form" action="{{ URL::to('/update-info/'.$val->info_id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thông tin liên hệ</label>
                                <textarea type="text" name="info_contact" class="form-control" style="resize: none;" rows="5" id="ckeditor1" placeholder="">
                                    {{ $val->info_contact }}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Bản đồ</label>
                                <textarea type="text" name="info_map" class="form-control" style="resize: none;" rows="5" id="exampleInputPassword1" placeholder="">
                                    {{ $val->info_map }}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Fanpage</label>
                                <textarea type="text" name="info_fanpage" class="form-control" style="resize: none;" rows="5" id="exampleInputPassword1" placeholder="">
                                    {{ $val->info_fanpage }}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh logo</label>
                                <input type="file" name="info_logo" class="form-control" id="exampleInputEmail1">
                                <img src="{{ URL::to('upload/contact/'.$val->info_logo) }}" alt="" height="100" width="100">
                            </div>
                            
                            <button type="submit" name="add_info" class="btn btn-info">Cập nhật thông tin</button>
                        </form>
                    @endforeach
                </div>
    
            </div>
        </section>
    </div>
</div>
@endsection
