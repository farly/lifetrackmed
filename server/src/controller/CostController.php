<?php

namespace src\controller; 

use src\helper\Month as MonthHelper;
use src\helper\Year;
use src\lib\CostCalculator;
use src\lib\RamCalculator;
use src\lib\StorageCalculator;
use src\validators\ProjectionFieldsValidator;

class CostController extends Controller 
{
	public function __construct() {
		// not ideal but should work
		// DI is perfect
		$this->costCalculator = new CostCalculator(new MonthHelper);
		$this->costCalculator->setDependency(new RamCalculator, new StorageCalculator);

		$this->validator = new ProjectionFieldsValidator;
	}

  protected function post($parameters) {
		$errors = $this->validator->validate($parameters); 

		if (count($errors)) {
			return [
				'data' => [],
				'errors' => $errors
			];
		}

		if(!isset($parameters['year'])) {
			$parameters['year'] = date('Y');
		}

		extract($parameters);
			
		$costs = $this->costCalculator->getMonthlyProjections($startMonth, $endMonth, $year, $dailyStudies, $growth);
		return [
			'data' => $costs,
			'errors' => []
		];
  }
}
