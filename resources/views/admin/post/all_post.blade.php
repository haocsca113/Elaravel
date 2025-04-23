@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê vài viết
        </div>

        {{-- <div class="row w3-res-tb">
            <div class="col-sm-5 m-b-xs">
            <select class="input-sm form-control w-sm inline v-middle">
                <option value="0">Bulk action</option>
                <option value="1">Delete selected</option>
                <option value="2">Bulk edit</option>
                <option value="3">Export</option>
            </select>
            <button class="btn btn-sm btn-default">Apply</button>                
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
        </div> --}}

        <div class="table-responsive">
            <?php
                $message = Session::get('message');
                if($message)
                {
                    echo '<span class="text-alert" style="color: red; width: 100%; text-align: center;">'.$message.'</span>';
                    Session::put('message', null);
                }
            ?>
            <table class="table table-striped b-t b-light" id="myTable">
                <thead>
                    <tr>
                    <th style="width:20px;">
                        <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                        </label>
                    </th>
                    <th>Tên bài viết</th>
                    <th>Slug</th>
                    <th>Hình ảnh</th>
                    <th>Mô tả bài viết</th>
                    <th>Nội dung bài viết</th>
                    <th>Từ khóa bài viết</th>
                    <th>Danh mục bài viết</th>
                    <th>Hiển thị</th>
                    <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_post as $key => $post)
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{ Str::limit($post->post_title, 100, '...') }}</td>
                        <td>{{ $post->post_slug }}</td>
                        <td><img src="{{ asset('upload/post/'.$post->post_image) }}" height="100" width="100" alt=""></td>
                        <td>{{ Str::limit($post->post_desc, 100, '...') }}</td>
                        <td>{!! Str::limit($post->post_content, 100, '...') !!}</td>
                        <td>{{ $post->post_meta_keywords }}</td>
                        <td>{{ $post->cate_post->cate_post_name }}</td>

                        <td><span class="text-ellipsis">
                            <?php
                            if($post->post_status == 0)
                            {
                            ?>
                                <a href="{{ URL::to('/active-post/'.$post->post_id) }}">
                                    <span class="fa-thumb-styling fa fa-thumbs-down"></span>
                                </a>
                            <?php
                            }
                            else
                            {
                            ?>
                                <a href="{{ URL::to('/unactive-post/'.$post->post_id) }}">
                                    <span class="fa-thumb-styling fa fa-thumbs-up"></span>
                                </a>
                            <?php
                            }
                            ?>
                        </span></td>
                        <td>
                            <a href="{{ URL::to('/edit-post/'.$post->post_id) }}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                            <a href="{{ URL::to('/delete-post/'.$post->post_id) }}" class="active styling-edit" ui-toggle-class="" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
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
                    {!! $all_post->links('pagination::bootstrap-4') !!}
                </ul>
            </div>
            </div>
        </footer> --}}
    </div>
</div>
@endsection
