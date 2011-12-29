<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Group extends Model_Base_Group {

	public function admin_add($data)
	{
		$this->values($data);

		return $this->save();
	}

	public function admin_update($data)
	{

		if (!$this->loaded())
		{
			throw new Exception('Group is not loaded.');
		}

		$this->values($data);

		return $this->save();
	}
	
	public function admin_delete($id = NULL, & $data)
	{
		if ($id === NULL)
		{
			$data = Validate::factory($data)
				->callback('id', array($this, 'admin_check_id'));
				
			if ( !$data->check()) return FALSE;			
		}
		
		return parent::delete($id);		
	}
	
	// Don't delete id 1
	public function admin_check_id(Validate $array, $field)
	{
		if ( (int) $this->id === 1)
		{
			$array->error($field, 'delete_id_1', array($array[$field]));
		}
	}
	
} // End Model_Group
