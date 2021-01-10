<?php

namespace src\helper;

class Year
{
	public static function isLeapYear($year) {
		return !($year % 4) && ($year % 100 || !($year % 400)); 
	}
}
