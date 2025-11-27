<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use Gate;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Components\Date;
use App\Http\Controllers\Admin\Traits\ArrayOrderStrait;
use Illuminate\Support\Arr;

class DashboardController
{
    use ArrayOrderStrait;
    private $order;
    public function __construct(Order $order) {
        $this->order = $order;
    }

    public function index(Request $request)
    {
        $orders = Order::count();
        $order_new = Order::where('payment_status', 1)->count();
        $order_pending = Order::where('delivery_status', 1)->count();
        $customers = Customer::count();
    	$posts = Post::count();
        $products = Product::count();
        $params = $request->all();
        $filter_start_date = null;
        $filter_end_date = null;

        // sales
        $dateNow = date('d-m-Y');
        $thisMonth = date("m",strtotime($dateNow));
        $thisYear = date("Y",strtotime($dateNow));
        $totalOrder = 0;
        $allTotalSales = 0;
        $allPendingTotalSales = 0;
        $thisDateOrderTotalSales = 0;
        $thisMonthOrderTotalSales = 0;
        $thisYearOrderTotalSales = 0;
        $orderSalesQuery = Order::selectRaw('IF(SUM(total_price) IS NULL, 0, SUM(total_price)) AS total_prices')
            ->where('payment_status', ORDER_PAYMENT_STATUS_DONE);

        $orderPendingSalesQuery = Order::selectRaw('IF(SUM(total_price) IS NULL, 0, SUM(total_price)) AS total_prices')
            ->where('payment_status', ORDER_PAYMENT_STATUS_PROCESSING);

        $totalOrderQuery = Order::selectRaw('IF(SUM(total_price) IS NULL, 0, SUM(total_price)) AS total_prices');


        // total order
        $totalOrderQuery = clone $totalOrderQuery;
        $allTotalOrder = $totalOrderQuery->first();
        if (!empty($allTotalOrder)) {
            $totalOrder = $allTotalOrder->total_prices;
        }

        // all time
        $allTotalQuery = clone $orderSalesQuery;
        $allTotal = $allTotalQuery->first();
        if (!empty($allTotal)) {
            $allTotalSales = $allTotal->total_prices;
        }

        // pending
        $allPendingTotalQuery = clone $orderPendingSalesQuery;
        $pendingTotal = $allPendingTotalQuery->first();
        if (!empty($pendingTotal)) {
            $allPendingTotalSales = $pendingTotal->total_prices;
        }

        // pie Chart
        $pieChart = [];
        if($totalOrderQuery->count()) {
            $perAllTotal = ceil(($allTotalSales/$totalOrder)*100);
            $perPendingTotal = ceil(($allPendingTotalSales/$totalOrder)*100);

            $pieChart = Arr::add(['0' => $perAllTotal], '1',$perPendingTotal);
        }
        // dd($pieChart);

        // this date
        $thisDateTotalQuery = clone $orderSalesQuery;
        $thisDateTotal = $thisDateTotalQuery->whereDate('created_at', $dateNow)->first();
        if (!empty($thisDateTotal)) {
            $thisDateOrderTotalSales = $thisDateTotal->total_prices;
        }

        // this month
        $thisMonthTotalQuery = clone $orderSalesQuery;
        $thisMonthTotal = $thisMonthTotalQuery
            ->whereYear('created_at', $thisYear)
            ->whereMonth('created_at', $thisMonth)
            ->first();
        if (!empty($thisMonthTotal)) {
            $thisMonthOrderTotalSales = $thisMonthTotal->total_prices;
        }

        // this year
        $thisYearTotalQuery = clone $orderSalesQuery;
        $thisYearTotal = $thisYearTotalQuery
            ->whereYear('created_at', $thisYear)
            ->first();
        if (!empty($thisYearTotal)) {
            $thisYearOrderTotalSales = $thisYearTotal->total_prices;
        }

        $recent_orders = Order::orderBy('id', 'DESC')->take(10)->get();
        $best_seller = Product::orderby('sell', 'DESC')->take(10)->get();

        // Biểu đồ thống kê doanh số bán hàng trong tháng

        if(isset($params['preview'])){
            $preview = $params['preview'];
            switch ($preview) {
                case 'filter_date':
                    $filter_start_date = $params['start_date'];
                    $filter_end_date = $params['end_date'];
                    $dateS = Carbon::parse($filter_start_date)->format('d-m-Y');
                    $dateE = Carbon::parse($filter_end_date)->format('d-m-Y');
                    $listDay = Date::getListDayByRange($dateS, $dateE);
                    break;
                case 'this_week':
                    $week = Carbon::now()->startOfWeek()->subDay(1);
                    $listDay = Date::getListDayInWeek($week);
                    $dateS = Carbon::now()->startOfWeek()->format('d-m-Y');
                    $dateE = Carbon::now()->endOfWeek()->format('d-m-Y');
                break;

                case 'last_week':
                    $week = Carbon::now()->subWeek()->startOfWeek()->subDay(1);
                    $listDay = Date::getListDayInWeek($week);
                    $dateS = Carbon::now()->subWeek()->startOfWeek()->format('d-m-Y');
                    $dateE = Carbon::now()->subWeek()->endOfWeek()->format('d-m-Y');
                break;

                case 'this_month':
                    $this_month = Carbon::now()->month;
                    $listDay = Date::getListDayInMonth($this_month);
                    $dateS = Carbon::now()->startOfMonth()->format('d-m-Y');
                    $dateE = Carbon::now()->endOfMonth()->format('d-m-Y');
                break;

                case 'last_month':
                    $this_month = Carbon::now()->startOfMonth()->subMonth()->format('m');
                    $listDay = Date::getListDayInMonth($this_month);
                    $dateS = Carbon::now()->subMonth()->startOfMonth()->format('d-m-Y');
                    $dateE = Carbon::now()->subMonth()->endOfMonth()->format('d-m-Y');
                break;

            }

            $arrayRevenueOrderMonth = $this->mapRevenueAndCountOrder($listDay, $dateS, $dateE)['arrayRevenueOrderMonth'];
            $arrayCountOrderMonth = $this->mapRevenueAndCountOrder($listDay, $dateS, $dateE)['arrayCountOrderMonth'];

        } else {

            $now = Carbon::now()->startOfWeek()->subDay(1);
            $listDay = Date::getListDayInWeek($now);
            $dateS = Carbon::now()->startOfWeek()->format('d-m-Y');
            $dateE = Carbon::now()->endOfWeek()->format('d-m-Y');
            $arrayRevenueOrderMonth = $this->mapRevenueAndCountOrder($listDay, $dateS, $dateE)['arrayRevenueOrderMonth'];
            $arrayCountOrderMonth = $this->mapRevenueAndCountOrder($listDay, $dateS, $dateE)['arrayCountOrderMonth'];
        }

        return view('admin.dashboard.index', compact(
        	'orders',
            'order_new',
            'order_pending',
        	'customers',
        	'posts',
            'products',
            'allTotalSales',
            'allPendingTotalSales',
            'thisDateOrderTotalSales',
            'thisMonthOrderTotalSales',
            'thisYearOrderTotalSales',
            'recent_orders',
            'best_seller',
            'listDay',
            'arrayRevenueOrderMonth',
            'arrayCountOrderMonth',
            'pieChart',
            'filter_start_date',
            'filter_end_date'
        ));
    }
    public function filter_date (Request $request)
    {

    }
}
