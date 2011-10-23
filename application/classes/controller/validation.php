<?php

class Controller_Validation extends Controller {

	public function action_index()
	{

		function validate_name($name)
		{
			return ($name === 'John');
		}

		$data = array(
			'name'		=> 'Richard',
			'email'		=> 'willis.rh@gmail.com',
			'url'			=> 'htt://badsyntax.co'
		);

		$validate = Validation::factory($data)
			->rule('email', 'email')
			->rule('url', 'url')
			->rule('name', 'validate_name');

		if (!$validate->check())
		{
			die(print_r($validate->errors('validation')));
		}
		else
		{
			die('no errors');
		}
	}

}
