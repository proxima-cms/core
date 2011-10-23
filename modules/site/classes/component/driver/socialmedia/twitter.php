<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_SocialMedia_Twitter extends Component_Component {

	public $_default_config = array(
		'username' => NULL,
		'max_amount' => 5,
	);	

	public function render()
	{
		$cache_key = 'socialmedia-twitter-'.$this->_config['username'];

		if (!$tweets = Cache::instance()->get($cache_key))
		{		
			try
			{
				$tweets = file_get_contents('http://twitter.com/status/user_timeline/'.$this->_config['username'].'.json');
			}
			catch(ErrorException $e)
			{
				return __('There was an error loading the tweets.');
			}

			Cache::instance()->set($cache_key, $tweets, 24 * 60 * 60);
		}

		return View::factory(Theme::path('components/socialmedia/twitter'))
			->set('tweets', json_decode($tweets))
			->set('username', $this->_config['username'])
			->set('max_amount', $this->_config['max_amount'])
			->render();
	}
}
