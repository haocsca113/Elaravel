<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\GalleryController;

// Frontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);
Route::post('/send-chat', [HomeController::class, 'send_chat']);
Route::post('/send-chat-gemini', [HomeController::class, 'send_chat_gemini']);
Route::get('/contact-us', [HomeController::class, 'contact_us']);
Route::get('/buying-guide', [HomeController::class, 'buying_guide']);

// Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProduct::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_id}', [BrandProduct::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detail_product']);

// Backend
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);

// Category Post
Route::get('/add-category-post', [CategoryPostController::class, 'add_category_post']);
Route::get('/all-category-post', [CategoryPostController::class, 'all_category_post']);
Route::get('/edit-category-post/{cate_post_id}', [CategoryPostController::class, 'edit_category_post']);
Route::get('/delete-category-post/{cate_post_id}', [CategoryPostController::class, 'delete_category_post']);
Route::post('/update-category-post/{cate_post_id}', [CategoryPostController::class, 'update_category_post']);
Route::post('/save-category-post', [CategoryPostController::class, 'save_category_post']);
Route::get('/unactive-cate-post/{cate_post_id}', [CategoryPostController::class, 'unactive_cate_post']);
Route::get('/active-cate-post/{cate_post_id}', [CategoryPostController::class, 'active_cate_post']);
Route::get('/danh-muc-bai-viet/{cate_post_slug}', [CategoryPostController::class, 'danh_muc_bai_viet']);

// Post
Route::get('/add-post', [PostController::class, 'add_post']);
Route::get('/all-post', [PostController::class, 'all_post']);
Route::post('/save-post', [PostController::class, 'save_post']);
Route::get('/unactive-post/{post_id}', [PostController::class, 'unactive_post']);
Route::get('/active-post/{post_id}', [PostController::class, 'active_post']);
Route::get('/edit-post/{post_id}', [PostController::class, 'edit_post']);
Route::post('/update-post/{post_id}', [PostController::class, 'update_post']);
Route::get('/delete-post/{post_id}', [PostController::class, 'delete_post']);
Route::get('/bai-viet/{post_slug}', [PostController::class, 'bai_viet']);

// Category Product
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);

Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);

Route::post('/import-csv', [CategoryProduct::class, 'import_csv']);
Route::post('/export-csv', [CategoryProduct::class, 'export_csv']);


// Brand Product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);

Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);


// Product
Route::group(['middleware' => 'auth.roles'], function(){
    Route::get('/add-product', [ProductController::class, 'add_product']);
    Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
});
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);

Route::get('/all-product', [ProductController::class, 'all_product']);

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);

Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);

Route::post('/import-csv-product', [ProductController::class, 'import_csv_product']);
Route::post('/export-csv-product', [ProductController::class, 'export_csv_product']);

// Cart
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_to_cart']);
Route::get('/delete-cart-product/{session_id}', [CartController::class, 'delete_cart_product']);
Route::get('/delete-all-cart-product', [CartController::class, 'delete_all_cart_product']);
Route::post('/update-cart-quantity', [CartController::class, 'update_cart_quantity']);
Route::post('/update-cart', [CartController::class, 'update_cart']);
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
Route::get('/gio-hang', [CartController::class, 'gio_hang']);

// Coupon
Route::post('/check-coupon', [CartController::class, 'check_coupon']);
Route::get('/insert-coupon', [CouponController::class, 'insert_coupon']);
Route::get('/list-coupon', [CouponController::class, 'list_coupon']);
Route::post('/insert-coupon-code', [CouponController::class, 'insert_coupon_code']);
Route::get('/delete-coupon/{coupon_id}', [CouponController::class, 'delete_coupon']);
Route::get('/delete-cart-coupon', [CouponController::class, 'delete_cart_coupon']);

// Checkout
Route::get('/del-fee', [CheckoutController::class, 'del_fee']);
Route::post('/calculate-fee', [CheckoutController::class, 'calculate_fee']);
Route::post('/select-delivery-home', [CheckoutController::class, 'select_delivery_home']);
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::post('/login-checkout-customer', [CheckoutController::class, 'login_checkout_customer']);
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);
Route::post('/confirm-order', [CheckoutController::class, 'confirm_order']);

Route::get('/payment-info', [CheckoutController::class, 'payment_info']);

// Cong thanh toan
Route::post('/vnpay-payment', [CheckoutController::class, 'vnpay_payment']);
Route::post('/momo-payment', [CheckoutController::class, 'momo_payment']);

// Trang thanh toan vnpay & momo
Route::get('/vnpay-online-payment', [CheckoutController::class, 'vnpay_online_payment']);
Route::get('/momo-online-payment', [CheckoutController::class, 'momo_online_payment']);

// Order
// Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
// Route::get('/view-order/{orderId}', [CheckoutController::class, 'view_order']);
// Route::get('/delete-order/{orderId}', [CheckoutController::class, 'delete_order']);

Route::get('/delete-order/{order_code}', [OrderController::class, 'delete_order']);
Route::get('/manage-order2', [OrderController::class, 'manage_order2']);
Route::get('/view-order/{order_code}', [OrderController::class, 'view_order']);
Route::get('/print-order/{checkout_code}', [OrderController::class, 'print_order']);
Route::post('/update-order-qty', [OrderController::class, 'update_order_qty']);
Route::post('/update-qty', [OrderController::class, 'update_qty']);

Route::get('/my-order', [OrderController::class, 'my_order']);
Route::get('/my-order-detail/{order_code}', [OrderController::class, 'my_order_detail']);
Route::get('/order-tracking', [OrderController::class, 'order_tracking']);
Route::post('/cancel-order/{order_code}', [OrderController::class, 'cancel_order']);

// Send mail
Route::get('/send-mail', [HomeController::class, 'send_mail']);

//Login facebook
Route::get('/login-facebook', [AdminController::class, 'login_facebook']);
Route::get('/admin/callback', [AdminController::class, 'callback_facebook']);

//Login google
Route::get('/login-google', [AdminController::class, 'login_google']);
Route::get('/google/callback', [AdminController::class, 'callback_google']);

// Delivery
Route::get('/delivery', [DeliveryController::class, 'delivery']);
Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery', [DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship', [DeliveryController::class, 'select_feeship']); 
Route::post('/update-delivery', [DeliveryController::class, 'update_delivery']);

// Banner
Route::get('/manage-banner', [BannerController::class, 'manage_banner']);
Route::get('/add-banner', [BannerController::class, 'add_banner']);
Route::post('/save-banner', [BannerController::class, 'save_banner']);
Route::get('/unactive-banner/{banner_id}', [BannerController::class, 'unactive_banner']);
Route::get('/active-banner/{banner_id}', [BannerController::class, 'active_banner']);

// Authentication roles
Route::get('/register-auth', [AuthController::class, 'register_auth']);
Route::get('/login-auth', [AuthController::class, 'login_auth']);
Route::get('/logout-auth', [AuthController::class, 'logout_auth']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// User
Route::get('/users', [UserController::class, 'index'])->middleware('auth.roles')->middleware('impersonate');
Route::get('/add-users', [UserController::class, 'add_users'])->middleware('auth.roles');
Route::post('/assign-roles', [UserController::class, 'assign_roles'])->middleware('auth.roles');
Route::post('/store-users', [UserController::class, 'store_users'])->middleware('auth.roles');
Route::get('/delete-user-roles/{admin_id}', [UserController::class, 'delete_user_roles'])->middleware('auth.roles');
Route::get('/impersonate/{admin_id}', [UserController::class, 'impersonate'])->middleware('impersonate');
Route::get('/impersonate-destroy', [UserController::class, 'impersonate_destroy'])->middleware('impersonate');

// Chatbot
Route::match(['get', 'post'], 'botman', [BotManController::class, 'handle']);

// Gallery
Route::get('/add-gallery/{product_id}', [GalleryController::class, 'add_gallery']);
Route::post('/select-gallery', [GalleryController::class, 'select_gallery']);
Route::post('/insert-gallery/{pro_id}', [GalleryController::class, 'insert_gallery']);











