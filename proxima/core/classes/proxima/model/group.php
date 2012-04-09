<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Group model
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Model_Group extends Model_Base {

	protected $_has_many = array(
		'users'    => array('through' => 'groups_users'),
		'children' => array('model' => 'group', 'foreign_key' => 'parent_id')
	);
	protected $_belongs_to = array(
		'parent' => array('model' => 'group', 'foreign_key' => 'parent_id'),
	);

	public function rules()
	{
		return array(
		 'parent_id' => array(
				array('not_empty'),
			),
			'name' => array(
				array('not_empty'),
				array('max_length', array(':value', array(255))),
			)
		);
	}

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
