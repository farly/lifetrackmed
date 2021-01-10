<?php

namespace tests\src\helper;

use PHPUnit\Framework\TestCase;

use src\helper\Year;

class YearTest extends TestCase {

	public function testIsLeapYear() {

		$leapYears = [
			2000, 2004, 2008, 2012, 2016, 2020, 2024
		];

		foreach($leapYears as $year) {
			$isLeapYear = Year::isLeapYear($year);
			$this->assertTrue($isLeapYear);
		}
	}

	public function testNotLeapYears() {
		$years = [1700, 1800, 1900];

		foreach($years as $year) {
			$isLeapYear = Year::isLeapYear($year);
			$this->assertFalse($isLeapYear);
		}
	}
		
}
