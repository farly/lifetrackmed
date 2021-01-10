<?php

namespace app\config;

class Routes
{
	private $routes;

	public function __construct()
	{
		$this->routes = array(
			[
				'pattern' => '/cost',
				'controller' => 'src\controller\CostController',
				'method' => 'post'
			] 
		);
	}


	public function matchRoute($pattern,$method)
	{
		foreach($this->routes as $route) {
			if ($pattern === $route['pattern'] && strtolower($method) === $route['method']) {
				return $route['controller'];
			}
		}

		new \Exception('No routes found');
	}
}
