### Notes

### Run
- composer update
- php artisan view:clear && php artisan config:cache && php artisan cache:clear && php artisan config:clear && php artisan route:clear && composer dump-autoload

### Copy env
VNP_TMN_CODE=KBEBUTFW
VNP_HASH_SECRET=YDZSYPYWZOVWSTDIUQFSLUEPHULHTMGY
VNP_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html

### Môi trường sử dung test 
- APP_ENV = local thì sử dụng môi trường test thanh toán
- APP_ENV = production thì sẽ sử dụng môi trường product để thanh toán

### Thực hiện giao dịch lây url 

use Bigzvnpay\Services\VnpayService;

$vnpayService = new VnpayService();

        $vnpUrl = $this->vnpayService->getVnpUrlConfirm([
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => env('VNP_TMN_CODE'), //Mã website tại VNPAY
            "vnp_Amount" => $request->total_vnpay * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'] ?? '',
            "vnp_Locale" => $request->language ?? '',
            "vnp_OrderInfo" => $request->OrderDescription ?? '',
            "vnp_OrderType" => $request->ordertype ?? '',
            "vnp_ReturnUrl" => env('APP_URL') . "/vnpay-return",
            "vnp_BankCode" => $request->bankcode ?? '',
            "vnp_TxnRef" => $orderId,
        ]);

dd($vnpUrl);

# Thông tin thẻ demo
Thông tin thẻ	Ghi chú
1	Thành công
Ngân hàng: NCB
Số thẻ: 9704198526191432198
Tên chủ thẻ:NGUYEN VAN A
Ngày phát hành:07/15
Mật khẩu OTP:123456


2	Thẻ không đủ số dư
Ngân hàng: NCB
Số thẻ: 9704195798459170488
Tên chủ thẻ:NGUYEN VAN A
Ngày phát hành:07/15

3	Thẻ chưa kích hoạt
Ngân hàng: NCB
Số thẻ: 9704192181368742
Tên chủ thẻ:NGUYEN VAN A
Ngày phát hành:07/15

4	Thẻ bị khóa
Ngân hàng: NCB
Số thẻ: 9704193370791314
Tên chủ thẻ:NGUYEN VAN A
Ngày phát hành:07/15

5	Thẻ bị hết hạn
Ngân hàng: NCB
Số thẻ: 9704194841945513
Tên chủ thẻ:NGUYEN VAN A
Ngày phát hành:07/15

6	Thành công
Loại thẻ quốc tếVISA (No 3DS)
Số thẻ: 4456530000001005
CVC/CVV: 123
Tên chủ thẻ:NGUYEN VAN A
Ngày hết hạn:12/23
Email:test@gmail.com
Địa chỉ:22 Lang Ha
Thành phố:Ha Noi

