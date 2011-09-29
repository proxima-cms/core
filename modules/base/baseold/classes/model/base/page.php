<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Base page model
 */
class Model_Base_Page extends Model_Base {
	
	protected $_belongs_to = array(
		'parent' => array('model' => 'page', 'foreign_key' => 'parent_id'),
	);	
	
	protected $_has_many = array(
		'children'	=> array('model' => 'page', 'foreign_key' => 'parent_id'),
		'tags'			=> array('model' => 'tag', 'through' => 'tags_pages'),
	);

	// Validation rules
	protected $_rules = array(
		'parent_id' => array(
			array('not_empty'),
		),
		'description' => array(
			array('not_empty'),
			array('min_length', array(':value', 4)),
			array('max_length', array(':value', 128)),
		),
		'title' => array(
			array('not_empty'),
			array('min_length', array(':value', 4)),
			array('max_length', array(':value', 32)),
		),
		'uri' => array(
			array('not_empty'),
			array('min_length', array(':value', 3)),
			array('max_length', array(':value', 128)),
			array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
		),
		'body' => array(
			array('trim'),
			array('not_empty'),
		),
		'visible_from' => array(
			array('trim'),
			array('not_empty')
		),
		'visible_to' => array(
			array('trim')
		)
	);
	
	// Validation callbacks
	protected $_callbacks = array(
		
	);
	
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
    foreach(ORM::factory('tag')->find_all() as $tag) {

      if (in_array($tag->id, $tags)) {

        try {
          $this->add('tags', new Model_Tag(array('id' => $tag->id)));

        } catch(Exception $e){}

      } else {
        $this->remove('tags', new Model_Tag(array('id' => $tag->id)));
      }   
    }   
  }
	
	
} // End Model_Base_Page
