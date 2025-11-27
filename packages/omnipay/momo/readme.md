### Notes

### Run
- composer update
- php artisan cache:clear
- php artisan config:clear

### Copy env
- MOMO_PARTNER_CODE=MOMOBKUN20180529 (key test)
- MOMO_ACCESS_KEY=klm05TvNBzhg7h7j (key test)
- MOMO_SECRET_KEY=at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa (key test)

### Môi trường sử dung test 
- APP_ENV = local thì sử dụng môi trường test thanh toán momo
- APP_ENV = production thì sẽ sử dụng môi trường product để thanh toán momo

### Thực hiện giao dịch lây url 

use Omnipay\Momo\Services\MomoService;

$momo_service = new MomoService();
$response = $momo_service->payConfirm([
	'partnerCode' => env('MOMO_PARTNER_CODE'),
	'amount' => 10000,                        // Tổng tiền cần thanh toán 
	'orderId' => time() ."",                  // Mã hoá đơn - duy nhất
	'orderInfo' => "Thanh toán momo",         // Thông tin đơn hàng
	'redirectUrl' => "http://localhost:8000", // redirec url khi thanh toán thành công
	'ipnUrl' => "http://localhost:8000",      // 
	'extraData' => "",                        // default ""
	'requestType' => 'captureWallet',         // Phương thức thanh tooán default 'captureWallet'
]);

dd($response);

### Kiểm tra giao dịch trước khi update đơn hàng

$momo_service = new MomoService();
$response = $momo_service->ipnCheckSignature($params); // Sử dụng data trả về của function payCofirm

dd($response);

### Kiểm tra trạng thái giao dịch 

$response = $momo_service->queryTransaction([
	'partnerCode' => env('MOMO_PARTNER_CODE'),
	"orderId" => "1667998573"                // Mã đơn hàng - duy nhất
]);

dd($response);
