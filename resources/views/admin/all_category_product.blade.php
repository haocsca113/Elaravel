@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê danh mục sản phẩm
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
            <table class="table table-striped b-t b-light" id="myTable">
                <thead>
                    <tr>
                    <th style="width:20px;">
                        <label class="i-checks m-b-none">
                        <input type="checkbox"><i></i>
                        </label>
                    </th>
                    <th>Tên danh mục</th>
                    <th>Hiển thị</th>
                    <th style="width:30px;"></th>
                    </tr>
                </thead>

                <style>
                    #category_order .ui-state-highlight
                    {
                        padding: 24px;
                        background-color: #ffffcc;
                        border: 1px dotted #ccc;
                        cursor: move;
                        margin-top: 12px;
                    }
                </style>
                <tbody id="category_order">
                    @foreach($all_category_product as $key => $cate_pro)
                    <tr id="{{ $cate_pro->category_id }}">
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{ $cate_pro->category_name }}</td>
                        <td><span class="text-ellipsis">
                            <?php
                            if($cate_pro->category_status == 0)
                            {
                            ?>
                                <a href="{{ URL::to('/active-category-product/'.$cate_pro->category_id) }}">
                                    <span class="fa-thumb-styling fa fa-thumbs-down"></span>
                                </a>
                            <?php
                            }
                            else
                            {
                            ?>
                                <a href="{{ URL::to('/unactive-category-product/'.$cate_pro->category_id) }}">
                                    <span class="fa-thumb-styling fa fa-thumbs-up"></span>
                                </a>
                            <?php
                            }
                            ?>
                        </span></td>
                        <td>
                            <a href="{{ URL::to('/edit-category-product/'.$cate_pro->category_id) }}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                            <a href="{{ URL::to('/delete-category-product/'.$cate_pro->category_id) }}" class="active styling-edit" ui-toggle-class="" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục sản phẩm này không?')">
                                <i class="fa fa-times text-danger text"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Import data --}}
            <form action="{{ url('import-csv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id="" accept=".xlsx">
                <br>
                <input type="submit" value="Import file excel" name="import_csv" class="btn btn-warning">
            </form>

            {{-- Export data --}}
            <form action="{{ url('export-csv') }}" method="POST">
                @csrf
                <input type="submit" value="Export file excel" name="export_csv" class="btn btn-success">
            </form>
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
