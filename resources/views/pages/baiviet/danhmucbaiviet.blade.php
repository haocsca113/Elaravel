@extends('welcome')
@section('content')

<div class="features_items"><!--features_items-->
    <h2 class="title text-center">{{ $meta_title }}</h2>
    @foreach($post as $key => $p)
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <form action="">
                        @csrf
                        <img src="{{ asset('upload/post/'.$p->post_image) }}" alt="{{ $p->post_slug }}" style="float: left; width: 30%; height: 175px; padding-bottom: 5px;" />
                        <h4 style="height: 40px; color: #000;">{{ $p->post_title }}</h4>
                        <p>{!! $p->post_desc !!}</p>

                        <a href="{{ url('/bai-viet/'.$p->post_slug) }}" class="btn btn-warning btn-sm">
                            Xem bài viết
                        </a>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div><!--features_items-->

<ul class="pagination pagination-sm m-t-none m-b-none">
    {!! $post->links('pagination::bootstrap-4') !!}
</ul>

@endsection