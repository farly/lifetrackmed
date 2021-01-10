<?php

namespace src\helper;


class Month
{
  /**
   * or use \DateTime to accurate get days and easier formatting
   */
  private $months = [
    [
      'id' => 1,
      'name' => 'January',
      'days' => 31
    ], [
      'id' => 2,
      'name' => 'February',
      'days' => 28
    ], [
      'id' => 3,
      'name' => 'March',
      'days' => 31
    ],[
      'id' => 4,
      'name' => 'April',
      'days' => 30
    ],[
      'id' => 5,
      'name' => 'May',
      'days' => 31
    ],[
      'id' => 6,
      'name' => 'June',
      'days' => 30
    ],[
      'id' => 7,
      'name' => 'July',
      'days' => 31
    ],[
      'id' => 8,
      'name' => 'August',
      'days' => 31
    ],[
      'id' => 9,
      'name' => 'September',
      'days' => 30
    ],[
      'id' => 10,
      'name' => 'October',
      'days' => 31
    ],[
      'id' => 11,
      'name' => 'November',
      'days' => 30
    ],[
      'id' => 12,
      'name' => 'December',
      'days' => 31
    ],
  ];


  /**
   * @param $month numeric reprensation of months 1-12 , Jan - Dec
   */
  public function getMonthInformation($month, $year) {
    foreach($this->months as $monthInfo) {
      if ($monthInfo['id'] === $month) { 
				if ($month === 2 && Year::isLeapYear($year)) {
					$monthInfo['days']++;
				}
        return $monthInfo;
			}
    }

    throw new \Exception('Not supported');
  }

  /**
   * @params $start start of range , numeric rep of month
   * @params $end end of range, numeric rep of month
   */
  public function getMonths($start, $end, $year) {
    $months = [];

    $i = $start;
    while($i <= $end) {
      $month = $this->getMonthInformation($i, $year);
      $months[] = $month;
      $i++;
    }
    
    return $months;
  }
}
