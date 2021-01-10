<?php

namespace src\lib;

class RamCalculator
{
	const COST_HOURLY = .00553; // 1 GB of RAM
	const STUDY_RAM = .5; // estimated value of RAM per STUDY
	const MB_GB_CONVERSION = 1000; // Assumption 1000MB -> 1GB
	const HRS_DAY = 24; // 24 hrs per day

	/**
	 * @param $month Array [days, name, id] - Represents month
	 * @param $dailStudy Int daily study
	 * @param $growth Float monthly expected studies number growth
	 */
	public function calculateCurrentMonthUsage($month, $dailyStudies, $growth) {
		$days = $month['days'];

		$hourlyStudiesAverage = $dailyStudies * $growth / self::HRS_DAY; 
		$hourlyRamUsage = $hourlyStudiesAverage * self::STUDY_RAM;
		$hourlyCost = $hourlyRamUsage / self::MB_GB_CONVERSION * self::COST_HOURLY;

		//$totalMonthCost = $hourlyCost * $days * self::HRS_DAY; 

		$totalRamUsage = $hourlyRamUsage / self::MB_GB_CONVERSION * $days * self::HRS_DAY; 
		$totalMonthCost = $totalRamUsage * self::COST_HOURLY;
	
		$usage = [
			'cost' => $totalMonthCost,
			'ram' => $totalRamUsage,
			'total_studies' => $dailyStudies * (1 + $growth) * $days
		];

		return $usage;
	}

	/**
	 * @param $months Array [days, id, name] - months that needs to be estimated
	 * @param $dailyStudies Int - estimated daily studies 
	 * @param $growth Float approximated monthly growth
	 *
	 * @return Array [key, name, costs] - key numeric rep of month, name - month's name, cost - month's cost
	 */
	public function calculateMonthlyCost($months, $dailyStudies, $growth) {
		$monthlyCosts = [];

		foreach($months as $month) {
			$monthlyUsage = $this->calculateCurrentMonthUsage($month, $dailyStudies, $growth);
			$monthlyCosts[] = [
				'key' => $month['id'],
				'name' => $month['name'],
				'cost' => $monthlyUsage['cost'],
				'total_studies' => $monthlyUsage['total_studies']
			];
		}

		return $monthlyCosts;
	}
}
