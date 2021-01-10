<?php

namespace tests\src\controller;

use PHPUnit\Framework\TestCase;

use src\controller\CostController;

class ConstControllerTest extends TestCase {

	public function testPost() {
		$parameters = [
			'startMonth' => 1,
			'endMonth' => 2,
			'dailyStudies' => 1000,
			'growth' => .1
		];
		
		$controller = new CostController();
		$response = $controller->execute('post', $parameters); 		

		$data = $response['data'];
		$this->assertEquals(count($data), 2);
		$this->assertTrue(isset($data['monthly']));
		$this->assertTrue(isset($data['total']));
		$this->assertEquals(count($response['errors']), 0);

		foreach($data['monthly'] as $monthProjection) {
			$this->assertTrue(isset($monthProjection['ram']));
			$this->assertTrue(isset($monthProjection['disk']));
			$this->assertTrue(isset($monthProjection['year']));
			$this->assertTrue(isset($monthProjection['key']));
			$this->assertTrue(isset($monthProjection['total']));
			$this->assertTrue(isset($monthProjection['total_studies']));
			$this->assertEquals($monthProjection['year'], date('Y'));
		}
	}

	public function testPostWithYear() {
		$parameters = [
			'startMonth' => 1,
			'endMonth' => 2,
			'dailyStudies' => 1000,
			'growth' => .1,
			'year' => 2023 
		];

		$controller = new CostController();
		$response = $controller->execute('post', $parameters); 		

		$data = $response['data'];
		$this->assertEquals(count($data), 2);
		$this->assertTrue(isset($data['monthly']));
		$this->assertTrue(isset($data['total']));
		$this->assertEquals(count($response['errors']), 0);

		foreach($data['monthly'] as $monthProjection) {
			$this->assertEquals($monthProjection['year'], 2023);
		};
	}

	public function testPostInvalid() {
		$parameters = [];

		$controller = new CostController;
		$response = $controller->execute('post', $parameters);

		$this->assertEquals(count($response['data']), 0);
		$this->assertTrue(count($response['errors']) > 0);
	}
}
