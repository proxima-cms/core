<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mimetype model
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Model_Mimetype extends Model_Base {

	protected $_has_many = array(
		'assets' => array('model' => 'asset'),
	);

}
