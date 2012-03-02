<?php defined('SYSPATH') OR die('No direct script access.');class Migration_Install_demopages_20120302223742 extends Minion_Migration_Base {

	/**
	 * Run queries needed to apply this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function up(Kohana_Database $db)
	{
		// $db->query(NULL, 'CREATE TABLE ... ');
		//die('install_demopages!!!');
	}

	/**
	 * Run queries needed to remove this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function down(Kohana_Database $db)
	{
		// $db->query(NULL, 'DROP TABLE ... ');
	}
}
