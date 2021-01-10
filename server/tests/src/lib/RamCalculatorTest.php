<?php

namespace tests\src\lib;

use PHPUnit\Framework\TestCase;

use src\lib\RamCalculator;
use src\helper\Month;

/**
 * 1000 studies -> 500 MB RAM
 * 1 GB RAM -> .00553 / hr
 * Assumption .5 MB RAM per study
 */
class RamCalculatorTest extends TestCase {

	public function testCalculateMonthlyCost() {
		$monthHelper = new Month;
		$months = $monthHelper->getMonths(1,2, 2021);

		$dailyStudies = 1000;
		$growth = .1;

		$calculator = new RamCalculator;
		$monthlyCosts = $calculator->calculateMonthlyCost($months, $dailyStudies, $growth);

		$expected = [[
			'key' => 1,
			'name' => 'January',
			'cost' => 0.0085715,
			'total_studies' => 1000 * 31 * 1.1
		], [
			'key' => 2,
			'name' => 'February',
			'cost' => 0.007742,
			'total_studies' => 1000 * 28 * 1.1
		]];

		$this->assertEquals($expected, $monthlyCosts);
	}

	public function testCalculateCurrentMonthUsage() {
		$monthHelper = new Month;
		$months = $monthHelper->getMonths(1,2, 2021);

		$dailyStudies = 1000;
		$growth = .1;

		$calculator = new RamCalculator;
		$usage = $calculator->calculateCurrentMonthUsage($months[0], $dailyStudies, $growth);

		$this->assertEquals($usage['cost'],0.0085715);
		$this->assertEquals($usage['ram'], 1.55);
		$this->assertEquals($usage['total_studies'], 1100 * 31);

		// realistic approach average daily studies approximate
		// 1100 * .1 / 24 = 4.58333 studies per hour 
		// 4.583333 * .5  = RAM hourly
		// 4.583333 / 1000 = GB usage
		// usage * .00553
		// hourly * 24 * 31 = total usage
	}
}

