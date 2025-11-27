<?php

namespace App\Components;
use Carbon\Carbon;
class Date
{
	Protected $listDay;
	public static function getListDayInMonth($month)
	{
		$arrayDay = [];
		$month = $month;
		$year = date('y');

		// Lấy tất cả các ngày trong tháng

		for($day = 1; $day <= 31 ; $day ++) {
			$time = mktime(12,0,0,$month,$day,$year);
			if (date('m', $time) == $month) {
				$arrayDay[] = date('d-m-Y', $time);
			}
		}

		return $arrayDay;
	}
	public static function getListDayInWeek($week)
	{
		$arrayDay = [];
		$month = Carbon::now()->month;
		$weekS = $week;
		$year = Carbon::now()->year;
		// Lấy tất cả các ngày trong tháng

		for($day = 1; $day <= 7 ; $day ++) {
			$arrayDay[] = $weekS->addDay()->format('d-m-Y');
		}

		return $arrayDay;
	}

	public static function getListDayInYear()
	{
		$arrayDay = [];
		for ($i = 11; $i >= 0; $i--) {
			$month = Carbon::now()->startOfMonth()->subMonth($i);
			$year = Carbon::now()->startOfMonth()->subMonth($i)->format('Y');
			array_push($arrayDay, array(
				'month' => $month->format('M')
			));
		}
		return $arrayDay;

	}

	public static function getListDayByRange($sStartDate, $sEndDate)
	{
        $arrayDay      = [];
        $sStartDate   = Carbon::parse($sStartDate)->format('d-m-Y');
        $sEndDate     = Carbon::parse($sEndDate)->format('d-m-Y');
        $arrayDay[]      = $sStartDate;
        $sCurrentDate = $sStartDate;

        // While the current date is less than the end date
        while(Carbon::parse($sCurrentDate)->lt(Carbon::parse($sEndDate))){
            // Add a day to the current date
            $sCurrentDate = Carbon::parse($sCurrentDate)->addDay()->format('d-m-Y');

            // Add this new day to the aDays array
            $arrayDay[] = $sCurrentDate;
        }

        return $arrayDay;
	}
}
