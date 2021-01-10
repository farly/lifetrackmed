<?php

namespace src\validators;


class ProjectionFieldsValidator {

	public function __construct() {
		$this->errors = [];
	}

	public function validate($fields) {
		$this->validateMonthSelected($fields);
		$this->validateGrowth($fields);
		$this->validateDailyStudies($fields);

		return $this->errors;
	}	

	private function validateMonthSelected($fields) {
		
		if (isset($fields['startMonth']) && isset($fields['endMonth'])) {
			$startMonth = $fields['startMonth'];
			$endMonth = $fields['endMonth'];

			if ($endMonth < $startMonth) {
				$this->errors['month'][] = ['code' => 'invalid_range' , 'message' => 'Check Month range' ];
			}

			if (!is_int($startMonth)) {
				$this->errors['month'][]  = ['code' => 'invalid_start', 'message' => 'Value between 1 - 12'];
			} else {
				if ($startMonth <= 0 || $startMonth > 12) {
					$this->errors['month'][] = ['code' => 'invalid_start', 'message' => 'Value between 1 - 12'];
				}
			}

			if (!is_int($endMonth)) {
				$this->errors['month'][]  = ['code' => 'invalid_end', 'message' => 'Value between 1 - 12'];
			} else {
				if ($endMonth <= 0 || $endMonth > 12) {
					$this->errors['month'][] = ['code' => 'invalid_end', 'message' => 'Value between 1 - 12'];
				}
			}
		} else {
			$this->errors['month'][] = ['code' => 'required', 'message' => 'Value is required'];
		}

	}

	private function validateGrowth($fields) {
		if(isset($fields['growth'])) {
			$growth = $fields['growth'];

			if (!($growth >=0 && $growth <= 1)) {
				$this->errors['growth'][] = ['code' => 'invalid_input', 'message' => 'Invalid value'];
			}
				
		}	else {
			$this->errors['growth'][] = ['code' => 'required', 'message'=> 'Value is required'];
		}
	}

	private function validateDailyStudies($fields) {
		if (isset($fields['dailyStudies'])) {
			$dailyStudies = $fields['dailyStudies'];

			if (!is_int($dailyStudies)) {
				$this->errors['dailyStudies'][] = ['code' => 'invalid_input', 'message' => 'Invalid Input'];
			} else {
				if ($dailyStudies < 1) {
					$this->errors['dailyStudies'][] = ['code' => 'invalid_input', 'message' => 'Value > 0'];
				}
			}
			
		} else {
			$this->errors['dailyStudies'][] = ['code' => 'required', 'message' => 'Value is required' ];
		}
			
	}

}

