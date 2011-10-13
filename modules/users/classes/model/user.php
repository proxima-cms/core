<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends Model_Base_User {

	public function rules()
	{
		return parent::rules();

		return array_merge(
			parent::rules(), 
			array('password_confirm' =>  
				array(
					array('matches', 
						array(':validation', ':field', 'password')
					)		
				)		
			)		
		);
	}

	public function admin_add(& $data)
	{
		$roles = (array) Arr::get($data, 'roles');
		$groups = (array) Arr::get($data, 'groups');
		$rules = $this->rules();

		$data = Validation::factory($data)
			->rules('username', $rules['username'])
			->rules('email', $rules['email']);
		
		if (Arr::get($data->as_array(), 'password', '') !== '')
		{
			$data
			->rules('password', $rules['password'])
			->rules('password_confirm', $rules['password_confirm']);
		}
 
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

		$rules = $this->rules();

		$data = Validation::factory($data)
			->rules('email', $rules['email'])
			->rules('username', $rules['username']);

		if (Arr::get($data->as_array(), 'password', '') !== '')
		{
			$data
			->rules('password', $rules['password'])
			->rules('password_confirm', $rules['password_confirm']);
		}

		if (!$data->check())
		{
			return FALSE;
		}

		$this->values($data->as_array());

		$this->save();
		$this->update_roles($roles);
		$this->update_groups($groups);
				
		return $data;
	}
	
} // End Model_User
