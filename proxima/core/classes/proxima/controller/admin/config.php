<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin config controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Config extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template
			->title(__('Admin - Config'))
			->content(
				View_Model::factory('admin/page/config/index')
				->bind('config', $config)
				->bind('errors', $errors)
			);

		$group_filter = $this->request->param('group');

		$config = array();
		$post = $this->request->post();

		$db_config = ORM::factory('config')->find_all();

		foreach($db_config as $item)
		{
			if ($group_filter !== NULL AND $item->group_name !== $group_filter)
			{
				continue;
			}

			if (!isset($config[$item->group_name]))
			{
				$config[$item->group_name] = array();
			}

			$config[$item->group_name][] = $item;
		}

		if ($this->request->method() === Request::POST)
		{
			try
			{
				// Try save the config
				ORM::factory('config')->update_all($post);

				Message::set(Message::SUCCESS, __('Config successfully saved.'));

				// Delete the configuration data from cache
				Cache::instance()->delete(Config_Database::$_cache_key);

				// Redirect to prevent POST refresh
				$this->request->redirect($this->request->uri());
			}
			catch (Kohana_Validation_Exception $e)
			{
				Message::set(Message::ERROR, __('Please correct the errors'));
			}
		}
	}

} // End Controller_Admin_Config
