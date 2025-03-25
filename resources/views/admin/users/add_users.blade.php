@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm user
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
                    <form role="form" action="{{ URL::to('/store-users') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên user</label>
                            <input type="text" name="admin_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên user">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" name="admin_email" class="form-control" id="exampleInputEmail1" placeholder="Nhập email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="text" name="admin_phone" class="form-control" id="exampleInputEmail1" placeholder="Nhập Phone">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="text" name="admin_password" class="form-control" id="exampleInputEmail1" placeholder="Nhập Password">
                        </div>
                        
                        <button type="submit" name="add_users" class="btn btn-info">Thêm user</button>
                    </form>
                </div>
    
            </div>
        </section>
    </div>
</div>
@endsection
