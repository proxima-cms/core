<?php defined('SYSPATH') or die('No direct script access.');

class Migration_Blogimport_20111230151635 extends Minion_Migration_Base {

	/**
	 * Run queries needed to apply this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function up(Kohana_Database $db)
	{
		//$db->query(NULL, "");
	}

	/**
	 * Run queries needed to remove this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function down(Kohana_Database $db)
	{
		//$db->query(NULL, '');
	}
}
