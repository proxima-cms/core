<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Role extends Model_Auth_Role {

	/**
	* Tests if a unique key value exists in the database.
	*
	* @param	 mixed		the value to test
	* @param	 string		field name
	* @return  boolean
	*/
	public function unique_key_exists($value, $field = NULL)
	{
		 if ($field === NULL)
		 {
			 // Automatically determine field by looking at the value
			 $field = $this->unique_key($value);
		 }

		 return (bool) DB::select(array('COUNT("*")', 'total_count'))
						 ->from($this->_table_name)
						 ->where($field, '=', $value)
						 ->execute($this->_db)
						 ->get('total_count');
	}			 

	/*
	public function callback_name_available(Validate $array, $field)
	{
		 if ($this->unique_key_exists($array[$field], 'name'))
		 {
			 $array->error($field, 'role_unavailable', array($array[$field]));
		 }							 
	}
	*/

	public function admin_create($data)
	{
		$this->values($data);

		return $this->save();
	}

	public function admin_update($data)
	{
		$this->values($data);

		return $this->save();
	}
	
	public function admin_delete()
	{
		return parent::delete();
	}

	public function friendly_date()
	{
		return Date::friendly($this->date);
	}

	public function __get($key)
	{
		if ($key === 'friendly_date')
		{   
			return $this->friendly_date();
		}   

		return parent::__get($key);
	}

} // End Model_Role
