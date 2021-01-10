<?php

namespace src\lib;

class StorageCalculator
{
  const COST_PER_GB = .1;
  const GB_MB_CONVERSION = 1000; // assume base 10
  const MB_PER_STUDY = 10;
  /**
   * @param $months months information, name, number of days
   * @param $dailyStudy monthly study 
   * @param $growthy $monthly $growth
   */
  public function calculate($months, $dailyStudy, $growth) {
    $previousStorage = 0;
    $cost = 0;
    // since storage is accumulated
    foreach($months as $month) {
      $days = $month['days'];

      $totalStudies = $days * $dailyStudy;
      $totalStudies += ($growth * $totalStudies);
      $totalSize = ($totalStudies * self::MB_PER_STUDY + $previousStorage);

      $previousStorage = $totalSize;

      $cost += $totalSize / self::GB_MB_CONVERSION * self::COST_PER_GB;
    }

    return $cost;
  }

  public function calculateMonthlyCost($months, $dailyStudies, $growth) {
    $previousStorage = 0;
    $costs = [];
    // since storage is accumulated
    foreach($months as $month) {
      $days = $month['days'];
      $name = $month['name'];
      $totalStudies = $days * $dailyStudies;
      $totalStudies += ($growth * $totalStudies);
      $totalSize = ($totalStudies * self::MB_PER_STUDY + $previousStorage);

      $previousStorage = $totalSize;

      $cost = $totalSize / self::GB_MB_CONVERSION * self::COST_PER_GB;
      $costs[] = [
        'name' => $name,
				'cost' => $cost,
				'key' => $month['id'],
				'total_studies' => $dailyStudies * $days * (1 + $growth)
      ];
    }

    return $costs;
  }
}
