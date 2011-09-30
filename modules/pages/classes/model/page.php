<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page extends Model_Base_Page {

	public function admin_add(& $data)
	{
		$tags = Arr::get($data, 'tags', array());

		$data = Validation::factory($data);

		$fields = array(
			'parent_id',
			'pagetype_id',
			'title',
			'description',
			'uri',
			'body',
			'visible_from',
			'visible_to'
		);
		foreach($fields as $field)
		{
			$data->rules($field, $this->_rules[$field]);
		}

		if (!$data->check())
		{
			return FALSE;
		}

		$this->values($data->as_array());
		#$this->user_id = Auth::instance()->get_user()->id;
		$this->save();

    foreach($tags as $tag)
    {   
      $this->add('tags', new Model_Tag(array('id' => $tag)));
    }   

		return $data;
	}
	
	public function admin_update(& $data)
	{
		$tags = Arr::get($data, 'tags', array());

		$data = Validation::factory($data);

		$fields = array(
			'parent_id',
			'pagetype_id',
			'title',
			'description',
			'uri',
			'body',
			'visible_from',
			'visible_to'
		);
		foreach($fields as $field)
		{
			$data->rules($field, $this->_rules[$field]);
		}
		
		if ( !$data->check())
		{
			return FALSE;
		}

		$data = $data->as_array();

		$this->values($data);
		$this->save();
		$this->update_tags($tags);
				
		return $data;
	}
	
	public function admin_check_parent_id(Validation $array, $field)
	{
		if ( ! (bool) $this->parent_id )
		{
			$array->error($field, 'root_reparent', array($array[$field]));
		}
	}
	
	// Don't delete id 1
	public function admin_check_id(Validate $array, $field)
	{
		if ( (int) $this->id === 1)
		{
			$array->error($field, 'delete_id_1', array($array[$field]));
		}
	}
	
	public function admin_delete($id = NULL, & $data)
	{
		if ($id === NULL)
		{
			$data = Validation::factory($data);
				//->callback('id', array($this, 'admin_check_id'));
				
			if ( !$data->check()) return FALSE;			
		}
		
		return parent::delete($id);		
	}
} // End Model_Page
