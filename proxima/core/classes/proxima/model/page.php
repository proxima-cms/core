<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Page extends Model_Base {

	protected $_belongs_to = array(
		'parent'    => array('model' => 'page', 'foreign_key' => 'parent_id'),
		'page_type'	=> array('model' => 'page_type', 'foreign_ley' => 'pagetype_id'),
	);

	protected $_has_many = array(
		'children'	=> array('model' => 'page', 'foreign_key' => 'parent_id'),
		'tags'			=> array('model' => 'tag', 'through' => 'tags_pages'),
	);

	public function create_rules()
	{
		return array(
			'pagetype_id' => array(
				array('not_empty'),
				array('numeric'),
			),
			'description' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 128)),
			),
			'title' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 128)),
			),
		);
	}

	public function update_rules()
	{
		return array(
			'parent_id' => array(
				array('not_empty'),
				array('numeric'),
			),
			'pagetype_id' => array(
				array('not_empty'),
				array('numeric'),
			),
			'description' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 128)),
			),
			'title' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 128)),
			),
			'uri' => array(
				array(function($validation, $field, $value, $model){
					if ((int) $model->id !== 1 AND empty($value))
					{
						$validation->error($field, 'not_empty');
					}
				}, array(':validation', ':field', ':value', $this)),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128)),
			),
			'body' => array(
			),
			'visible_from' => array(
				array('not_empty'),
				array('date'),
			),
			'visible_to' => array(
				array('not_empty'),
				array('date'),
			)
		);
	}

	public function delete($id = NULL)
	{
		if ($id === NULL)
		{
			// Use the the primary key value
			$id = $this->pk();
		}

		if ( ! empty($id) OR $id === '0')
		{
			foreach ($this->children->find_all() as $child)
			{
				$child->delete();
			}

			parent::delete($id);
		}

		return $this;
	}

	public function update_tags(& $tags)
	{
		foreach(ORM::factory('tag')->find_all() as $tag)
		{
			if (in_array($tag->id, $tags))
			{
				try
				{
					$this->add('tags', new Model_Tag(array('id' => $tag->id)));
				}
				catch(Exception $e){}
			}
			else
			{
				$this->remove('tags', new Model_Tag(array('id' => $tag->id)));
			}
		}
	}

	public function search($query)
	{
		return $this->where(
			DB::expr('MATCH(page.title, page.description, page.body)'),
			'',
			DB::expr('AGAINST(' . Database::instance()->escape($query) . ')')
		);
	}

	public function admin_create($data)
	{
		$validation = Validation::factory($data);

		foreach ($this->create_rules() as $field => $rules)
		{
				$validation->rules($field, $rules);
		}

		$this->values($data);
		$this->user_id = Auth::instance()->get_user()->id;
		$this->save($validation);
		$this->generate_uri();
		$this->save();

		return $this;
	}

	public function admin_update($data)
	{
		$tags = Arr::get($data, 'tags', array());

		if (Arr::get($data, 'visible_to_forever', FALSE) !== FALSE)
		{
			$data['visible_to'] = NULL;
		}

		$validation = Validation::factory($data);

		foreach ($this->update_rules() as $field => $rules)
		{
				$validation->rules($field, $rules);
		}

		$this->values($data);
		$this->save($validation);
		$this->update_tags($tags);

		return $this;
	}

	public function admin_add_tag($data)
	{
		$name = array('name' => $data['new-tag']);
		$slug = array('slug' => URL::title($name['name']));
		$tag  = ORM::factory('tag', $name);

		if (!$tag->loaded())
		{
			try
			{
				$tag->values($name + $slug);
				$tag->save();
			}
			catch(ORM_Validation_Exception $e)
			{
				throw new Exception('Unable to save new tag. '. $e->getMessage());
			}
		}

		$this->add('tags', $tag);
	}

	public function check_parent_id(Validation $array, $field)
	{
		if ( ! (bool) $this->parent_id )
		{
			$array->error($field, 'root_reparent', array($array[$field]));
		}
	}

	// Don't delete id 1
	public function check_id(Validate $array, $field)
	{
		if ( (int) $this->id === 1)
		{
			$array->error($field, 'delete_id_1', array($array[$field]));
		}
	}

	public function admin_delete($id = NULL, $data)
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
}
