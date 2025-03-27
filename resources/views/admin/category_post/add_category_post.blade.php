@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục bài viết
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
                    <form role="form" action="{{ url('/save-category-post') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục bài viết</label>
                            <input type="text" name="cate_post_name" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Nhập tên danh mục bài viết">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="cate_post_slug" class="form-control" id="convert_slug" placeholder="Slug">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục bài viết</label>
                            <textarea type="text" name="cate_post_desc" class="form-control" style="resize: none;" rows="5" id="exampleInputPassword1" placeholder="Nhập mô tả danh mục bài viết">
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="cate_post_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>

                        <button type="submit" name="add_cate_post" class="btn btn-info">Thêm danh mục bài viết</button>
                    </form>
                </div>
    
            </div>
        </section>
    </div>
</div>
@endsection
