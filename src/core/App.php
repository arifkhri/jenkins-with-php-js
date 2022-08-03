<?php

class App{

	protected $controller = 'home';
	protected $method = 'index';
	protected $params = [];

	public function __construct(){
		require_once '../src/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller;

		// call the controller
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

}