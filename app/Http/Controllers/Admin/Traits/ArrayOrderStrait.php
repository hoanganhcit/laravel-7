<?php

namespace App\Http\Controllers\Admin\Traits;

use Storage;
use Session;
use App\Models\Order;
use Carbon\Carbon;

trait ArrayOrderStrait
{

    public function mapRevenueAndCountOrder($listDay, $dateS, $dateE)
    {
        \DB::enableQueryLog();
        $revenueOrderMonthQuery = Order::selectRaw('sum(total_price) as total_price, count(id) as count_order, DATE_FORMAT(created_at, "%d-%m-%Y") as created_at_tmp')
            ->where('payment_status', ORDER_PAYMENT_STATUS_DONE);

        if (!is_null($dateS)) {
            $revenueOrderMonthQuery->whereDate('created_at', '>=', Carbon::parse($dateS)->toDateString());
        }
        if (!is_null($dateE)) {
            $revenueOrderMonthQuery->whereDate('created_at', '<=', Carbon::parse($dateE)->toDateString());
        }

        $revenueOrderMonth = $revenueOrderMonthQuery
            ->groupBy('created_at_tmp')
            ->get();

        $arrayRevenueOrderMonth = [];
        $arrayCountOrderMonth = [];
        foreach ($listDay as $day) {
            $total = 0;
            $count = 0;
            foreach ($revenueOrderMonth as $key => $revenue) {
                if ($revenue['created_at_tmp'] == $day) {
                    $total = $revenue['total_price'];
                    $count = $revenue['count_order'];
                    break;
                }
            }

            $arrayRevenueOrderMonth[] = (float)$total;
            $arrayCountOrderMonth[] = (int)$count;

        }
        return [
            'arrayRevenueOrderMonth' => $arrayRevenueOrderMonth,
            'arrayCountOrderMonth' => $arrayCountOrderMonth
        ];
    }
}
