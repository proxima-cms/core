<?php defined('SYSPATH') or die('No direct script access.');

class Importer_Driver_Tumblr extends Importer_Driver
{
	public function import_posts($config=array())
	{
		try
		{
			$data = simplexml_load_file($this->config['feeds']['posts'], 'SimpleXMLElement', LIBXML_NOCDATA);
		}
		catch(ErrorException $e)
		{
			throw $e;
		}

		$data = (array) $data->posts;
		$posts = $data['post'];

		return array(
			'saved' => $this->save_posts($posts),
			'total_posts' => count($posts)
		);
	}

	// Posts types: text, quote, photo, link, chat, video, audio
	public function save_posts($posts = array())
	{
		$saved = 0;

		foreach($posts as $data)
		{
			$data = (array) $data;

			// Quote post
			if (isset($data['quote-text']))
			{
				$title = $data['quote-text'];
				$intro = $body = $data['quote-text'].' - '.$data['quote-source'];
			}
			// Text post with title
			else if (isset($data['regular-title']) AND isset($data['regular-body']))
			{
				$title = $data['regular-title'];
				$intro = $body = $data['regular-body'];
			}
			// Text post with no body
			else if (isset($data['regular-title']))
			{
				$title = $intro = $body = $data['regular-title'];
			}
			// Text post with no title
			else if (isset($data['regular-body']))
			{
				$title = $intro = $body = $data['regular-body'];
			}
			// Link post with text
			else if (isset($data['link-url']) AND isset($data['link-text']))
			{
				$title = $data['link-text'];
				$intro = $body = HTML::anchor($data['link-url'], $data['link-url']).' '.@$data['link-description'];
			}
			// Link post with no text
			else if (isset($data['link-url']))
			{
				$title = $data['link-url'];
				$intro = $body = HTML::anchor($data['link-url'], $data['link-url']);
			}
			// Chat post
			else if (isset($data['conversation-title']))
			{
				$title = $data['conversation-title'];
				$intro = $body = $data['conversation-text'];
			}
			// Question post
			else if (isset($data['question']) AND isset($data['answer']))
			{
				$title = 'Question: '.$data['question'];
				$intro = $body = $data['answer'];
			}
			// Audio post
			else if (isset($data['audio-caption']) AND isset($data['audio-player']))
			{
				$title = $data['audio-caption'];
				$intro = $body = $title.' '.$data['audio-player'];
			}
			// Photo post with title
			else if (isset($data['photo-caption']) AND isset($data['photo-url']))
			{
				$title = $data['photo-caption'];
				$intro = $body = HTML::image($data['photo-url'][0]);
			}
			// Photo post with no title
			else if (isset($data['photo-url']))
			{
				$title = 'Photo on '.$data['@attributes']['unix-timestamp'];
				$intro = $body = HTML::image($data['photo-url'][0]);
			}
			// Video embed post
			else if (isset($data['video-caption']) AND isset($data['video-player']))
			{
				$title = $data['video-caption'];
				$intro = $body = $data['video-player'];
			}
			// Unsupported video post
			else {
				continue;
			}

			// Format the post title
			$title = substr(strip_tags($title), 0, 100);

			// Does the post already exist?
			$page = ORM::factory('page')->where('title', '=', $title)->find();

			if ($page->loaded())
			{
				continue;
			}

			$tags = (array) @$data['tag'];

			// Save post tag as category
			//$category_id = ($tags && $this->config['categories']) ? $this->save_post_tags($tags) : 0;
			$category_id = 0;

			// Try save the post as a page.
			$page->title = $title;
			$page->parent_id = '236';
				//'category_id' => $category_id,
				//'intro' => $intro,
			$page->body = (string) $body;
			$page->draft = (string) $this->config['status'];
			$page->pagetype_id = '4';
			$page->user_id = Auth::instance()->get_user()->id;
				//'status' => $this->config['status'],
			$page->visible_from = date('Y-m-d H:i:s', $data['@attributes']['unix-timestamp']);

			$page->generate_uri();
			
			$result = $page->save();

			if ($result)
			{
				$saved += (int) !!$result;
			}
		}

		return $saved;
	}

	public function save_post($data=array())
	{
		$id = $this->ci->blog_m->insert($data);

		if ($id)
		{
			$this->ci->cache->delete_all('ci->blog_m');
			return $id;
		}
		return false;
	}

	public function save_post_tags($tags=array())
	{
		// Use the first tag for the category
		$category = $tags[0];

		if (!$this->ci->blog_categories_m->check_title($category))
		{	
			$this->ci->blog_categories_m->insert(array('title' => $category));
		}

		$category_db = current($this->ci->db->get_where('blog_categories', array('slug' => url_title($category)))->result_array());

		return $category_db['id'];
	}
}
