
==============================================================
php artisan config:cache && php artisan cache:clear && php artisan config:clear && php artisan route:cache && composer dump-autoload
php artisan config:cache && php artisan cache:clear && php artisan config:clear && php artisan route:clear && composer dump-autoload

========================================================
php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public
 
php artisan route:clear
php artisan config:clear

php artisan storage:link

================================================================
php artisan migrate
php artisan make:migration create_product_product_color_pivot_table
php artisan make:migration create_variations_table
php artisan make:migration create_order_products_table
php artisan make:migration add_meta_column_to_products_table

php artisan make:model Models/OrderProduct


==================================================Setting Run Project
1. copy .env.example to .env
2. composer install
3. php artisan key:generate
4. create DB
5. php artisan migrate
6. php artisan db:seed
7. php artisan view:clear && php artisan config:cache && php artisan cache:clear && php artisan config:clear && php artisan route:clear && composer dump-autoload


php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public
php artisan storage:link
php artisan route:clear
php artisan config:clear

composer update unisharp/laravel-filemanager
php artisan vendor:publish --tag=lfm_view --force
php artisan vendor:publish --tag=lfm_config --force
php artisan vendor:publish --tag=lfm_public --force
php artisan storage:link

=================================================
Close PHPStorm
Run these in PowerShell to remove PhpStorm configuration:
Remove-Item '.\AppData\Local\Jetbrains\PhpStorm*'
Remove-Item '.\AppData\Roaming\Jetbrains\PhpStorm*'
Remove-Item C:\Users\This PC\.PhpStorm2019.2
Go to your registry editors' path: Computer\HKEY_CURRENT_USER\SOFTWARE\JavaSoft\Prefs\jetbrains\phpstorm
Remove all inner folders.
Relaunch PHPStorm


product_attribute_title: {
	id: 1,
	product_attribute_id: 1,
	name: 1,
}
=====================================================
Documents figma
https://www.figma.com/proto/VTMTnGVVCNAZwhDDYUebC1/LANCI-BRIEF-PROJECT-UX%2FUI-DESIGN?node-id=136%3A902&scaling=scale-down-width&page-id=58%3A2&starting-point-node-id=136%3A902&fbclid=IwAR3vwmUfH-0-yLQgfjm9q71AHz-QGwax5AA9XmhLh8XHUadaRNxXbF6tV2A

Tham khảo
https://hasa.botble.com/admin


ID: 0704400080
Pass: npT@31081992

http://lanci.com.vn/admin


=====================================================================
Chưa thanh toán
Chờ xác nhận
Đã thanh toán
Thanh toán một phần
Hoàn trả một phần
Hoàn trả toàn bộ

Chưa chuyển
Chuyển một phần
Chuyển toàn bộ
	


