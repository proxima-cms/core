<?php defined('SYSPATH') OR die('No direct script access.');class Migration_Install_demopages_20120302223742 extends Minion_Migration_Base {

	/**
	 * Run queries needed to apply this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function up(Kohana_Database $db)
	{
		// Contact page
		$db->query(NULL, "
			INSERT INTO `pages` (`user_id`, `pagetype_id`, `parent_id`, `is_homepage`, `draft`, `visible_in_nav`, `title`, `uri`, `description`, `body`, `visible_from`, `visible_to`)
			VALUES (1, 5, 1, 0, 0, 1, 'Contact', 'contact', 'Contact page with contact form', '<p>Send me an email using the contact form below</p>', CURRENT_TIMESTAMP, NULL)"
		);

		// About page
		$db->query(NULL, "
			INSERT INTO `pages` (`user_id`, `pagetype_id`, `parent_id`, `is_homepage`, `draft`, `visible_in_nav`, `title`, `uri`, `description`, `body`, `visible_from`, `visible_to`)
			VALUES (1, 2, 1, 0, 0, 1, 'About', 'about', 'About page', '<p>View more information about me and this site.</p>', CURRENT_TIMESTAMP, NULL)"
		);
	}

	/**
	 * Run queries needed to remove this migration
	 *
	 * @param Kohana_Database Database connection
	 */
	public function down(Kohana_Database $db)
	{
		// Remove contact page
		$db->query(NULL, "DELETE FROM `pages` WHERE `uri` = 'contact'");

		// Remove about page
		$db->query(NULL, "DELETE FROM `pages` WHERE `uri` = 'about'");
	}
}
