<?php

namespace src\lib;

use src\helper\Month as MonthHelper;

class CostCalculator
{

	public function __construct(MonthHelper $monthHelper) {
		$this->monthHelper = $monthHelper;
	}

	public function setDependency(RamCalculator $ramCalculator, StorageCalculator $storageCalculator) {
		$this->ramCalculator = $ramCalculator;
		$this->storageCalculator = $storageCalculator;
	}

  /**
   * @param $startMonth Int start month 
   * @param $endMonth Int end month 
	 * @param $year Int 
   * @param $growth Float monthly study growth
   * @param $dailyStudy Int daily study 
	 *
	 * @return $monthCosts Array of [ram, disk, name, key, total] 
   */
  public function getMonthlyProjections($startMonth, $endMonth,$year, $dailyStudies, $growth) {

		$months = $this->monthHelper->getMonths($startMonth, $endMonth, $year);

		$monthlyStorageCosts = $this->storageCalculator->calculateMonthlyCost($months, $dailyStudies, $growth);
		$monthlyRamCosts = $this->ramCalculator->calculateMonthlyCost($months, $dailyStudies, $growth);

		$total = 0;

		// assume ordered.. 1-12
		foreach($monthlyStorageCosts as $key => $monthlyStorageCost) {
			$monthlyRamCost = $monthlyRamCosts[$key];

			$ramCost = $monthlyRamCost['cost'];
			$diskCost = $monthlyStorageCost['cost'];

			$total += ($ramCost + $diskCost);

			$monthlyCosts[] = [
				'ram' => $ramCost, 
				'key' => $monthlyRamCost['key'],
				'name' => $monthlyRamCost['name'],
				'disk' => $diskCost,
				'total' => $ramCost + $diskCost,
				'total_studies' => $monthlyRamCost['total_studies'], // either ramcost or storage will do
				'year' => $year
			];	
		}

		return [
			'monthly' => $monthlyCosts,
			'total' => $total
		];
  }
}
