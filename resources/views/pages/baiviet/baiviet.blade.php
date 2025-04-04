@extends('welcome')
@section('content')

<div class="features_items"><!--features_items-->
    <h2 class="title text-center">{{ $meta_title }}</h2>
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-left">
                    {!! $post->post_content !!}  
                </div>
            </div>
        </div>
</div><!--features_items-->

@endsection