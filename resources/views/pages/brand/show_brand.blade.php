@extends('welcome')
@section('content')

<div class="features_items"><!--features_items-->
    @foreach($brand_name as $key => $name)
    <h2 class="title text-center">{{ $name->brand_name }}</h2>
    @endforeach
    
    @foreach($brand_by_id as $key => $product)
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

@endsection