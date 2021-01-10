<?php

namespace src\controller;

abstract class Controller 
{
  public function execute($method, $parameters) {
    if (strtolower($method) === 'post') {
      return $this->post($parameters);
    }
  }

  abstract protected function post($parameters);
}