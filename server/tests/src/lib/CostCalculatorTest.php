<?php

namespace tests\src\lib;

use PHPUnit\Framework\TestCase;

use src\lib\CostCalculator;
use src\lib\RamCalculator;
use src\lib\StorageCalculator;

use src\helper\Month as MonthHelper;


class CostCalculatorTest extends TestCase {
	public function testProject() {
		
		$calculator = new CostCalculator(new MonthHelper);
		$calculator->setDependency(new RamCalculator, new StorageCalculator);
		$projections = $calculator->getMonthlyProjections(1,2,2021,1000, .1);
		
		$month = [[
			'key' => 1,
			'name' => 'January',
			'ram' =>  0.0085715,
			'disk' => 34.1,
			'total' => 34.1085715,
			'total_studies' => 1100 * 31,
			'year' => 2021
		], [
			'key' => 2,
			'name' => 'February',
			'ram' => 0.007742,
			'disk' => 64.9,
			'total' => 64.907742,
			'total_studies' => 1100 * 28,
			'year' => 2021
		]];

		$expected = [
			'monthly' => $month,
			'total' => 99.0163135
		];	

		$this->assertEquals($expected, $projections);
	}
}
