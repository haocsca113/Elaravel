@extends('welcome')
@section('content')

<div class="features_items"><!--features_items-->
    {{-- <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="" data-size=""><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ $url_canonical }}https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>

    <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="" data-layout="" data-action="" data-size="" data-share="false"></div> --}}

    <div class="fb-like" data-href="{{ $url_canonical }}" data-width="" data-layout="" data-action="" data-size="" data-share="true"></div>

    @foreach($category_name as $key => $name)
    <h2 class="title text-center">{{ $name->category_name }}</h2>
    @endforeach

    <div class="row" style="margin: 10px 0;">
        <div class="col-md-4">
            <label for="amount">Sắp xếp theo</label>
            <form action="">
                @csrf
                <select name="sort" id="sort" class="form-control">
                    <option value="{{ Request::url() }}?sort_by=none">--Lọc theo--</option>
                    <option value="{{ Request::url() }}?sort_by=tang_dan">--Giá tăng dần--</option>
                    <option value="{{ Request::url() }}?sort_by=giam_dan">--Giá giảm dần--</option>
                    <option value="{{ Request::url() }}?sort_by=kytu_az">--A đến Z--</option>
                    <option value="{{ Request::url() }}?sort_by=kytu_za">--Z đến A--</option>
                </select>
            </form>
        </div>

        <div class="col-md-4">
            <label for="amount">Lọc giá theo</label>
            <form action="">
                <div id="slider-range"></div>
                <div class="style-range" style="display: flex;">
                    <input type="text" id="amount_start" readonly="" style="border:0; color:#f6931f; font-weight:bold; padding: 0; margin-top: 5px;">
                    <input type="text" id="amount_end" readonly="" style="border:0; color:#f6931f; font-weight:bold; padding: 0;">
                </div>

                <input type="hidden" name="start_price" id="start_price">
                <input type="hidden" name="end_price" id="end_price">
                
                <input type="submit" name="filter_price" value="Lọc giá" class="btn btn-sm btn-default">
            </form>
        </div>
    </div>

    @foreach($category_by_id as $key => $product)
    <a href="{{ URL::to('/chi-tiet-san-pham/'.$product->product_id) }}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form action="">
                            @csrf
                            <input type="hidden" class="cart_product_id_{{ $product->product_id }}" value="{{ $product->product_id }}">
                            <input type="hidden" class="cart_product_name_{{ $product->product_id }}" value="{{ $product->product_name }}">
                            <input type="hidden" class="cart_product_image_{{ $product->product_id }}" value="{{ $product->product_image }}">
                            <input type="hidden" class="cart_product_price_{{ $product->product_id }}" value="{{ $product->product_price }}">
                            <input type="hidden" class="cart_product_quantity_{{ $product->product_id }}" value="{{ $product->product_quantity }}">
                            <input type="hidden" class="cart_product_qty_{{ $product->product_id }}" value="1">

                            <a href="{{ URL::to('/chi-tiet-san-pham/'.$product->product_id) }}">
                                <img src="{{ URL::to('upload/product/'.$product->product_image) }}" alt="" height="250px" />
                                <h2>{{ number_format($product->product_price, 0, ',', '.').' VNĐ' }}</h2>
                                <p style="height: 40px;">{{ $product->product_name }}</p>
                            </a>
                            <button type="button" class="btn btn-default add-to-cart" data-id="{{ $product->product_id }}" name="add-to-cart">Thêm giỏ hàng</button>
                        </form>
                    </div>
                </div>

                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div><!--features_items-->

<div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width="" data-numposts="5"></div>

<ul class="pagination pagination-sm m-t-none m-b-none">
    {!! $category_by_id->links('pagination::bootstrap-4') !!}
</ul>

@endsection