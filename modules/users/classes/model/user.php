<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends Model_Base_User {

	public function admin_add(& $data)
	{
		$roles = (array) Arr::get($data, 'roles');
		$groups = (array) Arr::get($data, 'groups');
		$rules = $this->rules();

		$data = Validation::factory($data)
			->rules('password', $rules['password'])
			->rules('username', $rules['username'])
			->rules('email', $rules['email']);
			//->rules('password_confirm', $rules['password_confirm']);
 
 		/*
		foreach($this->_callbacks['username'] as $callback)
		{
			$data->callback('username', array($this, $callback));
		} 
		foreach($this->_callbacks['email'] as $callback)
		{
			$data->callback('email', array($this, $callback));
		}	
		*/
 
		if (!$data->check())
		{
			return FALSE;
		}

		$this->values($data->as_array());
		$this->save();

		foreach($roles as $role)
		{
			$this->add('roles', new Model_Role(array('id' => $role)));
		}	
		foreach($groups as $group)
		{
			$this->add('groups', new Model_Group(array('id' => $group)));
		}	
		
		return $data;
	}

	public function admin_update(& $data)
	{
		$roles = (array) Arr::get($data, 'roles');
		$groups = (array) Arr::get($data, 'groups');

		$rules = array_merge(
			$this->rules(), 
			array('password_confirm' => 
				array(
					array('matches', 
						array(':validation', ':field', 'password')
					)
				)
			)
		);

		$data = Validation::factory($data)
			->rules('email', $rules['email'])
			->rules('username', $rules['username'])
			->rules('password', $rules['password'])
			->rules('password_confirm', $rules['password_confirm']);

		if (!$data->check())
		{
			return FALSE;
		}

		$this->values($data->as_array());

		//die(print_r($this->as_array()));
		$this->save();
		$this->update_roles($roles);
		$this->update_groups($groups);
				
		return $data;
	}
	
} // End Model_User
