<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Component model
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Model_Component extends Model_Base {

	protected $_belongs_to = array(
		'user' => array('model' => 'user', 'foreign_key' => 'user_id'),
		'type' => array('model' => 'component_type', 'foreign_key' => 'type_id'),
	);

	public function rules()
	{
		return array(
			'data' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
			),
		);
	}

	public function data()
	{
		return json_decode($this->data);
	}

	public function admin_add($data)
	{
		$this->values($data);
		$this->user_id = Auth::instance()->get_user()->id;
		$this->save();

		return $this;
	}

	public function admin_update($data)
	{
		if (!$this->loaded())
		{
			throw new Exception('Component not found');
		}

		$this->values($data);
		$this->save();

		return $this;
	}

} // End Model_Component
