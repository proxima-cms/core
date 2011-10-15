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
		);
		foreach($fields as $field)
		{
			$data->rules($field, $this->_rules[$field]);
		}

		if (!$data->check())
		{
			return FALSE;
		}

		$post = $data->as_array();
		$post['uri'] = NULL;

		$this->values($post);
		$this->user_id = Auth::instance()->get_user()->id;
		$this->save();

		$this->generate_uri();

		return $this->save();
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

		if (Arr::get($data, 'visible_to_forever', FALSE) !== FALSE)
		{
			$data['visible_to'] = NULL;
		}

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

	public function generate_uri($prefix = NULL)
	{
		if ($this->is_homepage)
		{
			$page_uri = '';
		}
		else
		{
			$prefixes = array();

			if ($prefix !== NULL AND $prefix !== '')
			{
				$prefixes = array($prefix);
			}
			else if ($prefix === NULL AND (int) $this->parent_id > 0)
			{		
				$parent_page = ORM::factory('page', (int) $this->parent_id);

				if ($parent_page->loaded() AND $parent_page->uri)
				{		
					$prefixes = array($parent_page->uri);
				}		
			}		

			$prefixes[] = URL::title($this->title, '-');

			$page_uri = $orig_uri = join($prefixes, '/');

			$c = 1;
			while(
				ORM::factory('page')
				->where('uri', '=', $page_uri)
				->where('id', '<>', $this->id)
				->find()
				->loaded())
			{		
				$c++;
				$page_uri = $orig_uri.$c;
			}

			$this->uri = $page_uri;
		}

		return $page_uri;
	}
} // End Model_Page
