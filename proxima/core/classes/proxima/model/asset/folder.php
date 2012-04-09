<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Asset folder model
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Model_Asset_Folder extends Model_Base {

	public $_table_name = 'assets_folders';

	protected $_belongs_to = array(
		'parent' => array('model' => 'asset_folder', 'foreign_key' => 'parent_id'),
	);

	protected $_has_many = array(
		'children' => array('model' => 'asset_folder', 'foreign_key' => 'parent_id'),
		'assets' => array('model' => 'assets', 'foreign_key', 'folder_id')
	);

	public function rules()
	{
		return array(
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
}
