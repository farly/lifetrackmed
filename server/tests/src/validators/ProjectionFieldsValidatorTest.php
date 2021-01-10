<?php

namespace tests\src\validators;

use PHPUnit\Framework\TestCase;

use src\validators\ProjectionFieldsValidator;

class ProjectionFieldsValidatorTest extends TestCase {

	public function setup() {
		$this->parameters = [
			'startMonth' => 1,
			'endMonth' => 2,
			'dailyStudies' => 100,
			'growth' => .1
		];
	}

	public function testMonthSelected() {
		$validator = new ProjectionFieldsValidator;
		$errors = $validator->validate($this->parameters);
		$this->assertFalse(isset($errors['month']));

		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['startMonth'] = 0;
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['month']));

		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['endMonth'] = 0;
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['month']));

		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['startMonth'] = "1";
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['month']));

		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['endMonth'] = "1";
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['month']));

		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		unset($clonedParameters['startMonth']);
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['month']));

		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		unset($clonedParameters['endMonth']);
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['month']));
 	}

	public function testGrowth() {
		$validator = new ProjectionFieldsValidator;
		$errors = $validator->validate($this->parameters);
		$this->assertFalse(isset($errors['growth']));
		
		// not a number
		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['growth'] = "33";
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['growth']));
		// less 0
		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['growth'] = -2;
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['growth']));

    // though possible let us limit to 1 at max	
		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['growth'] = 22;
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['growth']));
	}

	public function testDailyStudies() {
		$validator = new ProjectionFieldsValidator;
		$errors = $validator->validate($this->parameters);
		$this->assertFalse(isset($errors['dailyStudies']));
		
		// not a number
		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['dailyStudies'] = "33";
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['dailyStudies']));
		// less 0
		$validator = new ProjectionFieldsValidator;
		$clonedParameters = $this->parameters;
		$clonedParameters['dailyStudies'] = -2;
		$errors = $validator->validate($clonedParameters);
		$this->assertTrue(isset($errors['dailyStudies']));
	}

}
