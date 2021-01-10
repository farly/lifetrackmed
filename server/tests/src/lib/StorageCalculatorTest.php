<?php

namespace tests\src\lib;

use PHPUnit\Framework\TestCase;

use src\lib\StorageCalculator;
use src\helper\Month;

class StorageCalculatorTest extends TestCase
{
  public function testCalculate() {
    $monthHelper = new Month;
    $months = $monthHelper->getMonths(1,2, 2021);
    $dailyStudy = 100;
    $growth = .1;
    // 2 months
    // growth 10%
    // dailyStudy
    // cost 1GB -> 0.10
    // 1 study 10MB
    // assume base 10 conversion

    // per day 1GB
    // 1GB -> 1000MB -> 100 studies
    // 10%
    
    // January -> 31 GB + 10% -> 34.1 GB
    // Febuary -> 28 GB + 10% -> 30.8 GB + 34.1 (previous) -> 64.9
    // Total -> 34.1 + 64.9 -> 95.0 GB 
    // Cost -> 99 * .1 -> 9.9 USD

    $storageCalculator = new StorageCalculator();
    $amount = $storageCalculator->calculate($months, $dailyStudy, $growth);

    $this->assertEquals($amount, 9.9);
  }

  public function testMonthlyCost() {
    $monthHelper = new Month;
    $months = $monthHelper->getMonths(1,2, 2021);
    $dailyStudy = 100;
    $growth = .1;

    $expected = [
      [
        'name' => 'January',
				'cost' => 3.41,
				'key' => 1,
				'total_studies' => 110 * 31 
      ],
      [
        'name' => 'February',
				'cost' => 6.49,
				'key' => 2,
				'total_studies' => 110 * 28
      ]
    ];

    $calculator = new StorageCalculator;
    $costs = $calculator->calculateMonthlyCost($months, $dailyStudy, $growth);

    $this->assertEquals($expected, $costs);
  }
}
