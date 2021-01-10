<?php

namespace tests\src\helper;

use PHPUnit\Framework\TestCase;

use src\helper\Month;

class MonthTest extends TestCase
{

  public function testGetMonth(){
    $monthHelper = new Month();

    $month = $monthHelper->getMonthInformation(1, 2021);

    // tests January
    $this->assertEquals(1,$month['id']);
    $this->assertEquals('January', $month['name']);
    $this->assertEquals(31, $month['days']);


    // tests non supported
    $this->expectException("Exception");
    $this->expectExceptionMessage('Not supported');
    $month = $monthHelper->getMonthInformation(0, 2020);

    // add more tests here
  }
	
	public function testGetMonthOnLeapYear() {
		$monthHelper = new Month;

		$month = $monthHelper->getMonthInformation(2, 2020);
		$this->assertEquals(2, $month['id']);
		$this->assertEquals('February', $month['name']);
		$this->assertEquals(29, $month['days']);
	}

  public function testGetMonthRange() {
    $monthHelper = new Month();

    $months = $monthHelper->getMonths(1, 3, 2021);

    $expected = [
      [
        'id' => 1,
        'name' => 'January',
        'days' => 31
      ],
      [
        'id' => 2,
        'name' => 'February',
        'days' => 28
      ],
      [
        'id' => 3,
        'name' => 'March',
        'days' => 31
      ]
    ];

    $this->assertEquals(3, count($months), 'Count does not match');
    $this->assertEquals($months, $expected, 'Expected not match');
  }
}
