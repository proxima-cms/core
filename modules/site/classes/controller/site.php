<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site extends Controller_Base {

	public function before()
	{
		$this->template = Theme::path('page');

		parent::before();
	}

	public function action_index()
	{
		$uri = (string) $this->request->param('uri');

		$cache_key = 'page-'.$uri;
/*
select 
		`page`.`id` AS `id`,
		`page`.`user_id` AS `user_id`,
		`page`.`pagetype_id` AS `pagetype_id`,
		`page`.`parent_id` AS `parent_id`,
		`page`.`is_homepage` AS `is_homepage`,
		`page`.`visible_in_nav` AS `visible_in_nav`,
		`page`.`draft` AS `draft`,
		`page`.`title` AS `title`,
		`page`.`uri` AS `uri`,
		`page`.`description` AS `description`,
		`page`.`body` AS `body`,
		`page`.`visible_from` AS `visible_from`,
		`page`.`visible_to` AS `visible_to`,
		`page`.`date` AS `date`,
		`pagetype`.`template` AS `pagetype_template`,
		`pagetype`.`name` AS `pagetype_name`,
		`pagetype`.`description` AS `pagetype_description`,
		`user`.`email` AS `user_email`,
		`user`.`username` AS `user_username`,
		GROUP_CONCAT(CAST(tags.id AS CHAR),'|',CAST(tags.user_id AS CHAR),'|',tags.name,'|',tags.slug,'|',CAST(tags.date AS CHAR)) AS tags
	FROM (
		`pages` `page` 
		join `page_types` `pagetype` on ( `page`.`pagetype_id` = `pagetype`.`id`)
		join `users` `user` on((`page`.`user_id` = `user`.`id`))
		LEFT JOIN tags_pages ON ( page.id = tags_pages.page_id )
		LEFT JOIN tags ON ( tags_pages.tag_id = tags.id )
	) 
	where (
		(`page`.`visible_from` <= now()) 
		and (isnull(`page`.`visible_to`) or (`page`.`visible_to` >= now())) 
		and (`page`.`draft` = 0)
	)
	GROUP BY page.id ;

*/
/*
$tag_fields = array(
	'tags.id',
	'tags.user_id',
	'tags.name',
	'tags.slug',
	'tags.date'
);
$tags_group_sql = DB::expr('CAST('.implode(' AS CHAR),\'|\',CAST(', $tag_fields).' AS CHAR)');

$pages = ORM::factory('page')
	->select('page.*')
	->select(array('pagetype.template', 'pagetype_template'))
	->select(array('user.email', 'user_email'))
	->select(array('user.username', 'user_username'))
	->select(DB::expr('GROUP_CONCAT('.$tags_group_sql.')'))
	->join(array('users', 'user'))
	->on('page.user_id', '=', 'user.id')
	->join(array('page_types', 'pagetype'))
	->on('page.pagetype_id', '=', 'pagetype.id')
	->join('tags_pages', 'LEFT')
	->on('page.id', '=', 'tags_pages.page_id')
	->join('tags', 'LEFT')
	->on('tags_pages.tag_id', '=', 'tags.id')
	->where('page.visible_from', '<=', DB::expr('NOW()'))
	->and_where_open()
	->where(NULL, NULL, DB::expr('isnull(page.visible_to)'))
	->or_where('page.visible_to', '>=', DB::expr('NOW()'))
	->and_where_close()
	->where('page.draft', '=', 0)
	->group_by('page.idd')
	->find_all();

		die((string)count($pages));
*/
		if (!$page = Cache::instance()->get($cache_key))
		{		
			$page = ORM::factory('site_page')->where('uri', '=', $uri)->find();
		
			if (!$page->loaded())
			{
				// Check for a page redirect.
				$redirect = ORM::factory('redirect')->where('uri', '=', $uri)->find();

				if (!$redirect->loaded())
				{
					throw new HTTP_Exception_404('Page not found.');
				}

				$target = ORM::factory($redirect->target, $redirect->target_id);

				$this->request->redirect($target->uri, 301);
			}

			Cache::instance()->set($cache_key, (object) $page->as_array());
		}		

		$this->template->set('title', Kohana::$config->load('site.title') . ' - ' . $page->title);
		$this->template->set_global('page', $page);

		$template = Theme::path('templates/'.str_replace(EXT, '', $page->pagetype_template));

		$this->template->content = View::factory($template);
	}
	
} // End Controller_Site
