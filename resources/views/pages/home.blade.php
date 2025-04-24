@extends('welcome')
@section('content')

<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Sản phẩm mới nhất</h2>
    @foreach($all_product as $key => $product)
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

                            <style>
                                .xemnhanh {
                                    background: #F5F5ED;
                                    border: 0 none;
                                    border-radius: 0;
                                    color: #696763;
                                    font-family: 'Roboto', sans-serif;
                                    font-size: 15px;
                                    margin-bottom: 25px;
                                }
                            </style>
                            <button type="button" data-toggle="modal" data-target="#xemnhanh" class="btn btn-default xemnhanh" data-id_product="{{ $product->product_id }}" name="xemnhanh">Xem nhanh</button>
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
    @endforeach
</div><!--features_items-->

<!-- Modal -->
<div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title product_quickview_title" id="">
            <span id="product_quickview_title"></span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-5">
                <span id="product_quickview_image"></span>
                <span id="product_quickview_gallery"></span>
            </div>

            <form action="">
                @csrf
                <div id="product_quickview_value"></div>
                <div class="col-md-7">
                    <style>
                        h5.modal-title.product_quickview_title
                        {
                            text-align: center;
                            font-size: 25px;
                            color: brown;
                        }
                        p.quickview
                        {
                            font-size: 14px;
                            color: brown;
                        }
                        span#product_quickview_content img
                        {
                            width: 100%;
                        }
    
                        @media screen and (min-width: 768px)
                        {
                            .modal-dialog
                            {
                                width: 700px;
                            }
                            .modal-sm
                            {
                                width: 350px;
                            }
                        }
                        @media screen and (min-width: 992px)
                        {
                            .modal-lg
                            {
                                width: 1200px;
                            }
                        }
                    </style>
    
                    <h2 class="quickview">
                        <span id="product_quickview_title"></span>
                    </h2>
                    <p>Mã ID: <span id="product_quickview_id"></span></p>
    
                    <span>
                        <h2 style="color: #FE980F; font-size: 20px;">Giá sản phẩm: <span id="product_quickview_price"></span></h2><br>
    
                        <label>Số lượng:</label>
                        <input type="number" name="qty" min="1" class="cart_product_qty_" value="1">
                        <input type="hidden" name="productid_hidden" value="">
                    </span>
                    <br>
    
                    <p class="quickview" style="font-size: 20px; margin: 10px 0;">Mô tả sản phẩm</p>
                    <fieldset>
                        <span style="width: 100%;" id="product_quickview_desc"></span><hr>
                        <span style="width: 100%;" id="product_quickview_content"></span>
                    </fieldset>
    
                    <div id="product_quickview_button"></div>
                    <div id="beforesend_quickview"></div>
                </div>
            </form>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          <button type="button" class="btn btn-default redirect-cart">Đi tới giỏ hàng</button>
        </div>
      </div>
    </div>
</div>
<!-- End Modal -->

<ul class="pagination pagination-sm m-t-none m-b-none">
    {!! $all_product->links('pagination::bootstrap-4') !!}
</ul>

@endsection