<?php defined('SYSPATH') or die('No direct script access.');/**
 * Add lang field to users table
 */
class Migration_Install_20120102113535 extends Minion_Migration_Base {

	/**
	 * Run queries needed to apply this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function up(Kohana_Database $db)
	{
		// $db->query(NULL, 'CREATE TABLE ... ');
		$db->query(NULL, 'ALTER TABLE  `users` ADD  `lang` VARCHAR( 128 ) NOT NULL AFTER  `password`');
	}

	/**
	 * Run queries needed to remove this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function down(Kohana_Database $db)
	{
		$db->query(NULL, 'ALTER TABLE `users` DROP `lang`');
	}
}
