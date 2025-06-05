<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Post;
use App\Models\Order;
use App\Models\Video;
use App\Models\Customer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function($view){
            $min_price = Product::min('product_price');
            $max_price = Product::max('product_price');
            $min_price_range = $min_price + 100000;
            $max_price_range = $max_price + 1000000;

            $product_count = Product::all()->count();
            $post_count = Post::all()->count();
            $order_count = Order::all()->count();
            $video_count = Video::all()->count();
            $customer_count = Customer::all()->count();

            $view->with('min_price', $min_price)->with('max_price', $max_price)->with('min_price_range', $min_price_range)->with('max_price_range', $max_price_range)->with('product_count', $product_count)->with('post_count', $post_count)->with('order_count', $order_count)->with('video_count', $video_count)->with('customer_count', $customer_count);
        });
    }
}
