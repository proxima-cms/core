<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The core Proxima CMS helper class. Provides low-level
 * helper methods, mostly CMS init helpers.
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Core {

	/**
	 * @var  string  True if Proxima is installed
	 */
	public static $is_installed = TRUE;

	/**
	* Core system init: application config and setup.
	* This function is called once within bootstrap.php
	*
	* @return  void
	*/
	public static function init()
	{
		// Run a check to see if Proxima is installed.
		// We probably want to handle this in a config file!
		self::$is_installed = (bool) Database::instance()->query(Database::SELECT, 'SHOW TABLES LIKE "users"')->count();

		// Set default config
		Cache::$default = Kohana::$config->load('default.cache.driver');
		Image::$default_driver = Kohana::$config->load('default.image.driver');
		Cookie::$salt = Kohana::$config->load('default.cookie.salt');

		if ( !Kohana::$is_cli )
		{
			if (Proxima::$is_installed)
			{
				// Attach the database config reader.
				Kohana::$config->attach(new Config_Database);

				if ( ! Route::cache())
				{
					// Set the core application routes
					include_once CORPATH.'config/routes'.EXT;
				}
			}
			else
			{
				// Set the install route
				Route::set('install', 'install(/<action>)')
					->defaults(array(
						'controller' => 'install',
						'action' => 'index',
				));
			}

			// Create the main request site request
			$request = Request::factory();

			// Allowed install controllers
			$install_controller = in_array($request->controller(), array('install', 'media'));

			$can_install = (bool) Kohana::$config->load('install.can_install_uninstall');

			// Check if we need to install
			if ( (!Proxima::$is_installed AND !$install_controller) OR ($can_install AND !$install_controller) )
			{
				$request->redirect('install?return_to='.$request->uri());
			}
		}
		else
		{
			// Create the CLI request
			$request = Request::factory();
		}

		/**
		 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
		 * If no source is specified, the URI will be automatically detected.
		 */
		echo $request->execute()->send_headers()->body();
	}

	/**
	 * Generates and returns the admin navigation markup
	 *
	 * @return	string  $html
	 */
	public static function admin_nav()
	{
	  $uri_segments = explode('/', Request::current()->uri());
		$links = Kohana::$config->load('admin/nav.links');
		$html = '<ul class="nav">';
		
		foreach($links as $url => $page)
		{
			$has_dropdown = ( isset($page['pages']) || isset($page['groups']) );

			$classes = ($url === Request::current()->uri() OR $url === $uri_segments[0].'/'.@$uri_segments[1])
				? 'active '
				: '';
			$classes .= $has_dropdown ? 'dropdown' : '';

			$html .= '<li class="'.$classes.'">';
			$html .= HTML::anchor(
					$url,
					$page['text'] . ($has_dropdown ? ' <b class="caret"></b>' : ''),
					array(
						'data-toggle' => ($has_dropdown ? 'dropdown' : ''),
						'class' => ($has_dropdown ? 'dropdown-toggle' : '')
					));
			
			if ($has_dropdown)
			{
				$html .= '<ul class="dropdown-menu">';
				
				
				if (isset($page['pages']))
				{
					foreach($page['pages'] as $suburl => $p)
					{
						$html .= '<li>'.HTML::anchor($suburl, $p['text']).'</li>';
					}
				}
				
				if(isset($page['groups']))
				{
					foreach($page['groups'] as $group => $pages)
					{
						$html .= '<li class="nav-header">'.ucfirst($group).'</li>';

						foreach($pages as $suburl => $p)
						{
							$html .= '<li>'.HTML::anchor($suburl, $p['text']).'</li>';
						}
					}
				}
				$html .= '</ul>';
			}
			$html .= '</li>';
		}

		$html .= '</ul>';

		return $html;
	}

	/**
	 * Returns the media path for a given file/s
	 *
	 * @param		mixed		$file		File name
	 * @param		bool		$root		Add the root application path?
	 * @return	mixed   $paths
	 */
	public static function media($file = NULL, $root = 'proxima')
	{
		$root .= '/';

		// If we have an array of media files
		if (is_array($file))
		{
			$files = array();

			foreach($file as $f)
			{
				$files[] = Media::uri($root.$f);
			}

			return $files;
		}

		return Media::uri($root.$file);
	}
}
