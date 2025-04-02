<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Coupon;
use Session;
session_start();

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app("botman");

        $botman->hears("{message}", function ($botman, $message) {
            $message = strtolower(trim($message)); // Chuyển tin nhắn thành chữ thường

            switch ($message) {
                case 'hi':
                case 'hello':
                    $this->askName($botman);
                    break;

                case 'time':
                    $time = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i:s');
                    $botman->reply("⏰ Bây giờ là: $time");
                    break;

                case 'date':
                    $date = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
                    $botman->reply("📅 Hôm nay là: $date");
                    break;

                case 'help':
                    $this->showHelp($botman);
                    break;

                case 'giờ mở cửa':
                    $botman->reply("🕘 Chúng tôi mở cửa từ **8:00 sáng - 10:00 tối** hàng ngày.");
                    break;

                case 'liên hệ':
                    $botman->reply("📞 Bạn có thể gọi **0988820943** hoặc email **haocsca113@gmail.com**.");
                    break;

                case 'mã giảm giá':
                case 'coupon':
                    $this->generateDiscountCode($botman);
                    break;
    
                default:
                    // Kiểm tra nếu khách hàng hỏi về tay cầm
                    if (preg_match('/tay cầm (.*)/', $message, $matches)) {
                        $this->suggestController($botman, $matches[1]);
                        return;
                    }
                    // Kiểm tra nếu khách hàng hỏi về đơn hàng
                    elseif (preg_match('/kiểm tra đơn hàng ([a-zA-Z0-9]+)/i', $message, $matches)) {
                        $this->checkOrder($botman, $matches[1]);
                        return;
                    }
                    else {
                        $botman->reply("❌ Xin lỗi, tôi không hiểu. Gõ **help** để xem danh sách lệnh.");
                    }
                    break;
            }
        });

        $botman->listen();
    }

    // Hỏi tên người dùng
    public function askName($botman)
    {
        $botman->ask("👋 Xin chào! Bạn tên gì?", function (Answer $answer, $botman) {
            $name = $answer->getText();
            $botman->say("🤖 Rất vui được gặp bạn, **$name**!");
        });
    }

    // Hiển thị danh sách lệnh có thể sử dụng
    public function showHelp($botman)
    {
        $helpText = "📜 **Danh sách lệnh hỗ trợ**: <br>";
        $helpText .= "👉 **hi** - Chào hỏi <br>";
        $helpText .= "👉 **time** - Xem giờ hiện tại <br>";
        $helpText .= "👉 **date** - Xem ngày hôm nay <br>";
        $helpText .= "👉 **giờ mở cửa** - Xem giờ làm việc <br>";
        $helpText .= "👉 **liên hệ** - Xem thông tin liên hệ <br>";
        $helpText .= "👉 **mã giảm giá hoặc coupon** - Xem mã giảm giá bạn có <br>";
        $helpText .= "👉 **kiểm tra đơn hàng [mã]** - Kiểm tra tình trạng đơn hàng <br>";
        $helpText .= "👉 **tay cầm [PS4/PS5/Xbox/Vader]** - Gợi ý tay cầm phù hợp <br>";

        $botman->reply($helpText);
    }

    // Gợi ý tay cầm phù hợp
    public function suggestController($botman, $console)
    {
        $console = ucfirst(strtolower($console)); // Chuyển chữ hoa đầu
        $botman->reply("🎮 Chúng tôi có nhiều mẫu tay cầm dành cho **$console**! Bạn có muốn xem danh sách không?");
    }

    // Kiểm tra đơn hàng
    public function checkOrder($botman, $orderCode)
    {
        // Giả lập dữ liệu đơn hàng từ database
        $order = Order::where('order_code', $orderCode)->first();

        if ($order) {
            // Xác định trạng thái đơn hàng trực tiếp
            $statusText = match ((int)$order->order_status) {
                1 => "🟡 Chưa xử lý",
                2 => "✅ Đã xử lý",
                3 => "❌ Đơn hàng đã hủy",
                default => "⚠️ Trạng thái không xác định"
            };
    
            $botman->reply("📦 Đơn hàng **#{$orderCode}** đang trong trạng thái: **{$statusText}**.");
        } else {
            $botman->reply("❌ Không tìm thấy đơn hàng **#{$orderCode}**. Vui lòng kiểm tra lại.");
        }
    }

    // Tạo mã khuyến mãi ngẫu nhiên
    public function generateDiscountCode($botman)
    {
        $customer_id = session()->get('customer_id');
        // $botman->reply("🔍 Customer ID: " . ($customer_id ?? 'Không có'));
      
        if (!$customer_id) {
            $botman->reply("⚠️ Bạn cần đăng nhập để kiểm tra mã giảm giá.");
            return;
        }

        $orders = Order::where('customer_id', $customer_id)
        ->where('order_status', 2)
        ->get();

        $coupons = [];

        foreach ($orders as $order) {
            $total_after = OrderDetails::where('order_code', $order->order_code)
                ->selectRaw('SUM(product_price * product_sales_quantity) as total')
                ->value('total');

            if ($total_after >= 1000000 && $total_after < 3000000) {
                $coupon = Coupon::where('coupon_condition', 2)->first();
            } elseif ($total_after >= 3000000) {
                $coupon = Coupon::where('coupon_condition', 1)->first();
            }

            if (isset($coupon) && !in_array($coupon->coupon_code, $coupons)) {
                $coupons[] = $coupon->coupon_code;
            }
        }

        // Kiểm tra nếu có mã giảm giá
        if (!empty($coupons)) {
            $couponList = implode(", ", $coupons);
            $botman->reply("🎉 Mã giảm giá bạn có: **$couponList**.");
        } else {
            $botman->reply("❌ Bạn chưa có mã giảm giá. Hãy mua hàng để nhận ưu đãi nhé!");
        }
    }
}
