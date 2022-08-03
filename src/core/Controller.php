<?php

class Controller {
	
	public function view($view, $data = [])
	{
		require_once '../src/views/' . $view . '.php';
	}
}