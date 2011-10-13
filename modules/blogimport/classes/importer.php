<?php  

abstract class Importer
{

	public static function factory($driver=NULL, $config)
	{

		$importer_feeds = Kohana::$config->load('admin/blogimport');

		$config['feeds'] = array();

		foreach($importer_feeds[strtolower($driver)] as $type => $feed)
		{
			$config['feeds'][$type] = sprintf($feed, $config['blog_url']);
		}
 
		$importer = 'Importer_Driver_'.ucfirst($driver);

		return new $importer($config);
	}

}
