<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Redirect model
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Model_Redirect extends Model_Base {

	public function rules()
	{
		return array(
			'uri' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 255)),
				//array('url'),
			),
			'target' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 64)),
			),
			'target_id' => array(
				array('not_empty'),
				array('numeric'),
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
		$this->values($data);

		return $this->save();
	}

	public function admin_delete()
	{
		return parent::delete();
	}
} // End Model_Redirect
